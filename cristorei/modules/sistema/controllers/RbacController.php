<?php
namespace app\modules\sistema\controllers;

use Yii;
use app\modules\sistema\rbac\TipoUsuarioRule;
use yii\console\Controller;

/**
 * Class RbacController
 * @package app\commands
 *
 * Rodar no console:
 * ./yii rbac/init
 */

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $tipoUsuarioRule = new TipoUsuarioRule();
        $auth->add($tipoUsuarioRule);

        $editor = $auth->createRole('edit');
        $editor->ruleName = $tipoUsuarioRule->name;
        $auth->add($editor);

        $admin = $auth->createRole('admin');
        $admin->ruleName = $tipoUsuarioRule->name;
        $auth->add($admin);
        $auth->addChild($admin, $editor);

        $master = $auth->createRole('master');
        $master->ruleName = $tipoUsuarioRule->name;
        $auth->add($master);
        $auth->addChild($master, $admin);
        $auth->addChild($master, $editor);
    }
}