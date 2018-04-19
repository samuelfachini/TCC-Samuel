<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Estabelecimento */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estabelecimentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estabelecimento-view">
    <h2><?= Html::encode($this->title) ?></h2>
    <br/>
    <?php \almirb\yii2common\components\FlashHelper::showFlashMessages(); ?>
    <div class="clearfix crud-navigation">
        <!-- menu buttons -->
        <div class='pull-left'>
            
            <?= Yii::$app->user->can('master') ? Html::a('<span class="glyphicon glyphicon-plus"></span> '.Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) : '' ?>
            <?= Yii::$app->user->can('admin')  ? Html::a('<span class="glyphicon glyphicon-pencil"></span> '.Yii::t('app', 'Edit'), ['update', 'id' => $model->estabelecimento_id], ['class' => 'btn btn-primary']) : ''?>
            <?= Yii::$app->user->can('master') ? Html::a('<span class="glyphicon glyphicon-trash"></span> '.Yii::t('app', 'Delete'), ['delete', 'id' => $model->estabelecimento_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) : ''
            ?>
            </div>
        <div class="pull-right">
                        
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '.Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-default']) ?>
            
        </div>
    </div>
    <br/>
    <?php 
    $gridColumn = [
        'estabelecimento_id',
        'nome',
        'responsavel',
        'nr_cpf_cnpj',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        [
            'attribute' => 'cidade.nome',
            'label' => Yii::t('app', 'Cidade'),
        ],
        'telefone_comercial',
        'telefone_celular',
        'email:email',
        'ip_local',
        'ativo:boolean',
        'observacao:ntext',
        'created_at:datetime',
        [
            'attribute' => 'created_by',
            'value' =>  \app\modules\sistema\models\User::findLogUser($model->created_by),
        ],
        'updated_at:datetime',
        [
            'attribute' => 'updated_by',
            'value' =>  \app\modules\sistema\models\User::findLogUser($model->updated_by),
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>

</div>