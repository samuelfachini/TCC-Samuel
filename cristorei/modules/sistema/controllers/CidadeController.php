<?php

namespace app\modules\sistema\controllers;

use Yii;
use app\modules\sistema\models\Cidade;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * CidadeController implements the CRUD actions for Cidade model.
 */
class CidadeController extends Controller
{
    /**
     * Lists all Cidade models.
     * @return mixed
     */
    public function actionListarCidades($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['cidade.cidade_id as id','CONCAT(cidade.nome," - ",estado.uf) AS text'])
                ->from('cidade')
                ->leftJoin('estado', 'estado.estado_id = cidade.estado_id')
                ->where(['like', "CONCAT(cidade.nome,' - ',estado.uf)" , $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Cidade::findOne($id)->nome];
        }
        return $out;
    }

}
