<?php
namespace maks757\articles\frontend\widgets;

use maks757\articles\common\entities\Article;
use maks757\articles\common\entities\Category;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ArticlesNav extends Menu
{
    /**
     * @var string
     */
    public $activeItemTemplate = '<a style="background-color: {color}">{label}</a>';

    public $linkTemplate = '<a href="{url}" style="background-color: {color}">{label}</a>';

    /**
     * @var string
     */
    public $renderArticles = true;

    /**
     * @var string
     */
    public $renderCategories = true;

    /**
     * @var integer Parent category to start
     */
    public $categoryId = null;

    public function init()
    {
        if($this->renderCategories) {
            $categories = Category::findAll([
                'parent_id' => $this->categoryId,
                'show' => true
            ]);
            $this->items = array_merge($this->items, $this->handleCategories($categories));
        }

        if($this->renderArticles) {
            $articles = Article::find()
                ->where([
                    'category_id' => $this->categoryId,
                    'show' => true
                ])
                ->orderBy(['position' => SORT_ASC])
                ->all();
            $this->items = array_merge($this->items, $this->handleArticles($articles));
        }

        parent::init();
    }

    protected function renderItem($item)
    {
        if($this->isItemActive($item)) {
            $template = $this->activeItemTemplate;
        }
        else {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        }

        return strtr($template, [
            '{url}' => Html::encode(Url::to($item['url'])),
            '{label}' => $item['label'],
            '{color}' => $item['color']
        ]);
    }


    private function handleCategories($categories) {
        $items = [];
        if(!empty($categories)) {
            foreach ($categories as $category) {
                if($this->renderCategories) {

                    $item = [
                        'label' => $category->translation->name,
                        'url' => [
                            '/articles/category/index',
                            'id' => $category->id
                        ],
                        'color' => $category->color
                    ];

                    $childItems = $this->handleCategories($category->children);

                    if($this->renderArticles) {
                        $childItems = array_merge($childItems, $this->handleArticles($category->articles));
                    }

                    if (!empty($childItems)) {
                        $item['items'] = $childItems;
                    }

                    $items[] = $item;
                }
                else {
                    return array_merge($this->handleCategories($category->children), $this->handleArticles($category->articles));
                }
            }
        }
        return $items;
    }

    private function handleArticles($articles) {
        $items = [];
        if(!empty($articles)) {
            foreach ($articles as $article) {
                $item = [
                    'label' => $article->translation->name,
                    'url' => [
                        '/articles/article/index',
                        'id' => $article->id,
                        'color' => $article->color
                    ]
                ];

                $this->isItemActive($item);

                $items[] = $item;
            }
        }
        return $items;
    }

}