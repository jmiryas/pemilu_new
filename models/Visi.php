<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visi".
 *
 * @property int $id_visi
 * @property string $nama_visi
 * @property int $id_kandidat
 *
 * @property Kandidat $kandidat
 * @property Misi[] $misis
 */
class Visi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_visi', 'id_kandidat'], 'required'],
            [['nama_visi'], 'string'],
            [['id_kandidat'], 'integer'],
            [['id_kandidat'], 'exist', 'skipOnError' => true, 'targetClass' => Kandidat::class, 'targetAttribute' => ['id_kandidat' => 'id_kandidat']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_visi' => 'Id Visi',
            'nama_visi' => 'Nama Visi',
            'id_kandidat' => 'Kandidat',
        ];
    }

    /**
     * Gets query for [[Kandidat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKandidat()
    {
        return $this->hasOne(Kandidat::class, ['id_kandidat' => 'id_kandidat']);
    }

    /**
     * Gets query for [[Misis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMisis()
    {
        return $this->hasMany(Misi::class, ['id_visi' => 'id_visi']);
    }
}
