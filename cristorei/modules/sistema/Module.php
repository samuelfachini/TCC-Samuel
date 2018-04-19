<?php

namespace app\modules\sistema;

/**
 * sistema module definition class
 *
 * Configurações a fazer:
 *
 * Aplicar as migrations:
 * yii migrate --migrationPath=@app/modules/sistema/migrations
 *
 * Será criado um usuário 'admin@admin.com' com senha '123456'.
 *
 *
 * Ajustar o menu de navegação (ex. /user/index => /sistema/user/index), e também os arquivos abaixo:
 *
 *
 * config/web.php:
 *
 * //Para gerar as regras, declarar este bloco também no arquivo config/console.php.  Também precisa declarar o módulo 'sistema' no web.php e no console.php.  Depois gerar com o comando: yii sistema/rbac/init
 * 'authManager' => [
 *       'class' => 'yii\rbac\PhpManager',
 *       'defaultRoles' => ['master', 'admin', 'edit'],
 *       'assignmentFile' => '@app/modules/sistema/rbac/assignments.php',
 *       'itemFile'       => '@app/modules/sistema/rbac/items.php',
 *       'ruleFile'       => '@app/modules/sistema/rbac/rules.php',
 * ],
 *
 * 'modules' => [
 *        'sistema' => [
 *              'class' => 'app\modules\sistema\Module',
 *           ],
 * ],
 *
 * 'user' => [
 *      'class' => 'app\modules\sistema\components\WebUser',
 *      'identityClass' => 'app\modules\sistema\models\User',
 *      'loginUrl'=> ['/sistema/site/login'],
 *  ],
 *
 * 'mailer' => [
 *       'viewPath' => '@app/modules/sistema/mail',
 *  ],
 *
 *
 * config/params.php:
 *
 *  'user.passwordResetTokenExpire' => 3600,
 *  'supportEmail' => 'xxxxxx@xxxxxxxx.com.br',
 *
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\sistema\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
