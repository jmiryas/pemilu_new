<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "misi".
 *
 * @property int $id_misi
 * @property string $nama_misi
 * @property int $id_visi
 *
 * @property Visi $visi
 */
class Misi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'misi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_misi', 'id_visi'], 'required'],
            [['nama_misi'], 'string'],
            [['id_visi'], 'integer'],
            [['id_visi'], 'exist', 'skipOnError' => true, 'targetClass' => Visi::class, 'targetAttribute' => ['id_visi' => 'id_visi']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_misi' => 'Id Misi',
            'nama_misi' => 'Nama Misi',
            'id_visi' => 'Visi',
        ];
    }

    /**
     * Gets query for [[Visi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisi()
    {
        return $this->hasOne(Visi::class, ['id_visi' => 'id_visi']);
    }
}
