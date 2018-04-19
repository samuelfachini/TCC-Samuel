<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Create') . ' '. Yii::t('app','Usuário');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Usuários'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php if (!Yii::$app->request->isAjax){ ?>

        <h2><?= Html::encode($this->title) ?></h2>
        <br/>

    <?php } ?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
