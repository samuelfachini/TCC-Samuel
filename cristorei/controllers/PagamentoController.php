<?php

namespace app\controllers;

use app\models\DebitoSearch;
use app\models\Parcela;
use Yii;
use app\models\Pagamento;
use app\models\PagamentoSearch;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PagamentoController implements the CRUD actions for Pagamento model.
 */
class PagamentoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pagamento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagamentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Exibe a linha expandida dos membros
     */
    public function actionExibirParcelas() {
        if (isset($_POST['expandRowKey'])) {
            $parcelas = Parcela::find()->where(['pagamento_id' => $_POST['expandRowKey']])->orderBy('data_vencimento')->asArray()->all();
            return $this->renderPartial('_parcelas', ['parcelas'=> $parcelas]);
        } else {
            return '<div class="alert alert-danger">Este pagamento não tem parcelas cadastradas.</div>';
        }
    }

    /**
     * Displays a single Pagamento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $debitoSearchModel  = new DebitoSearch(['pagamento_id' => $model->pagamento_id]);
        $debitoDataProvider = $debitoSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'debitoDataProvider' => $debitoDataProvider
        ]);
    }

    /**
     * Creates a new Pagamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $post = Yii::$app->request->post();

        $model = new Pagamento();

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty($post['pks'])) {
            Yii::$app->session->set(Pagamento::PKS_DEBITO, explode(',', $post['pks']));
        }


        if (isset($request->post()['ajax']) && $model->load($post))
            return \yii\widgets\ActiveForm::validate($model);

        if ($model->load($post) && $model->save()) {

            return $this->redirect(['view','id' => $model->pagamento_id]);

        } else {
            return [
                'title' => "Gerar Pagamento",
                'size' => 'large',
                'content' => $this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    }

    /**
     * Updates an existing Pagamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item successfully updated!'));
            return $this->redirect(['view', 'id' => $model->pagamento_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Pagamento model.
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
     * Finds the Pagamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pagamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pagamento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
