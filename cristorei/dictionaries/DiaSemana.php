<?php

namespace app\dictionaries;

use Yii;

abstract class DiaSemana
{
    use DictionaryTrait;

    const DOMINGO          = 1;
    const SEGUNDA_FEIRA    = 2;
    const TERCA_FEIRA      = 3;
    const QUARTA_FEIRA     = 4;
    const QUINTA_FEIRA     = 5;
    const SEXTA_FEIRA      = 6;
    const SABADO           = 7;


    public static function all()
    {
        return [
            self::DOMINGO            => 'Domingo',
            self::SEGUNDA_FEIRA      => 'Segunda-feira',
            self::TERCA_FEIRA        => 'Terça-feira',
            self::QUARTA_FEIRA       => 'Quarta-feira',
            self::QUINTA_FEIRA       => 'Quinta-feira',
            self::SEXTA_FEIRA        => 'Sexta-feira',
            self::SABADO             => 'Sabado',
        ];
    }
}