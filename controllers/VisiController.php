<?php

namespace app\controllers;

use app\models\Visi;
use app\models\VisiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VisiController implements the CRUD actions for Visi model.
 */
class VisiController extends Controller
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
     * Lists all Visi models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VisiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Visi model.
     * @param int $id_visi Id Visi
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_visi)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_visi),
        ]);
    }

    /**
     * Creates a new Visi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Visi();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_visi' => $model->id_visi]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Visi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_visi Id Visi
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_visi)
    {
        $model = $this->findModel($id_visi);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_visi' => $model->id_visi]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Visi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_visi Id Visi
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_visi)
    {
        $this->findModel($id_visi)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Visi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_visi Id Visi
     * @return Visi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_visi)
    {
        if (($model = Visi::findOne(['id_visi' => $id_visi])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
