<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\base\Sepultura;
use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CriaSepulturasController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        function removerUnderlineArquivos($quadra_id) {

            $pasta       = '/home/samuel/cristorei_fotos/q'.$quadra_id;
            $arquivos_q1 = scandir($pasta);

            foreach ($arquivos_q1 as $arquivo) {

                if (strpos($arquivo, '.JPG') == false)
                    continue;

                rename($pasta.'/'.$arquivo, $pasta.'/'.str_replace('_temp','',$arquivo));
            }

        }

        function criarQuadra($quadra_id) {

            $arquivos_q1 = scandir('/home/samuel/cristorei_fotos/q'.$quadra_id);

            foreach ($arquivos_q1 as $arquivo) {

                if (strpos($arquivo, '.JPG') == false)
                    continue;

                $aleia   = substr($arquivo, strpos($arquivo,'a')+1,strpos($arquivo,'s')-strpos($arquivo,'a')-1);
                $posicao = substr($arquivo, strpos($arquivo,'s')+1,strpos($arquivo,'.')-strpos($arquivo,'s')-1);

                echo 'Arquivo: '.$arquivo . ' / Aleia: '. $aleia .' / Posicao: '. $posicao . PHP_EOL;

                $sepultura = new Sepultura(['quadra_id' => $quadra_id, 'aleia' => $aleia, 'numero' => 0, 'posicao_na_aleia' => $posicao]);
                $sepultura->save(false);

            }
        }

        function ajustarNumeracao($quadra_id) {
            $sepulturas = Sepultura::find()->where(['quadra_id' => $quadra_id])->orderBy('aleia, posicao_na_aleia')->all();

            $contador = 1;

            foreach ($sepulturas as $sepultura) {

                /* @var $sepultura \app\models\Sepultura */
                $sepultura->updateAttributes(['numero' => $contador]);

                echo 'Aleia: '. $sepultura->aleia . ' / Posicao: ' . $sepultura->posicao_na_aleia . ' / Numero: '.$contador . PHP_EOL;

                $nome_antigo = 'q'.$quadra_id.'a'.$sepultura->aleia.'s'.$sepultura->posicao_na_aleia.'.JPG';
                $nome_novo   = 'q'.$quadra_id.'a'.$sepultura->aleia.'s'.$contador.'_temp.JPG';

                rename('/home/samuel/cristorei_fotos/q' . $quadra_id . '/' . $nome_antigo,
                    '/home/samuel/cristorei_fotos/q' . $quadra_id . '/' . $nome_novo);

                echo 'Renomeado de: ' . $nome_antigo . ' -> ' . $nome_novo . PHP_EOL;

                $contador++;
            }

            removerUnderlineArquivos($quadra_id);
        }

        //Limpeza
        Yii::$app->db->createCommand("DELETE FROM falecido")->execute();
        Yii::$app->db->createCommand("ALTER TABLE falecido AUTO_INCREMENT = 1")->execute();
        Yii::$app->db->createCommand("DELETE FROM sepultura")->execute();
        Yii::$app->db->createCommand("ALTER TABLE sepultura AUTO_INCREMENT = 1")->execute();

        echo "- Sepulturas excluidas" . PHP_EOL;

        criarQuadra('1');
        ajustarNumeracao('1');

        criarQuadra('2');
        ajustarNumeracao('2');

        criarQuadra('3');
        ajustarNumeracao('3');

        criarQuadra('4');
        ajustarNumeracao('4');

        criarQuadra('5');
        ajustarNumeracao('5');

    }
}
