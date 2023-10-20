<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pemilihan_detail".
 *
 * @property int $id_detail
 * @property int $id_pemilihan
 * @property int $id_kandidat
 *
 * @property Kandidat $kandidat
 * @property Pemilihan $pemilihan
 */
class PemilihanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pemilihan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pemilihan', 'id_kandidat'], 'required'],
            [['id_pemilihan', 'id_kandidat'], 'integer'],
            [['id_kandidat'], 'exist', 'skipOnError' => true, 'targetClass' => Kandidat::class, 'targetAttribute' => ['id_kandidat' => 'id_kandidat']],
            [['id_pemilihan'], 'exist', 'skipOnError' => true, 'targetClass' => Pemilihan::class, 'targetAttribute' => ['id_pemilihan' => 'id_pemilihan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_detail' => 'Id Detail',
            'id_pemilihan' => 'Id Pemilihan',
            'id_kandidat' => 'Id Kandidat',
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
     * Gets query for [[Pemilihan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPemilihan()
    {
        return $this->hasOne(Pemilihan::class, ['id_pemilihan' => 'id_pemilihan']);
    }
}
