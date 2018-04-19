<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\sistema\models\ModuloSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modulos';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
//$this->registerJs($search);
?>
<div class="modulo-index">
    <?php \almirb\yii2common\components\FlashHelper::showFlashMessages(); ?>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--Remove hide class to display-->
        <?= Html::a('Advanced Search', '#', ['class' => 'btn btn-info search-button hide']) ?>
    </p>
        <div class="search-form" style="display:none">
        <?php //echo  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
        <?php 

    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        'modulo_id',
        'nome',
        [
            'class' => 'almirb\yii2common\components\grid\ActionColumn',
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-modulo']],
        'hover' => true,
        'responsiveWrap' => false,
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        // set a label for default menu
        /*'export' => [
            'label' => 'Page',
            'fontAwesome' => false,
        ],*/
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            'before'  => Html::a('<i class="glyphicon glyphicon-plus"></i> '.'Create', ['create'], ['class' => 'btn btn-success', 'data-pjax'=>0]),
            'after'   => Html::a('<i class="glyphicon glyphicon-repeat"></i> '.'Reset Filters', ['index'], ['class' => 'btn btn-info']),
        ],
        'toolbar' => [
            [
                'content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                'class' => 'btn btn-default',
                'title' => 'Reset Filters'                ]),
            ],
            '{export}',
            // your toolbar can include the additional full export menu
            /*ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => false,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">'.'Export All Data'.'</li>',
                    ],
                ],
            ]) ,*/
            '{toggleData}',
        ],
    ]); ?>

</div>
