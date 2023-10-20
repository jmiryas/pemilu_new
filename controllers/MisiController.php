<?php

namespace app\controllers;

use app\models\Misi;
use app\models\MisiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MisiController implements the CRUD actions for Misi model.
 */
class MisiController extends Controller
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
     * Lists all Misi models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MisiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Misi model.
     * @param int $id_misi Id Misi
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_misi)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_misi),
        ]);
    }

    /**
     * Creates a new Misi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Misi();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_misi' => $model->id_misi]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Misi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_misi Id Misi
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_misi)
    {
        $model = $this->findModel($id_misi);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_misi' => $model->id_misi]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Misi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_misi Id Misi
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_misi)
    {
        $this->findModel($id_misi)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Misi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_misi Id Misi
     * @return Misi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_misi)
    {
        if (($model = Misi::findOne(['id_misi' => $id_misi])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
