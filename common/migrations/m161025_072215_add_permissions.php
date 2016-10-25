<?php

use yii\db\Migration;

class m161025_072215_add_permissions extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        /*Add permissions*/
        $viewArticleList = $auth->createPermission('viewArticleList');
        $viewArticleList->description = 'View list of articles';
        $auth->add($viewArticleList);

        $editArticles = $auth->createPermission('editArticles');
        $editArticles->description = 'Edit articles';
        $auth->add($editArticles);

        $deleteArticles = $auth->createPermission('deleteArticles');
        $deleteArticles->description = 'Delete articles';
        $auth->add($deleteArticles);


        $viewCategoryList = $auth->createPermission('viewCategoryList');
        $viewCategoryList->description = 'View category list';
        $auth->add($viewCategoryList);

        $editCategories = $auth->createPermission('editCategories');
        $editCategories->description = 'Edit categories';
        $auth->add($editCategories);

        $deleteCategories = $auth->createPermission('deleteCategories');
        $deleteCategories->description = 'Delete categories';
        $auth->add($deleteCategories);


        /*Add roles*/
        $articleManager = $auth->createRole('articleManager');
        $articleManager->description = 'Article manager';
        $auth->add($articleManager);

        $articleCategoryManager = $auth->createRole('articleCategoryManager');
        $articleCategoryManager->description = 'Articles category manager';
        $auth->add($articleCategoryManager);

        $articleAdministrator = $auth->createRole('articleAdministrator');
        $articleAdministrator->description = 'Article administrator';
        $auth->add($articleAdministrator);


        /*Add childs*/
        $auth->addChild($articleManager, $viewArticleList);
        $auth->addChild($articleManager, $editArticles);
        $auth->addChild($articleManager, $deleteArticles);

        $auth->addChild($articleCategoryManager, $viewCategoryList);
        $auth->addChild($articleCategoryManager, $editCategories);
        $auth->addChild($articleCategoryManager, $deleteCategories);

        $auth->addChild($articleAdministrator, $articleManager);
        $auth->addChild($articleAdministrator, $articleCategoryManager);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $viewArticleList = $auth->getPermission('viewArticleList');
        $editArticles = $auth->getPermission('editArticles');
        $deleteArticles = $auth->getPermission('deleteArticles');
        $viewCategoryList = $auth->getPermission('viewCategoryList');
        $editCategories = $auth->getPermission('editCategories');
        $deleteCategories = $auth->getPermission('deleteCategories');

        $articleManager = $auth->getRole('articleManager');
        $categoryManager = $auth->getRole('articleCategoryManager');
        $articleAdministrator = $auth->getRole('articleAdministrator');
        $auth->removeChildren($articleAdministrator);
        $auth->removeChildren($categoryManager);
        $auth->removeChildren($articleManager);

        $auth->remove($deleteCategories);
        $auth->remove($editCategories);
        $auth->remove($viewCategoryList);
        $auth->remove($deleteArticles);
        $auth->remove($editArticles);
        $auth->remove($viewArticleList);

        $auth->remove($articleAdministrator);
        $auth->remove($categoryManager);
        $auth->remove($articleManager);
    }

}
