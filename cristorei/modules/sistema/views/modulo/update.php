<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sistema\models\Modulo */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Modulos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->modulo_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="modulo-update">

    <h2><?= Html::encode($this->title) ?></h2>
    <br/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
