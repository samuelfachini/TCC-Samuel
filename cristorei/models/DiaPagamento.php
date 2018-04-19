<?php

namespace app\models;

use Yii;
use \app\models\base\BaseDiaPagamento;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "dia_pagamento".
 */
class DiaPagamento extends BaseDiaPagamento
{
    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return array_merge(parent::rules(), [
//            ]);
//    }


    public static function obterDiasPagamento()
    {
        $dias = static::find()->select(['dia'])->asArray()->column();

        $array = [];
        $dia_de_hoje = date('d');

        foreach ($dias as $dia) {
            $data = new \DateTime(date('Y-m-').$dia);


            if ($dia < $dia_de_hoje) {
                $data->add(new \DateInterval('P1M'));
            }

            $array[] = ['id' => $data->format('Y-m-d'), 'text' => $data->format('d/m/Y')];
        }

        usort($array, function($a, $b) {
             return strtotime($a['id']) -  strtotime($b['id']);
        });

        return ArrayHelper::map($array,'id','text');

    }

	
}