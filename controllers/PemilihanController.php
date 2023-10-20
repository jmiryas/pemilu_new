<?php

namespace app\controllers;

use app\models\Kandidat;
use app\models\Pemilihan;
use app\models\PemilihanDetail;
use app\models\PemilihanSearch;
use app\models\Setting;
use app\models\Token;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PemilihanController implements the CRUD actions for Pemilihan model.
 */
class PemilihanController extends Controller
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
                ],
            ],
        );
    }

    /**
     * Lists all Pemilihan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PemilihanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pemilihan model.
     * @param int $id_pemilihan Id Pemilihan
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_pemilihan)
    {
        $pemilihan_detail_list = PemilihanDetail::find()
            ->where(["id_pemilihan" => $id_pemilihan])
            ->with(["kandidat"])
            ->asArray()
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id_pemilihan),
            "pemilihan_detail_list" => $pemilihan_detail_list
        ]);
    }

    /**
     * Creates a new Pemilihan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pemilihan();

        // if ($this->request->isPost) {
        //     if ($model->load($this->request->post()) && $model->save()) {
        //         return $this->redirect(['view', 'id_pemilihan' => $model->id_pemilihan]);
        //     }
        // } else {
        //     $model->loadDefaultValues();
        // }

        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;

            $tgl = $request->post("tgl", null);
            $id_setting = $request->post("id_setting", null);

            if ($tgl == null || $id_setting == null) {
                Yii::$app->session->setFlash("error", "Tidak boleh ada yang kosong!");
                return $this->redirect(["pemilihan/index"]);
            }

            $pemilihan = new Pemilihan();
            $pemilihan->tgl = $tgl;
            $pemilihan->id_setting = $id_setting;
            $pemilihan->save();

            Yii::$app->session->setFlash("success", "Pemilihan berhasil ditambahkan");
            return $this->redirect(["pemilihan/index"]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pemilihan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_pemilihan Id Pemilihan
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_pemilihan)
    {
        $model = $this->findModel($id_pemilihan);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_pemilihan' => $model->id_pemilihan]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pemilihan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_pemilihan Id Pemilihan
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_pemilihan)
    {
        $this->findModel($id_pemilihan)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pemilihan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_pemilihan Id Pemilihan
     * @return Pemilihan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_pemilihan)
    {
        if (($model = Pemilihan::findOne(['id_pemilihan' => $id_pemilihan])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionVotingResult()
    {
        // Cara Kerja:

        // Mendapatkan pemilihan (setting) yang aktif saat ini.

        $current_setting = Setting::find()
            ->where(["is_aktif" => 1])
            ->asArray()
            ->one();

        // Cek apakah pemilihan (setting) saat ini null atau tidak.

        if ($current_setting != null) {

            // ----------------------------------------------------
            // Menggunakan SQL

            // Cari berapa banyak orang yang akan memilih

            $total_voters = Token::find()
                ->where(["id_setting" => $current_setting["id_setting"]])
                ->count();

            // Mendapatkan total yang sudah memilih

            $total_has_voted = Token::find()
                ->where([
                    "id_setting" => $current_setting["id_setting"],
                    "is_pakai" => 1
                ])
                ->count();

            // Mendapatkan total yang belum memilih

            $total_not_voted = Token::find()
                ->where([
                    "id_setting" => $current_setting["id_setting"],
                    "is_pakai" => 0
                ])
                ->count();

            // Menghitung suara sah

            $total_suara_sah_sql = "SELECT COUNT(pemilihan_detail.id_detail) 
            AS total_suara_sah FROM setting
            LEFT JOIN kandidat
                ON setting.id_setting = kandidat.id_setting
            LEFT JOIN pemilihan_detail
                ON pemilihan_detail.id_kandidat = kandidat.id_kandidat
            WHERE setting.is_aktif = 1";

            $total_suara_sah = (int) Yii::$app->db->createCommand($total_suara_sah_sql)
                ->queryOne()["total_suara_sah"];

            // Menghitung suara golput

            $total_suara_golput = $total_has_voted - $total_suara_sah;

            // Cari total suara tiap kandidat

            $pemilihan_detail_sql = "SELECT kandidat.id_kandidat, kandidat.nama_kandidat, 
            kandidat.foto,
                CASE
                    WHEN pemilihan_detail.id_kandidat IS NOT NULL 
                        THEN COUNT(pemilihan_detail.id_kandidat)
                    ELSE 0
                END AS total_suara,
                CASE
                    WHEN pemilihan_detail.id_kandidat IS NOT NULL AND pemilihan_detail.id_kandidat > 0
                        THEN COUNT(pemilihan_detail.id_kandidat) / $total_suara_sah * 100
                    ELSE 0
                END AS total_suara_persen
            FROM kandidat
                LEFT JOIN setting
            ON kandidat.id_setting = setting.id_setting
                LEFT JOIN pemilihan_detail
            ON pemilihan_detail.id_kandidat = kandidat.id_kandidat
                WHERE setting.is_aktif = 1
            GROUP BY kandidat.id_kandidat
                ORDER BY total_suara DESC";

            $pemilihan_detail_list = Yii::$app->db->createCommand($pemilihan_detail_sql)
                ->queryAll();

            // var_dump($pemilihan_detail_list);
            // die;

            // END Menggunakan SQL
            // ----------------------------------------------------

            return $this->render('result', [
                "current_setting" => $current_setting,
                "voting_result" => $pemilihan_detail_list,
                "total_voters" => $total_voters,
                "total_has_voted" => $total_has_voted,
                "total_not_voted" => $total_not_voted,
                "total_suara_sah" => $total_suara_sah,
                "total_suara_golput" => $total_suara_golput
            ]);
        }

        return $this->render('result', [
            "voting_result" => [],
        ]);
    }

    // Mendapatkan rgba untuk grafik

    public function getRGBA()
    {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);

        return "rgba(" . $r . "," . $g . "," . $b . "," . "0.4" . ")";
    }
}
