<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estabelecimento */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estabelecimentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->estabelecimento_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit');
?>
<div class="estabelecimento-update">

    <h2><?= Html::encode($this->title) ?></h2>
    <br/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
