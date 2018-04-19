<?php
/**
 * Created by PhpStorm.
 * User: samuel
 * Date: 21/10/17
 * Time: 17:48
 */

namespace app\models;


use dosamigos\chartjs\ChartJs;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\JsExpression;

class Estatistica
{
    public static function graficoEspecativaDeVida()
    {
        $array = Falecido::find()->select([
            "AVG(YEAR(data_falecimento) - YEAR(data_nascimento) - (DATE_FORMAT(data_falecimento, '%m%d') < DATE_FORMAT(data_nascimento, '%m%d'))) idade",
            "DATE_FORMAT(data_falecimento,'%Y') ano",
            "COUNT(*) falecidos",
            ])
            ->where('data_nascimento is not null')
            ->andWhere('data_falecimento is not null')
            ->groupBy('ano')
            ->orderBy('ano')
            ->createCommand()
            ->queryAll();

        //VarDumper::dump($array,10, true);

        //$idade      = ArrayHelper::getColumn($array,'idade');
        $idade      = array_map('intval', ArrayHelper::getColumn($array,'idade'));
        //$anos       = array_map('intval', ArrayHelper::getColumn($array,'ano'));
        $anos       = ArrayHelper::getColumn($array,'ano');
        $falecidos  = ArrayHelper::getColumn($array,'falecidos');

        \Yii::$app->getView()->registerJs("var falecidosEspecativaDeVida = " .Json::encode($falecidos).";");

        return ChartJs::widget([
        'type' => 'line',
        'options' => [
            //'height' => 290,
            //'width' => 600,
        ],
        'clientOptions' => [
            'legend' => [
                'display' => false,
            ],
            'tooltips' => [
                'callbacks' => [
                  'label' => new JsExpression(
                      "function(tooltipItem, data) {
                            return ' '+tooltipItem.yLabel + ' anos (' + falecidosEspecativaDeVida[tooltipItem.index] + ' falecimentos)';                            
                  }"),
                ],
            ],
            //'responsive' => true,
            //'maintainAspectRatio' => false,
            'scales' => [
                'xAxes' => [[
                    //'type' => 'linear',
                    'display' => true,
                    'ticks' => [
                        'maxTicksLimit' => 20,
                    ],
                ]],
            ],

        ],
        'data' => [
            'labels' => $anos,
            'datasets' => [
                [
                    'label' => 'Espectativa',
                    'backgroundColor' => "rgba(76,127,178,0.5)",
                    'borderColor' => "rgba(76,127,178,1)",
                    'borderWidth' => '2',
                    'pointBorderColor' => "#fff",
                    'pointBorderWidth' => "1",
                    'pointBackgroundColor' => "rgba(76,127,178,1)",
                    'radius' => '4',
                    'data' => $idade
                ]
            ]
        ]
    ]);
    }

    public static function graficoFalecidosAno()
    {
        $array = Falecido::find()->select([
            "DATE_FORMAT(data_falecimento,'%Y') ano",
            "COUNT(*) falecidos",
        ])
            ->where('data_falecimento is not null')
            ->groupBy('ano')
            ->orderBy('ano')
            ->createCommand()
            ->queryAll();

        //VarDumper::dump($array,10, true);

        $anos       = ArrayHelper::getColumn($array,'ano');
        $falecidos  = ArrayHelper::getColumn($array,'falecidos');

        return ChartJs::widget([
            'type' => 'line',
            'options' => [
                //'height' => 290,
                //'width' => 600,
            ],
            'clientOptions' => [
                //'responsive' => true,
                //'maintainAspectRatio' => false,
                'legend' => [
                    'display' => false,
                ],
                'scales' => [
                    'xAxes' => [[
                        //'type' => 'linear',
                        'display' => true,
                        'ticks' => [
                            'maxTicksLimit' => 20,
                        ],
                    ]],
                ],

            ],
            'data' => [
                'labels' => $anos,
                'datasets' => [
                    [
                        'label' => 'Falecimentos',
                        'backgroundColor' => "rgba(76,127,178,0.5)",
                        'borderColor' => "rgba(76,127,178,1)",
                        'borderWidth' => '2',
                        'pointBorderColor' => "#fff",
                        'pointBorderWidth' => "1",
                        'pointBackgroundColor' => "rgba(76,127,178,1)",
                        'radius' => '4',
                        'data' => $falecidos
                    ]
                ]
            ]
        ]);
    }

