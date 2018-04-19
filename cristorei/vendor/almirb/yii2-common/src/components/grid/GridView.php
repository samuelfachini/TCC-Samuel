<?php

namespace almirb\yii2common\components\grid;

use Yii;
use yii\helpers\Html;
use kartik\grid\GridView as KartikGridView;
use kartik\export\ExportMenu;

class GridView extends KartikGridView
{
    public $pjax  = true;
    public $hover = true;
    public $responsiveWrap = false;
    public $headerRowOptions = ['class'=>'kartik-sheet-style'];
    public $filterRowOptions = ['class'=>'kartik-sheet-style'];
    public $panelHeadingTitle;
    public $toggleDataOptions = [
        'minCount' => 100,
        'maxCount' => 1000,
    ];

    public function init()
    {
        if (!$this->panel) {

            $this->panel = [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-th-list"></span>  ' . Html::encode($this->getView()->title),
                'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success', 'data-pjax' => 0]),
                'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('app', 'Reset Filters'), [Yii::$app->controller->action->id], ['class' => 'btn btn-info']),
            ];
        }

        if ($this->panelHeadingTitle) {
                $this->panel['heading'] = $this->panelHeadingTitle;
        }

        //Check if is modified
        if ($this->toolbar == ['{toggleData}','{export}']) {

            $this->toolbar = [
                [
                    'content' =>
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [Yii::$app->controller->action->id], [
                            'class' => 'btn btn-default',
                            'title' => Yii::t('app', 'Reset Filters')]),
                ],
                '{export}',
                '{toggleData}',
            ];
        }

        if (!$this->exportConfig) {

            $this->exportConfig = [
                GridView::EXCEL => [],
                GridView::HTML => [],
                GridView::PDF => [
                    'config' => [
                        'format' => \kartik\mpdf\Pdf::FORMAT_A4,
                        'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
                        'methods' => [
                            'SetHeader' => [Yii::$app->name . '|' . Yii::t('app', 'Exportação de Dados') . '|' . date('d/m/Y H:i:s', time())],
                            'SetFooter' => ['|{PAGENO}/{nb}|'],
                            'SetJS' => 'this.print();',
                        ],
                    ],
                ],
            ];
        }

        if (!$this->export) {
            $this->export =  ['target' => ExportMenu::TARGET_BLANK];
        }
        
        if (!$this->exportConversions) {
            $this->exportConversions = [
                ['from' => GridView::ICON_ACTIVE, 'to' => Yii::t('app', 'Yes')],
                ['from' => GridView::ICON_INACTIVE, 'to' => Yii::t('app', 'No')],
            ];
        }

        if (!$this->pager) {
            $this->pager = ['firstPageLabel' => Yii::t('app','First'), 'lastPageLabel' => Yii::t('app','Last')];
        }

        parent::init();
    }
}
