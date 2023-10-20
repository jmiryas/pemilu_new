<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pemilihan".
 *
 * @property int $id_pemilihan
 * @property string $tgl
 * @property int $id_setting
 *
 * @property PemilihanDetail[] $pemilihanDetails
 * @property Setting $setting
 */
class Pemilihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pemilihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl', 'id_setting'], 'required'],
            [['tgl'], 'safe'],
            [['id_setting'], 'integer'],
            [['id_setting'], 'exist', 'skipOnError' => true, 'targetClass' => Setting::class, 'targetAttribute' => ['id_setting' => 'id_setting']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pemilihan' => 'Id Pemilihan',
            'tgl' => 'Tanggal',
            'id_setting' => 'Id Setting',
        ];
    }

    /**
     * Gets query for [[PemilihanDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPemilihanDetails()
    {
        return $this->hasMany(PemilihanDetail::class, ['id_pemilihan' => 'id_pemilihan']);
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
}
