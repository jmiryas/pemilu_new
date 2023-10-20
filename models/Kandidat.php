<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "kandidat".
 *
 * @property int $id_kandidat
 * @property string $nama_kandidat
 * @property int $id_setting
 * @property string|null $foto
 *
 * @property PemilihanDetail[] $pemilihanDetails
 * @property Setting $setting
 * @property Visi[] $visis
 */
class Kandidat extends \yii\db\ActiveRecord
{

    // Nama property harus berbeda dengan yang ada di tabel    
    public $image_file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kandidat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_kandidat', 'id_setting'], 'required'],
            [['id_setting'], 'integer'],
            [['nama_kandidat', 'foto'], 'string', 'max' => 255],
            [['id_setting'], 'exist', 'skipOnError' => true, 'targetClass' => Setting::class, 'targetAttribute' => ['id_setting' => 'id_setting']],
            [
                ["image_file"],
                "file",
                "skipOnEmpty" => true,
                "extensions" => "png, jpg, jpeg",
                "maxSize" => 1024 * 1024 * 1.2,
                "message" => "Ukuran maksimum adalah 1.2MB"
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kandidat' => 'Id Kandidat',
            'nama_kandidat' => 'Nama Kandidat',
            'id_setting' => 'Setting',
            'foto' => 'Foto',
        ];
    }

    /**
     * Gets query for [[PemilihanDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPemilihanDetails()
    {
        return $this->hasMany(PemilihanDetail::class, ['id_kandidat' => 'id_kandidat']);
    }

    /**
     * Gets query for [[Setting]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Setting::class, ['id_setting' => 'id_setting']);
    }

    /**
     * Gets query for [[Visis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisis()
    {
        return $this->hasMany(Visi::class, ['id_kandidat' => 'id_kandidat']);
    }

    // Fungsi untuk menyimpan gambar

    public function beforeSave($insert)
    {
        $parent = parent::beforeSave($insert);

        $file = UploadedFile::getInstance($this, "image_file");

        if (!empty($file)) {
            $upload_path = Yii::getAlias("@webroot/image/");

            $new_image_name = uniqid() . "_" . $file->baseName . "." . $file->extension;

            $file_path = $upload_path . $new_image_name;

            if ($file->saveAs($file_path)) {
                $this->foto = $new_image_name;
            }
        }

        return $parent;
    }
}
