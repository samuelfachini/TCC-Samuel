<?php

namespace app\modules\sistema\controllers;

use Yii;
use app\modules\sistema\models\User;
use app\modules\sistema\models\UserSearch;
use yii\db\Query;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::TIPO_ADMINISTRADOR],
                    ],
                    [
                        'allow' => true,
                        'actions' =>  ['create-responsavel','update-responsavel','listar-user'],
                        'roles' =>  [User::TIPO_EDITOR],
                    ],
                    [
                        'allow' => true,
                        'actions' =>  ['update-password'],
                        'roles' =>  ['@'],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User(['scenario'=> User::SCENARIO_INSERT]);

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format =  \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $model->status = 10;            

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateResponsavel()
    {
        $request = Yii::$app->request;
        $post = Yii::$app->request->post();

        $model = new User(['scenario'=> User::SCENARIO_MANTER_RESPONSAVEL, 'estabelecimento_id' => Yii::$app->user->getEstabelecimentoId()]);

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($request->post()['ajax']) && $model->load($post))
            return \yii\widgets\ActiveForm::validate($model);

        if ($request->isGet) {
            return [
                'title' => "Adicionar Responsável",
                'content' => $this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])

            ];
        } else if ($model->load($post) && $model->save()) {

            return [
                'dataId' => $model->id,
                'dataText' => $model->name,
                'forceClose' => true,
            ];
        } else {
            return [
                'title' => "Adicionar Responsável",
                'content' => $this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer' => Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_UPDATE;

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format =  \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (\Yii::$app->user->can('master')) {
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateResponsavel($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_MANTER_RESPONSAVEL;

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($request->post()['ajax']) && $model->load(\Yii::$app->request->post()))
            return \yii\widgets\ActiveForm::validate($model);

        if ($request->isGet) {
            return [
                'title' => $model->name,
                'content' => $this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Fechar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Salvar', ['class' => 'btn btn-primary', 'type' => "submit"])

            ];
        } else if ($model->load($request->post()) && $model->save()) {
            return [
                'dataId' => $model->id,
                'dataText' => $model->name,
                'forceClose' => true,
            ];
        } else {

            return [
                'title' => $model->name,
                'content' => $this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Fechar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Salvar', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    }


    public function actionUpdatePassword($id)
    {
        if ($id != Yii::$app->user->id)
            throw new ForbiddenHttpException(Yii::t('app','You are not allowed to access this page.'));

        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_UPDATE_PASS;

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format =  \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (\Yii::$app->user->can('master')) {
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Dados do usuário alterados com sucesso!'));
                return $this->redirect(['/site/index']);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionAlterarStatus($id)
    {
        if(!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException(Yii::t('app','You are not allowed to access this page.'));
        }
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_UPDATE;
        $model->status = ($model->status == 10) ? 0 : 10;
        $model->save(false, ['status','updated_at','updated_by']);
        return;
    }


    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::find()->where(['id'=> $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
        }
    }

    /**
     * Lists all Pessoa models.
     * @return mixed
     */
    public function actionListarUser($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id', 'CONCAT(COALESCE(name,"")," (",username,")") AS text'])
                ->from('user')
                ->where(['like', 'name', $q])
                ->limit(20);

            $command = $query->createCommand();
//            var_dump($command->rawSql);
//            die;
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => User::findOne($id)->name];
        }
        return $out;
    }
}
