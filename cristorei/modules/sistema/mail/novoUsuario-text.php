<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['sistema/user/update', 'id' => $user->id]);
?>
Olá!

Um novo usuário se cadastrou no site e está aguardando aprovação para poder utilizá-lo.
Clique no link abaixo para visualizar as informações:

<?= $resetLink ?>
