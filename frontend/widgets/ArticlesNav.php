<?php
namespace bl\articles\frontend\widgets;

use bl\articles\common\entities\Article;
use bl\articles\common\entities\Category;
use Yii;
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
    public $activeItemTemplate = '<span>{label}</span>';

    /**
     * @var integer Parent category to start
     */
    public $categoryId = null;

    public function init()
    {
        $categories = Category::findAll([
            'parent_id' => $this->categoryId,
            'show' => true
        ]);

        $articles = Article::find()
            ->where([
                'category_id' => $this->categoryId,
                'show' => true
            ])
            ->orderBy(['position' => SORT_ASC])
            ->all();

        $this->items = array_merge($this->items, $this->handleCategories($categories), $this->handleArticles($articles));

        parent::init();
    }

    protected function renderItem($item)
    {
        if($this->isItemActive($item)) {
            return strtr($this->activeItemTemplate, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        }
        return parent::renderItem($item);
    }


    private function handleCategories($categories) {
        $items = [];
        if(!empty($categories)) {
            foreach ($categories as $category) {
                $item = [
                    'label' => $category->translation->name,
                    'url' => [
                        '/articles/category/index',
                        'id' => $category->id
                    ]
                ];

                $childItems = array_merge($this->handleCategories($category->children), $this->handleArticles($category->articles));

                if(!empty($childItems)) {
                    $item['items'] = $childItems;
                }

                $items[] = $item;
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
                        'id' => $article->id
                    ]
                ];

                $this->isItemActive($item);

                $items[] = $item;
            }
        }
        return $items;
    }

}