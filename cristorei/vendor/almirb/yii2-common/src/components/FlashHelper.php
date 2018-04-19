<?php

namespace almirb\yii2common\components;

class FlashHelper
{

    public static function getSignByKey($key) {
        if ($key === 'success') {
            return '<span class="glyphicon glyphicon-ok-sign"></span>';
        } else if ($key === 'warning') {
            return '<span class="glyphicon glyphicon-exclamation-sign"></span>';
        } else if ($key === 'danger') {
            return '<span class="glyphicon glyphicon-remove-sign"></span>';
        } else {
            return '<span class="glyphicon glyphicon-info-sign"></span>';
        }
}

    /***
     * @param bool $delete
     */
    public static function showFlashMessages($delete = true)
    {
        foreach (\Yii::$app->session->getAllFlashes() as $key => $message) {

            echo '<div class="alert alert-' . $key . '">'
                . '<button type="button" class="close" data-dismiss="alert">×</button>'
                . static::getSignByKey($key).'&nbsp;&nbsp;<strong>' . $message . "</strong/></div>\n";
        }
    }

}