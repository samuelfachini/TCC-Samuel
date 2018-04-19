<?php

namespace app\dictionaries;

use Yii;

abstract class SituacaoDebito
{
    use DictionaryTrait;

    const ABERTO         = 'A';
    const PARCELAMENTO   = 'P';
    const QUITADO        = 'Q';


    public static function all()
    {
        return [
            self::ABERTO         => 'Aberto',
            self::PARCELAMENTO   => 'Parcelamento',
            self::QUITADO        => 'Quitado',
        ];
    }
}
