<?php

namespace app\models;

use Yii;
use \app\models\base\BaseParcela;

/**
 * This is the model class for table "parcela".
 */
class Parcela extends BaseParcela
{
    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return array_merge(parent::rules(), [
//            ]);
//    }

    public static function gerarParcelasPagamento(Pagamento $pagamento)
    {
        $numero_parcelas = $pagamento->qtd_parcelas;
        $valor_parcela = $pagamento->valor_total / $numero_parcelas;

        $data = new \DateTime($pagamento->primeiro_vencimento);

        for ($i=1; $i <= $numero_parcelas; $i++) {

            $parcela = new Parcela(['valor' => $valor_parcela,
                                    'perc_desconto' => $pagamento->perc_desconto,
                                    'pagamento_id' => $pagamento->pagamento_id,
                                    'data_vencimento' => $data->format('Y-m-d')]);

            $parcela->save();

            $data->add(new \DateInterval('P1M'));
        }
    }
}