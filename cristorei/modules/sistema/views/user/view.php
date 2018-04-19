<?php

use app\modules\sistema\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h2><?= Html::encode($this->title) ?></h2>
    <br/>

    <div class="clearfix crud-navigation">
        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Adicionar', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . 'Editar', ['update', 'id' => $model->id],['class' => 'btn btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Excluir', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem certeza que deseja excluir este usuário?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> ' . 'Lista', ['index'], ['class'=>'btn btn-default']) ?>
        </div>
    </div>
    <br/>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' =>
            [
            'id',
            'username:email',
            'name',
            'num_tel',
            'num_cel',
            [
                'attribute'=>'tipo',
                'value' => User::optsTipoUsuario()[$model->tipo],
            ],        
            [
                'attribute'=>'status',
                'value' => $model->obterDescricaoStatus(),
                'format' => 'raw',
            ],
            [
                'attribute' => 'data_ultimo_login',
                'type' => 'raw',
                'value' => ($model->data_ultimo_login) ?  Yii::$app->formatter->asDatetime($model->data_ultimo_login) . ' (IP ' . $model->ip_ultimo_login . ')' : '',
            ],
            'created_at:datetime',
            [
                'attribute'=>'created_by',
                'value' =>  \app\modules\sistema\models\User::findLogUser($model->created_by),
            ],
            'updated_at:datetime',
            [
                'attribute'=>'updated_by',
                'value' =>  \app\modules\sistema\models\User::findLogUser($model->updated_by),
            ],
        ],
    ]) ?>

</div>
