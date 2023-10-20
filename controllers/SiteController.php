<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Kandidat;
use app\models\Misi;
use app\models\Pemilihan;
use app\models\PemilihanDetail;
use app\models\Setting;
use app\models\Token;

class SiteController extends Controller
{
    public $freeAccessActions = ['index'];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $setting = Setting::find()->where(["is_aktif" => 1])->asArray()->one();

        // Mengambil kandidat dan relationship nya (visi)

        $kandidatList = [];

        if ($setting != null) {
            $kandidatList = Kandidat::find()
                ->where(["id_setting" => $setting["id_setting"]])
                ->with(["visis"])
                ->asArray()
                ->all();
        }

        // Mencari misi dari tiap kandidat

        $misiList = Misi::find()->asArray()->all();

        foreach ($kandidatList as $index => $kandidat) {
            // Cara 1

            // if (count($kandidat["visis"]) > 0) {
            //     $currentMisi = Misi::find()
            //         ->where(["id_visi" => $kandidat["visis"][0]["id_visi"]])
            //         ->asArray()
            //         ->all();

            //     $kandidatList[$index]["misiList"] = $currentMisi;
            // }

            // Cara 2

            if (count($kandidat["visis"]) > 0) {
                $currentMisi = [];

                foreach ($kandidat["visis"] as $visi) {
                    foreach ($misiList as $misi) {
                        if ($visi["id_visi"] == $misi["id_visi"]) {
                            $currentMisi[] = $misi;
                        }
                    }
                }

                $kandidatList[$index]["misiList"] = $currentMisi;
            } else {
                $kandidatList[$index]["misiList"] = [];
            }
        }

        // print_r($kandidatList);
        // die;

        // Ketika mengirim token

        if ($this->request->isPost) {
            $inputedToken = $this->request->post("token");

            $selected_token = Token::find()
                ->where(
                    [
                        "token" => $inputedToken,
                        "is_pakai" => 0,
                        "id_setting" => $setting["id_setting"]
                    ]
                )
                ->one();

            // Cek apakah token yang digunakan sesuai

            if ($selected_token == null) {
                Yii::$app->session->setFlash("error", "Token tidak bisa digunakan");
                return $this->redirect(["site/index"]);
            }

            // Cek apakah masih dalam periode pemilihan

            $current_date = date("Y-m-d H:i:s");

            if (
                $current_date < $setting["tgl_awal"] ||
                $current_date > $setting["tgl_akhir"]
            ) {
                Yii::$app->session->setFlash("error", "Periode pemilihan tidak tepat");
                return $this->redirect(["site/index"]);
            }

            if ($selected_token != null) {
                return $this->render("pemilihan", [
                    "setting" => $setting,
                    "token" => $selected_token,
                    "kandidatList" => $kandidatList
                ]);
            } else {
                Yii::$app->session->setFlash("danger", "Token tidak bisa digunakan");
                return $this->redirect(["index"]);
            }
        }

        return $this->render('index', [
            "setting" => $setting,
            "kandidatList" => $kandidatList
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionStorePemilihan()
    {
        if ($this->request->isPost) {
            $id_setting = $this->request->post("id_setting");
            $token = $this->request->post("token");
            $kandidatList = $this->request->post("kandidat", []);

            $current_setting = Setting::find()
                ->where(["id_setting" => $id_setting])
                ->asArray()
                ->one();

            $current_token = Token::find()
                ->where(["token" => $token])
                ->asArray()
                ->one();

            $current_kandidat_list = Kandidat::find()
                ->where(["id_setting" => $id_setting])
                ->with(["visis"])
                ->asArray()
                ->all();

            // var_dump($current_setting);
            // var_dump($current_token);
            // var_dump($current_kandidat_list);
            // die;

            $settingModel = Setting::find()
                ->where(["id_setting" => $id_setting])
                ->asArray()
                ->one();

            if (
                count($kandidatList) < $settingModel["limit_voting_min"] ||
                count($kandidatList) > $settingModel["limit_voting_max"]
            ) {
                Yii::$app->session->setFlash("error", "Jumlah kandidat yang dipilih tidak sesuai");
                // return $this->redirect(["site/index"]);
                return $this->render("pemilihan", [
                    "setting" => $current_setting,
                    "token" => $current_token,
                    "kandidatList" => $current_kandidat_list
                ]);
            }

            $pemilihan = new Pemilihan();
            $pemilihan->tgl = date("Y-m-d H:i:s");
            $pemilihan->id_setting = $id_setting;

            if ($pemilihan->save()) {
                $id_pemilihan = $pemilihan->id_pemilihan;

                foreach ($kandidatList as $index => $kandidat) {
                    $pemilihan_detail = new PemilihanDetail();

                    $pemilihan_detail->id_pemilihan = $id_pemilihan;
                    $pemilihan_detail->id_kandidat = $kandidat;

                    $pemilihan_detail->save();
                }

                $tokenModel = Token::find()->where(["token" => $token])->one();

                $tokenModel->is_pakai = 1;
                $tokenModel->save();

                Yii::$app->session->setFlash("success", "Pemilihan berhasil dilakukan");
                return $this->redirect(["site/index"]);
            } else {
                Yii::$app->session->setFlash("error", "Pemilihan tidak berhasil");
                // return $this->redirect(["site/index"]);
                return $this->render("pemilihan", [
                    "setting" => $current_setting,
                    "token" => $current_token,
                    "kandidatList" => $current_kandidat_list
                ]);
            }
        }

        return $this->redirect(["site/index"]);
    }
}
