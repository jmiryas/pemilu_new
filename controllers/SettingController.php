<?php

namespace app\controllers;

use app\models\Setting;
use Yii;
use yii\web\Controller;

class SettingController extends Controller
{

    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => 'app\components\GhostAccessControl',
            ],
        ];
    }


    public function actionIndex()
    {
        $title = "Settings";

        // $sql = "SELECT * FROM setting";

        // $settings = Yii::$app->db->createCommand($sql)->queryAll();

        $settings = Setting::find()->asArray()->all();

        return $this->render("index", [
            "title" => $title,
            "settings" => $settings
        ]);
    }

    public function actionEntri()
    {
        // if (Yii::$app->request->isPost) {
        //    $request = Yii::$app->request;

        //    $nama_setting = $request->post("nama_setting");
        //    $judul_pemilihan = $request->post("judul_pemilihan");
        //    $limit_voting_min = $request->post("limit_voting_min");
        //    $limit_voting_max = $request->post("limit_voting_max");
        //    $tgl_awal = $request->post("tgl_awal");
        //    $tgl_akhir = $request->post("tgl_akhir");
        //    $is_aktif = $request->post("is_aktif");

        //    if (!isset($is_aktif)) {
        //         $is_aktif = 0;
        //    }

        //    $sql = "INSERT INTO setting (nama_setting, judul_pemilihan, limit_voting_min, limit_voting_max, tgl_awal, tgl_akhir, is_aktif) VALUES('$nama_setting', '$judul_pemilihan', '$limit_voting_min', '$limit_voting_max', '$tgl_awal', '$tgl_akhir', '$is_aktif')";

        //    $result = Yii::$app->db->createCommand($sql)->execute();

        //    if ($result >= 0) {
        //         Yii::$app->session->setFlash("success", "Setting berhasil ditambahkan");

        //         return $this->redirect(["setting/index"]);
        //    } else {
        //         Yii::$app->session->setFlash("error", "Setting gagal ditambahkan");

        //         return $this->redirect(["setting/entri"]);
        //    }
        // }

        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;

            $setting = new Setting();

            $setting->nama_setting = $request->post("nama_setting");
            $setting->judul_pemilihan = $request->post("judul_pemilihan");
            $setting->limit_voting_min = $request->post("limit_voting_min");
            $setting->limit_voting_max = $request->post("limit_voting_max");
            $setting->tgl_awal = $request->post("tgl_awal");
            $setting->tgl_akhir = $request->post("tgl_akhir");
            $setting->is_aktif = $request->post("is_aktif", 0);

            if ($setting->is_aktif == 1) {
                $is_active_setting_exists = Setting::find()
                    ->where(["is_aktif" => 1])
                    ->count();

                if ($is_active_setting_exists > 0) {
                    Yii::$app->session->setFlash("error", "Setting gagal ditambahkan! Saat ini ada pemilu yang sedang berlangsung.");

                    return $this->redirect(["setting/index"]);
                }
            }

            $result = $setting->save();

            if ($result) {
                Yii::$app->session->setFlash("success", "Setting berhasil ditambahkan");

                return $this->redirect(["setting/index"]);
            } else {
                Yii::$app->session->setFlash("error", "Setting gagal ditambahkan");

                return $this->redirect(["setting/entri"]);
            }
        }

        return $this->render("entri");
    }

    public function actionUpdate($id_setting)
    {

        // $sql = "SELECT * FROM setting WHERE id_setting = $id_setting";

        // $setting = Yii::$app->db->createCommand($sql)->queryOne();

        $setting = Setting::findOne(["id_setting" => $id_setting]);

        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;

            //    $nama_setting = $request->post("nama_setting");
            //    $judul_pemilihan = $request->post("judul_pemilihan");
            //    $limit_voting_min = $request->post("limit_voting_min");
            //    $limit_voting_max = $request->post("limit_voting_max");
            //    $tgl_awal = $request->post("tgl_awal");
            //    $tgl_akhir = $request->post("tgl_akhir");
            //    $is_aktif = $request->post("is_aktif", 0);

            //    $sql = "UPDATE setting SET nama_setting = '$nama_setting', judul_pemilihan = '$judul_pemilihan', limit_voting_min = '$limit_voting_min', limit_voting_max = '$limit_voting_max', tgl_awal = '$tgl_awal', tgl_akhir = '$tgl_akhir', is_aktif = '$is_aktif'
            //    WHERE id_setting = $id_setting";

            //    $result = Yii::$app->db->createCommand($sql)->execute();

            $previous_is_aktif = $setting->is_aktif;

            $setting->load($request->post(), "Setting");

            if (!isset($request->post("Setting")["is_aktif"])) {
                // var_dump($request->post("Setting")["is_aktif"]);
                // die;
                $setting->is_aktif = $request->post("is_aktif", 0);
            }

            if ($setting->is_aktif == 1 && $previous_is_aktif == 0) {
                $is_active_setting_exists = Setting::find()
                    ->where(["is_aktif" => 1])
                    ->count();

                if ($is_active_setting_exists > 0) {
                    Yii::$app->session->setFlash("error", "Setting gagal diupdate! Saat ini ada pemilu yang sedang berlangsung.");

                    return $this->redirect(["setting/index"]);
                }
            }

            $result = $setting->save();

            if ($result) {
                Yii::$app->session->setFlash("success", "Setting berhasil diupdate!");

                return $this->redirect(["setting/index"]);
            } else {
                Yii::$app->session->setFlash("error", "Setting gagal diupdate!");

                return $this->redirect(["setting/index"]);
            }
        }

        return $this->render("update", [
            "setting" => $setting
        ]);
    }

    public function actionDestroy($id_setting)
    {
        $sql = "DELETE FROM setting WHERE id_setting = $id_setting";

        $result = Yii::$app->db->createCommand($sql)->execute();

        if ($result >= 1) {
            Yii::$app->session->setFlash("success", "Setting berhasil dihapus!");

            return $this->redirect(["setting/index"]);
        } else {
            Yii::$app->session->setFlash("error", "Setting gagal dihapus!");

            return $this->redirect(["setting/index"]);
        }
    }
}
