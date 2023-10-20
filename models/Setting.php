<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id_setting
 * @property string $nama_setting
 * @property string $judul_pemilihan
 * @property int $limit_voting_min
 * @property int $limit_voting_max
 * @property string $tgl_awal
 * @property string $tgl_akhir
 * @property int $is_aktif
 *
 * @property Kandidat[] $kandidats
 * @property Pemilihan[] $pemilihans
 * @property Token[] $tokens
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_setting', 'judul_pemilihan', 'limit_voting_min', 'limit_voting_max', 'tgl_awal', 'tgl_akhir', 'is_aktif'], 'required'],
            [['limit_voting_min', 'limit_voting_max', 'is_aktif'], 'integer'],
            [['tgl_awal', 'tgl_akhir'], 'safe'],
            [['nama_setting', 'judul_pemilihan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_setting' => 'Id Setting',
            'nama_setting' => 'Nama Setting',
            'judul_pemilihan' => 'Judul Pemilihan',
            'limit_voting_min' => 'Limit Voting Min',
            'limit_voting_max' => 'Limit Voting Max',
            'tgl_awal' => 'Tgl Awal',
            'tgl_akhir' => 'Tgl Akhir',
            'is_aktif' => 'Is Aktif',
        ];
    }

    /**
     * Gets query for [[Kandidats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKandidats()
    {
        return $this->hasMany(Kandidat::class, ['id_setting' => 'id_setting']);
    }

    /**
     * Gets query for [[Pemilihans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPemilihans()
    {
        return $this->hasMany(Pemilihan::class, ['id_setting' => 'id_setting']);
    }

    /**
     * Gets query for [[Tokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Token::class, ['id_setting' => 'id_setting']);
    }
}
