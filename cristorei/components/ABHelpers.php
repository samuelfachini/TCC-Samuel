<?php

namespace app\components;

use Yii;
use yii\web\View;

class ABHelpers
{

    /***
     * @param $mensagem
     * @param $filiado
     * @return mixed
     */
    public static function substituirMacrosMensagem($mensagem, $filiado)
    {
        $searchReplaceArray = array(
            '{filiado.nome}' => $filiado->nome,
        );

        return str_replace(
            array_keys($searchReplaceArray),
            array_values($searchReplaceArray),
            $mensagem);
    }

    public static function saudacaoBomDiaTardeNoite()
    {
        $nome = !Yii::$app->user->isGuest ? Yii::$app->user->identity->name : 'Visitante';

        $hr = date(" H ");
        if ($hr >= 12 && $hr < 18)
            return Yii::t('app','Boa tarde {nome}!',['nome' => $nome]);
        else if ($hr >= 0 && $hr <12 )
            return Yii::t('app','Bom dia {nome}!',  ['nome' => $nome]);
        else
            return Yii::t('app','Boa noite {nome}!',['nome' => $nome]);
    }

    public static function habilitarHintBlocks(View $view)
    {
        $hintBlocks = <<<HINT_BLOCKS
    $('.hint-block').each(function () {
        var hint = $(this);
        hint.parent().find('label').addClass('help').popover({
            html: true,
            trigger: 'hover',
            placement: 'right',
            content: hint.html()
        });
    });
HINT_BLOCKS;

        $view->registerJs($hintBlocks);
    }

    public static function obterCorrecaoOrientacaoImagem($caminho_completo)
    {
        $exif = @exif_read_data($caminho_completo);

        if(!empty($exif['Orientation'])) {

            switch ($exif['Orientation']) {
                case 8:
                    Yii::info('Imagem será rotacionada em -90 graus.');
                    return -90;
                case 3:
                    Yii::info('Imagem será rotacionada em 180 graus.');
                    return 180;
                case 6:
                    Yii::info('Imagem será rotacionada em 90 graus.');
                    return 90;
                default:
                    Yii::info('Imagem não será rotacionada.');
                    return 0;
            }
        }
    }
}