<?php

namespace app\controllers;

use app\modules\sistema\models\User;
use Yii;
use app\models\Debito;
use app\models\DebitoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DebitoController implements the CRUD actions for Debito model.
 */
class EstatisticaController extends Controller
{

    /**
     * Lists all Estatistica models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index',[]);
    }
}
