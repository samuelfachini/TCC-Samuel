<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['sistema/site/reset-password', 'token' => $user->password_reset_token]);
?>
Olá <?= $user->username ?>,

Clique no link abaixo para resetar sua senha:

<?= $resetLink ?>
