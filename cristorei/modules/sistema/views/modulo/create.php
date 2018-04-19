<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sistema\models\Modulo */

$this->title = 'Create' . ' ' . 'Modulo';
$this->params['breadcrumbs'][] = ['label' => 'Modulos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modulo-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <br/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
