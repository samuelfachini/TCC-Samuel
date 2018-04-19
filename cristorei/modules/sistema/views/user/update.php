<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Usuário: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="user-update">

    <?php if (!Yii::$app->request->isAjax){ ?>

        <h2><?= Html::encode($this->title) ?></h2>
        <br/>

    <?php } ?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
