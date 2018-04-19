<?php

use yii\helpers\Html;
use almirb\yii2common\components\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstabelecimentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estabelecimentos');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
//$this->registerJs($search);
?>
<div class="estabelecimento-index">
    <?php \almirb\yii2common\components\FlashHelper::showFlashMessages(); ?>
    
    <p>
        <!--Remove hide class to display-->
        <?= Html::a(Yii::t('app', 'Advanced Search'), '#', ['class' => 'btn btn-info search-button hide']) ?>
    </p>
        <div class="search-form" style="display:none">
        <?php //echo  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
        <?php 

    $gridColumn = [
        'estabelecimento_id',
        'nome',
        'nr_cpf_cnpj',
        'bairro',
        'cep',
        [
            'attribute' => 'cidade_id',
            'label' => Yii::t('app', 'Cidade'),
            'value' => function($model){
                return !is_null($model->cidade)?$model->cidade->nome:'';
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'initValueText' => ($searchModel->cidade_id) ?\app\modules\sistema\models\Cidade::findOne($searchModel->cidade_id)->nome : null,
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['cidade/listar-cidades']),
                        'dataType' => 'json',
                        'delay' => 250,
                    ],
                ],
            ],
            'filterInputOptions' => ['placeholder' => Yii::t('app', 'Choose'), 'id' => 'grid-reclamacao-search-pessoa_reclamante_nome']
        ],
        'telefone_comercial',
        'email:email',
        [
                'class'=>'kartik\grid\BooleanColumn',
                'trueLabel'  =>  Yii::t('app', 'Yes'),
                'falseLabel' => Yii::t('app', 'No'),
                'attribute'  => 'ativo',
        ],
        [
            'class' => 'almirb\yii2common\components\grid\ActionColumn',
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-estabelecimento']],
    ]); ?>

</div>
