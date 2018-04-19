<?php

namespace app\controllers;

use app\models\SepulturaHelper;
use Yii;
use app\models\Sepultura;
use app\models\SepulturaSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SepulturaController implements the CRUD actions for Sepultura model.
 */
class SepulturaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','desenhar-mapa-sepulturas'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all Sepultura models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SepulturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDesenharMapaSepulturas($quadra_id = 1, $sepultura_destaque = null)
    {
        $html_mapa = SepulturaHelper::desenharMapaSepulturas($quadra_id, $sepultura_destaque);

        return $this->render('mapa',[
            'html_mapa' => $html_mapa,
            'quadra_id' => $quadra_id,
        ]);
    }
    
    /**
     * Displays a single Sepultura model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sepultura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sepultura();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item successfully created!'));
            return $this->redirect(['view', 'id' => $model->sepultura_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sepultura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item successfully updated!'));
            $model->imagem = UploadedFile::getInstance($model, 'imagem');
            $model->uploadImagem();

            return $this->redirect(['view', 'id' => $model->sepultura_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sepultura model.
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
        Yii::$app->session->setFlash('success', Yii::t('app', 'Item successfully erased!'));

        return $this->redirect(['index']);
    }
    
    /**
     * Finds the Sepultura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sepultura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sepultura::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    public function actionListarSepultura($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['sepultura_id as id', "CONCAT(quadra.nome,' A',aleia,' N',numero,' ',sufixo_numero) as text"])
                ->from('sepultura')
                ->leftJoin('quadra','quadra.quadra_id = sepultura.quadra_id')
                ->where(['like', "CONCAT(quadra.nome,' A',aleia,' N',numero,' ',sufixo_numero)", $q])
                ->limit(20);

            $command = $query->createCommand();
//            var_dump($command->rawSql);
//            die;
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Sepultura::findOne($id)->obterDescricaoSepultura()];
        }
        return $out;
    }

}
