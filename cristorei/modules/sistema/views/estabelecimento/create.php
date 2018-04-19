<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estabelecimento */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Estabelecimento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estabelecimentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estabelecimento-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <br/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