    public static function graficoFalecidosIdade()
    {
        $array = Falecido::find()->select([
            "ifnull(YEAR(data_falecimento) - YEAR(data_nascimento) - (DATE_FORMAT(data_falecimento, '%m%d') < DATE_FORMAT(data_nascimento, '%m%d')),'(sd)') idade	",
            "ifnull(YEAR(data_falecimento) - YEAR(data_nascimento) - (DATE_FORMAT(data_falecimento, '%m%d') < DATE_FORMAT(data_nascimento, '%m%d')),-1) ordem	",
            "COUNT(*) falecidos",
        ])
            ->groupBy('idade, ordem')
            ->orderBy('ordem')
            ->createCommand()
            ->queryAll();

        //VarDumper::dump($array,10, true);

        $idades     = ArrayHelper::getColumn($array,'idade');
        $falecidos  = ArrayHelper::getColumn($array,'falecidos');

        return ChartJs::widget([
            'type' => 'line',
            'options' => [
                //'height' => 290,
                //'width' => 600,
            ],
            'clientOptions' => [
                //'responsive' => true,
                //'maintainAspectRatio' => false,
                'legend' => [
                    'display' => false,
                ],
                'scales' => [
                    'xAxes' => [[
                        //'type' => 'linear',
                        'display' => true,
                        'ticks' => [
                            'maxTicksLimit' => 20,
                        ],
                    ]],
                ],

            ],
            'data' => [
                'labels' => $idades,
                'datasets' => [
                    [
                        'label' => 'Falecimentos',
                        'backgroundColor' => "rgba(76,127,178,0.5)",
                        'borderColor' => "rgba(76,127,178,1)",
                        'borderWidth' => '2',
                        'pointBorderColor' => "#fff",
                        'pointBorderWidth' => "1",
                        'pointBackgroundColor' => "rgba(76,127,178,1)",
                        'radius' => '4',
                        'data' => $falecidos
                    ]
                ]
            ]
        ]);
    }
    public static function graficoExumacoesAno()
    {
        $array = Falecido::find()->select([
            "DATE_FORMAT(data_exumacao,'%Y') ano",
            "COUNT(*) falecidos",
        ])
            ->where('data_exumacao is not null')
            ->groupBy('ano')
            ->orderBy('ano')
            ->createCommand()
            ->queryAll();

        //VarDumper::dump($array,10, true);

        $ano     = ArrayHelper::getColumn($array,'ano');
        $falecidos  = ArrayHelper::getColumn($array,'falecidos');

        return ChartJs::widget([
            'type' => 'line',
            'options' => [
                //'height' => 290,
                //'width' => 600,
            ],
            'clientOptions' => [
                //'responsive' => true,
                //'maintainAspectRatio' => false,
                'legend' => [
                    'display' => false,
                ],
                'scales' => [
                    'xAxes' => [[
                        //'type' => 'linear',
                        'display' => true,
                        'ticks' => [
                            'maxTicksLimit' => 20,
                        ],
                    ]],
                    'yAxes' => [[
                        //'type' => 'linear',
                        'display' => true,
                        'ticks' => [
                            'stepSize' => 1,
                        ],
                    ]],
                ],

            ],
            'data' => [
                'labels' => $ano,
                'datasets' => [
                    [
                        'label' => 'Exumações',
                        'backgroundColor' => "rgba(76,127,178,0.5)",
                        'borderColor' => "rgba(76,127,178,1)",
                        'borderWidth' => '2',
                        'pointBorderColor' => "#fff",
                        'pointBorderWidth' => "1",
                        'pointBackgroundColor' => "rgba(76,127,178,1)",
                        'radius' => '4',
                        'data' => $falecidos
                    ]
                ]
            ]
        ]);
    }

    public static function mediaEspectativaVida()
    {
        $media = Falecido::find()->select([
            "AVG(YEAR(data_falecimento) - YEAR(data_nascimento) - (DATE_FORMAT(data_falecimento, '%m%d') < DATE_FORMAT(data_nascimento, '%m%d'))) idade",
        ])
            ->where('data_nascimento is not null')
            ->andWhere('data_falecimento is not null')
            ->createCommand()
            ->queryScalar();

        //VarDumper::dump($array,10, true);

        return \Yii::$app->formatter->asDecimal($media, 2);
    }

    public static function mediaExumacoesAno()
    {
        $media = Falecido::find()->select([
            "COUNT(*) / (MAX(YEAR(data_exumacao)) - MIN(YEAR(data_exumacao)))",
        ])
            ->where('data_exumacao is not null')
            ->createCommand()
            ->queryScalar();

        //VarDumper::dump($array,10, true);

        return \Yii::$app->formatter->asDecimal($media, 2);
    }

    public static function mediaFalecidosAno()
    {
        $media = Falecido::find()->select([
            "COUNT(*) / (MAX(YEAR(data_falecimento)) - MIN(YEAR(data_falecimento)))",
        ])
            ->where('data_falecimento is not null')
            ->createCommand()
            ->queryScalar();

        //VarDumper::dump($array,10, true);

        return \Yii::$app->formatter->asDecimal($media, 2);
    }

}