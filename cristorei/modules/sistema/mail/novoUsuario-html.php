<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['sistema/user/update', 'id' => $user->id]);
?>
<div class="password-reset">
    <p>Olá!</p>

    <p>Um novo usuário se cadastrou no site e está aguardando aprovação para poder utilizá-lo.</p>

    <p>
        Clique no link abaixo para visualizar as informações:<br/>
        <?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
