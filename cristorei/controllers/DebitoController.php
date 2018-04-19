<?php

namespace app\controllers;

use app\models\PagamentoSearch;
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
class DebitoController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::TIPO_TESOUREIRO],
                    ],
                    [
                        'allow' => true,
                        'actions' =>  ['index','view'],
                        'roles' =>  [User::TIPO_MEMBRO],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Debito models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DebitoSearch();

        if (Yii::$app->user->identity->tipo == User::TIPO_MEMBRO) {
            $searchModel->sepultura_user_id = Yii::$app->user->id;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Debito model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $pagamentoSearchModel  = new PagamentoSearch(['pagamento_id' => $model->pagamento_id]);
        $pagamentoDataProvider = $pagamentoSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'pagamentoDataProvider' => $pagamentoDataProvider,
        ]);
    }

    /**
     * Creates a new Debito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Debito();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item successfully created!'));
            return $this->redirect(['view', 'id' => $model->debito_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Debito model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item successfully updated!'));
            return $this->redirect(['view', 'id' => $model->debito_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Debito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try {
            $model->delete();
        } catch (\yii\db\Exception $e) {
            if($e->errorInfo[1] == 1451) {
            Yii::$app->session->setFlash('danger', Yii::t('app', 'Couldn\'t erase this item because It has related items!'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        if (Yii::$app->request->isAjax) {
            return Yii::$app->getResponse()->redirect(Yii::$app->request->referrer, 200, false);
        } else {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item successfully erased!'));
            return $this->redirect(['index']);
        }
    }
    
    /**
     * Finds the Debito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Debito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Debito::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
