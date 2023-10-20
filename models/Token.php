<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property string $token
 * @property int $id_setting
 * @property int $is_pakai
 *
 * @property Setting $setting
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'id_setting'], 'required'],
            [['id_setting', 'is_pakai'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['id_setting'], 'exist', 'skipOnError' => true, 'targetClass' => Setting::class, 'targetAttribute' => ['id_setting' => 'id_setting']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'id_setting' => 'Setting',
            'is_pakai' => 'Status Token',
        ];
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
