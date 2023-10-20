<?php

namespace app\controllers;

use app\models\Kandidat;
use app\models\KandidatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KandidatController implements the CRUD actions for Kandidat model.
 */
class KandidatController extends Controller
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
     * Lists all Kandidat models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new KandidatSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kandidat model.
     * @param int $id_kandidat Id Kandidat
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_kandidat)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_kandidat),
        ]);
    }

    /**
     * Creates a new Kandidat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Kandidat();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_kandidat' => $model->id_kandidat]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kandidat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_kandidat Id Kandidat
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_kandidat)
    {
        $model = $this->findModel($id_kandidat);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_kandidat' => $model->id_kandidat]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Kandidat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_kandidat Id Kandidat
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_kandidat)
    {
        $this->findModel($id_kandidat)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kandidat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_kandidat Id Kandidat
     * @return Kandidat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_kandidat)
    {
        if (($model = Kandidat::findOne(['id_kandidat' => $id_kandidat])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
