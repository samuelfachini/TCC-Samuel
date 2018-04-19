<?php

namespace app\dictionaries;


use Yii;

trait DictionaryTrait
{
    public static function get($id)
    {
        $all = self::all();

        if (isset($all[$id])) {
            return $all[$id];
        }

        return Yii::t('app', 'Not set');
    }
}