<?php

use yii\db\Migration;

class m161025_151940_fix_permission_names extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $viewCategoryList = $auth->getPermission('viewCategoryList');
        $editCategories = $auth->getPermission('editCategories');
        $deleteCategories = $auth->getPermission('deleteCategories');

        $categoryManager = $auth->getRole('articleCategoryManager');
        $auth->removeChildren($categoryManager);

        $auth->remove($viewCategoryList);
        $auth->remove($editCategories);
        $auth->remove($deleteCategories);

        $viewCategoryList = $auth->createPermission('viewArticleCategoryList');
        $viewCategoryList->description = 'View shop category list';
        $auth->add($viewCategoryList);

        $editCategories = $auth->createPermission('editArticleCategories');
        $editCategories->description = 'Edit shop category';
        $auth->add($editCategories);

        $deleteCategories = $auth->createPermission('deleteArticleCategories');
        $deleteCategories->description = 'Delete shop categories';
        $auth->add($deleteCategories);

        $auth->addChild($categoryManager, $viewCategoryList);
        $auth->addChild($categoryManager, $editCategories);
        $auth->addChild($categoryManager, $deleteCategories);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $categoryManager = $auth->getRole('articleCategoryManager');
        $auth->removeChildren($categoryManager);

        $viewCategoryList = $auth->getPermission('viewArticleCategoryList');
        $editCategories = $auth->getPermission('editArticleCategories');
        $deleteCategories = $auth->getPermission('deleteArticleCategories');

        $auth->remove($viewCategoryList);
        $auth->remove($editCategories);
        $auth->remove($deleteCategories);

        $viewCategoryList = $auth->createPermission('viewCategoryList');
        $viewCategoryList->description = 'View shop category list';
        $auth->add($viewCategoryList);

        $editCategories = $auth->createPermission('editCategories');
        $editCategories->description = 'Edit shop category';
        $auth->add($editCategories);

        $deleteCategories = $auth->createPermission('deleteCategories');
        $deleteCategories->description = 'Delete shop categories';
        $auth->add($deleteCategories);

        $auth->addChild($categoryManager, $viewCategoryList);
        $auth->addChild($categoryManager, $editCategories);
        $auth->addChild($categoryManager, $deleteCategories);
    }

}
