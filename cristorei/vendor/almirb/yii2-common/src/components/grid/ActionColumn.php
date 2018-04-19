<?php

/**
 * ActionColumn
 *
 * Custom buttons for gridview
 *
 * @author Germano Ricardi and Almir Bolduan
 *
 * @version 1.1
 *
 */

namespace almirb\yii2common\components\grid;

use kartik\grid\ActionColumn as KartikActionColumn;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ActionColumn extends KartikActionColumn
{
    const VIEW_BUTTON_DEFAULT_CLASS   = ['btn btn-sm btn-default'];
    const UPDATE_BUTTON_DEFAULT_CLASS = ['btn btn-sm btn-primary'];
    const DELETE_BUTTON_DEFAULT_CLASS = ['btn btn-sm btn-danger'];

    /**
     * @inheritdoc
     */
    public $headerOptions	= ['class' => 'actions-buttons text-center'];

    /**
     * @inheritdoc
     */
    public $contentOptions	= ['class' => 'text-center'];

    /**
     * @inheritdoc
     */
    public $width = '130px';

    /**
     * @var boolean when the ActionColumn should avoid wrapping of buttons in more than one line
     */
    public $noButtonWrap = true;

    function init()
    {
        if (!$this->template) {
            $this->template = "<span class='btn btn-group btn-group-sm'>{view} {update} {delete}</span>";
        } else {
            $this->template = "<span class='btn btn-group btn-group-sm'>" . $this->template . "</span>";
        }

        $this->viewOptions     = array_replace_recursive(['class' => static::VIEW_BUTTON_DEFAULT_CLASS],   $this->viewOptions);
        $this->updateOptions   = array_replace_recursive(['class' => static::UPDATE_BUTTON_DEFAULT_CLASS], $this->updateOptions);
        $this->deleteOptions   = array_replace_recursive(['class' => static::DELETE_BUTTON_DEFAULT_CLASS], $this->deleteOptions);

        if ($this->noButtonWrap) {
            $width = 10 + (substr_count($this->template, '{') * 36);
            $this->headerOptions = ['style' => "min-width: {$width}px"];
        }

        parent::init();
    }

    public function initDefaultButtons()
    {
        if (!isset($this->buttons['delete']) && isset($this->deleteOptions['role']) && $this->deleteOptions['role'] == 'modal-remote') {

            $this->buttons['delete'] = function ($url) {
                $options = $this->deleteOptions;
                $title = Yii::t('kvgrid', 'Delete');
                $icon = '<span class="glyphicon glyphicon-trash"></span>';
                $label = ArrayHelper::remove($options, 'label', ($this->_isDropdown ? $icon . ' ' . $title : $icon));
                $msg = ArrayHelper::remove($options, 'message', Yii::t('kvgrid', 'Are you sure to delete this item?'));
                $options = array_replace_recursive([
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'data-method' => false,
                    'data-request-method'=>'post',
                    'data-confirm'=>false,
                    'class' => static::DELETE_BUTTON_DEFAULT_CLASS,
                    'data-confirm-title'=> Yii::t('kvdialog', 'Confirmation'),
                    'data-confirm-message' =>  $msg,
                ], $options);

                if ($this->_isDropdown) {
                    $options['tabindex'] = '-1';
                    return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
                } else {
                    return Html::a($label, $url, $options);
                }
            };
        }

        parent::initDefaultButtons();
    }
}
