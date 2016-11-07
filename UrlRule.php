<?php
namespace maks757\articles;

use maks757\articles\common\entities\Article;
use maks757\articles\common\entities\ArticleTranslation;
use maks757\articles\common\entities\Category;
use maks757\articles\common\entities\CategoryTranslation;
use maks757\multilang\entities\Language;
use bl\seo\entities\SeoData;
use Yii;
use yii\base\Object;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class UrlRule extends Object implements UrlRuleInterface
{
    public $prefix = '';

    private $pathInfo;
    private $routes;
    private $routesCount;
    private $currentLanguage;

    private $articleRoute = 'articles/article/index';
    private $categoryRoute = 'articles/category/index';

    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|bool the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     * @throws NotFoundHttpException
     */
    public function parseRequest($manager, $request) {
        $this->currentLanguage = Language::getCurrent();
        $this->pathInfo = $request->getPathInfo();

        if(($this->pathInfo == $this->articleRoute || $this->pathInfo == $this->categoryRoute)) {
            throw new NotFoundHttpException();
        }

        if(!empty($this->prefix)) {
            if(strpos($this->pathInfo, $this->prefix) === 0) {
                $this->pathInfo = substr($this->pathInfo, strlen($this->prefix));
            }
            else {
                return false;
            }
        }


        $this->initRoutes($this->pathInfo);

        $categoryId = null;

        for($i = 0; $i < $this->routesCount; $i++) {
            if($i === $this->routesCount - 1) {
                if($article = $this->findArticleBySeoUrl($this->routes[$i], $categoryId, ['show' => true])) {
                    return [
                        '/articles/article/index',
                        ['id' => $article->id]
                    ];
                }
                else {
                    if($category = $this->findCategoryBySeoUrl($this->routes[$i], $categoryId, ['show' => true])) {
                        return [
                            '/articles/category/index',
                            ['id' => $category->id]
                        ];
                    }
                    else {
                        return false;
                    }
                }
            }
            else {
                if($category = $this->findCategoryBySeoUrl($this->routes[$i], $categoryId, ['show_articles' => true])) {
                    $categoryId = $category->id;
                }
                else {
                    return false;
                }
            }
        }

        return false;
    }

    private function initRoutes($pathInfo) {
        $this->routes = explode('/', $pathInfo);
        $this->routesCount = count($this->routes);
    }

    private function findArticleBySeoUrl($seoUrl, $categoryId, $options = []) {
        $articlesSeoData = SeoData::find()
            ->where([
                'entity_name' => ArticleTranslation::className(),
                'seo_url' => $seoUrl
            ])->all();

        if($articlesSeoData) {
            foreach($articlesSeoData as $articleSeoData) {
                if($article = Article::find()
                    ->joinWith('translations translation')
                    ->where(array_merge([
                        'translation.id' => $articleSeoData->entity_id,
                        'category_id' => $categoryId,
                        'translation.language_id' => $this->currentLanguage->id
                    ], $options))->one()) {
                    return $article;
                }
            }
        }
        return null;
    }

    private function findCategoryBySeoUrl($seoUrl, $parentId, $options = []) {

        $categoriesSeoData = SeoData::find()
            ->where([
                'entity_name' => CategoryTranslation::className(),
                'seo_url' => $seoUrl
            ])->all();

        if($categoriesSeoData) {
            foreach($categoriesSeoData as $categorySeoData) {
                if($category = Category::find()
                    ->joinWith('translations translation')
                    ->where(array_merge([
                        'translation.id' => $categorySeoData->entity_id,
                        'parent_id' => $parentId,
                        'translation.language_id' => $this->currentLanguage->id
                    ], $options))->one()) {
                    return $category;
                }
            }
        }

        return null;
    }

    /**
     * Creates a URL according to the given route and parameters.
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        if(($route == $this->articleRoute || $route == $this->categoryRoute) && !empty($params['id'])) {
            $id = $params['id'];
            $pathInfo = '';
            $parentId = null;
            $language = Language::findOne([
                'lang_id' => $manager->language
            ]);

            if($route == $this->articleRoute) {
                $article = Article::findOne($id);
                if($article->getTranslation($language->id) && $article->getTranslation($language->id)->seoUrl) {
                    $pathInfo = $article->getTranslation($language->id)->seoUrl;
                    $parentId = $article->category_id;
                }
                else {
                    return false;
                }
            }
            else if($route == $this->categoryRoute) {
                $category = Category::findOne($id);
                if($category->getTranslation($language->id) && $category->getTranslation($language->id)->seoUrl) {
                    $pathInfo = $category->getTranslation($language->id)->seoUrl;
                    $parentId = $category->parent_id;
                }
                else {
                    return false;
                }
            }

            while($parentId != null) {
                $category = Category::findOne($parentId);
                if($category->getTranslation($language->id) && $category->getTranslation($language->id)->seoUrl) {
                    $pathInfo = $category->getTranslation($language->id)->seoUrl . '/' . $pathInfo;
                    $parentId = $category->parent_id;
                }
                else {
                    return false;
                }
            }

            if(!empty($this->prefix)) {
                $pathInfo = $this->prefix . $pathInfo;
            }

            return $pathInfo;
        }

        return false;
    }
}