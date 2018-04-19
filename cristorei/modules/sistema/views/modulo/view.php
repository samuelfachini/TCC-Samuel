<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\sistema\models\Modulo */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Modulos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modulo-view">
    <h2><?= Html::encode($this->title) ?></h2>
    <br/>
    <?php \almirb\yii2common\components\FlashHelper::showFlashMessages(); ?>
    <div class="clearfix crud-navigation">
        <!-- menu buttons -->
        <div class='pull-left'>
            
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> '.'Create', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> '.'Edit', ['update', 'id' => $model->modulo_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> '.'Delete', ['delete', 'id' => $model->modulo_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
            </div>
        <div class="pull-right">
                        
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '.'List', ['index'], ['class' => 'btn btn-default']) ?>
            
        </div>
    </div>
    <br/>
    <?php 
    $gridColumn = [
        'modulo_id',
        'nome',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>

</div>