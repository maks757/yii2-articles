<?php
namespace bl\articles;

use bl\articles\common\entities\Article;
use bl\articles\common\entities\ArticleTranslation;
use bl\articles\common\entities\Category;
use bl\articles\common\entities\CategoryTranslation;
use bl\seo\entities\SeoData;
use yii\base\Object;
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

    public function init()
    {
        $request = \Yii::$app->getRequest();

        $this->pathInfo = $request->getPathInfo();
        $this->initRoutes($this->pathInfo);
    }


    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request) {

        if(!empty($this->prefix)) {
            if(strpos($this->pathInfo, $this->prefix) === 0) {
                $this->initRoutes(substr($this->pathInfo, strlen($this->prefix)));
            }
            else {
                return false;
            }
        }

        $categoryId = null;

        for($i = 0; $i < $this->routesCount; $i++) {
            if($i === $this->routesCount - 1) {
                if($article = $this->findArticle($this->routes[$i], $categoryId)) {
                    return [
                        '/articles/article/index',
                        ['id' => $article->id]
                    ];
                }
                else {
                    if($category = $this->findCategory($this->routes[$i], $categoryId)) {
                        return [
                            'categories/index',
                            ['id' => $category->id]
                        ];
                    }
                    else {
                        return false;
                    }
                }
            }
            else {
                if($category = $this->findCategory($this->routes[$i], $categoryId)) {
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

    private function findArticle($seoUrl, $categoryId) {
        $articlesSeoData = SeoData::find()
            ->where([
                'entity_name' => ArticleTranslation::className(),
                'seo_url' => $seoUrl
            ])->all();

        if($articlesSeoData) {
            foreach($articlesSeoData as $articleSeoData) {
                return Article::find()
                    ->joinWith('translations translation')
                    ->where([
                        'translation.id' => $articleSeoData->entity_id,
                        'category_id' => $categoryId
                    ])->one();
            }
        }
        return null;
    }

    private function findCategory($seoUrl, $parentId) {

        $categoriesSeoData = SeoData::find()
            ->where([
                'entity_name' => CategoryTranslation::className(),
                'seo_url' => $seoUrl
            ])->all();

        if($categoriesSeoData) {
            foreach($categoriesSeoData as $categorySeoData) {
                return Category::find()
                    ->joinWith('translations translation')
                    ->where([
                        'translation.id' => $categorySeoData->entity_id,
                        'parent_id' => $parentId
                    ])->one();
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
        if($route == 'articles/index' || $route == 'category/index') {

        }
        return false;
    }
}