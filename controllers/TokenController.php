<?php

namespace app\controllers;

use app\models\Token;
use app\models\TokenSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TokenController implements the CRUD actions for Token model.
 */
class TokenController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'ghost-access' => [
                    'class' => 'app\components\GhostAccessControl',
                ]
            ],
        );
    }

    /**
     * Lists all Token models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TokenSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Token model.
     * @param string $token Token
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($token)
    {
        return $this->render('view', [
            'model' => $this->findModel($token),
        ]);
    }

    /**
     * Creates a new Token model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Token();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->is_pakai = 0;

            if ($model->save()) {
                return $this->redirect(['view', 'token' => $model->token]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionGenerate()
    {
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;

            $jumlah_token = $request->post("jumlah_token", null);
            $id_setting = $request->post("id_setting", null);

            if ($jumlah_token == null || $id_setting == null) {
                Yii::$app->session->setFlash("error", "Tidak boleh ada yang kosong!");
                return $this->render("generate");
            }

            for ($i = 0; $i < $jumlah_token; $i++) {
                $generated_token = strtoupper(substr(sha1(rand()), 0, 7));

                $tokenModel = new Token();

                $tokenModel->id_setting = $id_setting;
                $tokenModel->token = $generated_token;
                $tokenModel->is_pakai = 0;
                $tokenModel->save();
            }

            Yii::$app->session->setFlash("success", $jumlah_token . " Token berhasil digenerate!");
            return $this->redirect(["token/index"]);
        }

        return $this->render("generate");
    }

    /**
     * Updates an existing Token model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $token Token
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($token)
    {
        $model = $this->findModel($token);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'token' => $model->token]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Token model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $token Token
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($token)
    {
        $this->findModel($token)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Token model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $token Token
     * @return Token the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($token)
    {
        if (($model = Token::findOne(['token' => $token])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
