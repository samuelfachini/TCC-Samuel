<?php

namespace app\models;


use kartik\helpers\Html;
use yii\db\Query;

class SepulturaHelper
{
    public static function desenharMapaSepulturas($quadra_id, $sepultura_destaque = null)
    {
        $html = '<br/>';

        $sepulturas = (new Query())
            ->select(
            [   'sepultura.aleia',
                'sepultura.sepultura_id',
                'sepultura.numero',
                'sepultura.sufixo_numero',
                'count(falecido.falecido_id) sepultados',
                'GROUP_CONCAT(falecido.nome ORDER BY data_falecimento ASC SEPARATOR \' / \') nomes'
            ])
            ->from('sepultura')
            ->leftJoin('falecido','falecido.sepultura_id = sepultura.sepultura_id')
            ->where(['quadra_id' => $quadra_id])
            ->groupBy(['sepultura.aleia','sepultura.sepultura_id','sepultura.numero','sepultura.sufixo_numero'])
            ->orderBy('aleia desc, numero, sufixo_numero')
            ->all();

        $aleia_anterior = 0;

        foreach ($sepulturas as $sepultura) {

            if ($sepultura['aleia'] !== $aleia_anterior && $aleia_anterior !== 0)
                $html .= "<div class='clearfix'>&nbsp;</div>";

            if ($sepultura['aleia'] !== $aleia_anterior)
                $html .= "<div class='tumba'>".
                    'A'.$sepultura['aleia'].
                    "</div>";

            $cor_texto = 'blue';
            $cor_fundo = '#ccf';

            if ($sepultura['sepultura_id'] == $sepultura_destaque) {
                $cor_fundo = 'red';
                $cor_texto = 'white';
            }
            else if ($sepultura['sepultados'] == 0)
                $cor_fundo = '#cfc';

            $html .=  Html::a(  "<div class='tumba' style='background-color: $cor_fundo;' >".
                                    $sepultura['numero'].' '.$sepultura['sufixo_numero'].
                                "</div>",
                              ['/sepultura/view','id' => $sepultura['sepultura_id']],['style' => "color: $cor_texto", 'title' => $sepultura['nomes']]);

            $aleia_anterior = $sepultura['aleia'];
        }

        return $html;
    }

    public static function geraBotoesQuadras()
    {
        $html = '';
        $quadras = Quadra::find()->select(['quadra_id','nome'])->orderBy('nome')->all();

        foreach ($quadras as $quadra) {
            $html .= Html::tag(
                'div',
                Html::a('<i class="glyphicon glyphicon-th"></i><br/>' . $quadra->nome, ['/sepultura/desenhar-mapa-sepulturas', 'quadra_id' => $quadra->quadra_id],
                    ['class' => 'btn btn-app btn-block']),
                ['class' => 'col-md-3 col-xs-4 text-center']
            );
        }

        return $html;
    }
}