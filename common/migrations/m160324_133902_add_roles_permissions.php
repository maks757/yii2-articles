<?php

use yii\db\Migration;

class m160324_133902_add_roles_permissions extends Migration
{
    public function up()
    {
        $auth = \Yii::$app->authManager;

        if(!\Yii::$app->authManager) {
            return true;
        }

        $createArticles = $auth->createPermission('createArticles');
        $createArticles->description = 'Create a post';
        $auth->add($createArticles);

        $updateArticles = $auth->createPermission('editArticles');
        $updateArticles->description = 'Update post';
        $auth->add($updateArticles);

        $deleteArticles = $auth->createPermission('deleteArticles');
        $deleteArticles->description = 'Delete post';
        $auth->add($deleteArticles);

        $manager = $auth->createRole('ArticlesManager');
        $auth->add($manager);
        $auth->addChild($manager, $createArticles);
        $auth->addChild($manager, $updateArticles);
        $auth->addChild($manager, $deleteArticles);

        $auth->assign($manager, 1);

        return true;
    }

    public function down()
    {
        $auth = \Yii::$app->authManager;

        $createArticles = $auth->getPermission('createArticles');
        $auth->remove($createArticles);

        $updateArticles = $auth->getPermission('editArticles');
        $auth->remove($updateArticles);

        $deleteArticles = $auth->getPermission('deleteArticles');
        $auth->remove($deleteArticles);

        $manager = $auth->getRole('ArticlesManager');
        $auth->removeChild($manager, $createArticles);
        $auth->removeChild($manager, $updateArticles);
        $auth->removeChild($manager, $deleteArticles);

        $auth->remove($manager);

        return true;
    }
}
