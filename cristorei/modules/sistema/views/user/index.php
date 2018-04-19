<?php

use yii\helpers\Html;
use almirb\yii2common\components\grid\GridView;
use app\modules\sistema\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Usuários');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

<?php
    $gridColumns = [
        [
            'attribute' => 'id',  //Adicionei o ID para indentificar o usuário no log de erros.
            'header' => 'ID',
            'width' => '80px',
            'visible' => Yii::$app->user->can('master'),
        ],
        'username:email',
        'name',
        [
            'attribute'=>'tipo',
            'filter' => User::optsTipoUsuario(),
            'value'=> function($model, $key, $index, $widget) {
                return (User::optsTipoUsuario()[$model->tipo]);
            }
        ],
//        [
//            'class'=>'kartik\grid\BooleanColumn',
//            'attribute'=>'status',
//        ],
        [
            'attribute' => 'status',
            'filter' => [User::STATUS_DELETED => Yii::t('app','No'), User::STATUS_ACTIVE => Yii::t('app','Yes')],
            'format' => 'raw',
            'value' => function ($model) {
                return \kartik\widgets\SwitchInput::widget([
                    'name' => 'switch_'.$model->id,
                    'id' => 'switch_'.$model->id,
                    'value'=>($model->status == User::STATUS_ACTIVE),
                    'pluginOptions' => [
                        'size' => 'small',
                        'onColor' => 'success',
                        'offColor' => 'danger',
                        'onText'=> Yii::t('app','Yes'),
                        'offText' => Yii::t('app','No'),
                    ],
                    'pluginEvents' => [
                        "switchChange.bootstrapSwitch" => 'function() {
                          $.get( "'.\yii\helpers\Url::toRoute('/sistema/user/alterar-status').'", { id: '.$model->id.'} );
                        }'],
                ]);
            },
        ],
        [
            'attribute' => 'data_ultimo_login',
            'format' => 'datetime',
        ],
        [
            'class'=>'almirb\yii2common\components\grid\ActionColumn',
        ],
    ];

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'panelHeadingTitle' => '<span class="glyphicon glyphicon-user"></span>  ' . Html::encode($this->title),
    ]); ?>

</div>
