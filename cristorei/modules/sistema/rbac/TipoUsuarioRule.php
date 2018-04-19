<?php
namespace app\modules\sistema\rbac;

//http://www.yiiframework.com/forum/index.php/topic/49104-does-anyone-have-a-working-example-of-rbac/page__view__findpost__p__229105

use Yii;
use yii\rbac\Rule;
use app\modules\sistema\models\User;

/**
 * Checks if user group matches
 */
class TipoUsuarioRule extends Rule
{
    public $name = 'tipoUsuario';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {

            $tipo = Yii::$app->user->identity->tipo;
            $role = $item->name;

            if (($role === '@') || \Yii::$app->user->identity->isMaster) {
                return true;

            } elseif ($role === User::TIPO_ADMINISTRADOR) {
                return $tipo == User::TIPO_ADMINISTRADOR;

            } elseif ($role === User::TIPO_TESOUREIRO) {
                return (($tipo == User::TIPO_TESOUREIRO) || ($tipo == User::TIPO_ADMINISTRADOR));

            } elseif ($role === User::TIPO_EDITOR) {
                return (($tipo == User::TIPO_EDITOR) || ($tipo == User::TIPO_ADMINISTRADOR));

            } elseif ($role === User::TIPO_MEMBRO) {
                return (($tipo == User::TIPO_MEMBRO) || ($tipo == User::TIPO_ADMINISTRADOR));
            }
        }
        return false;
    }
}