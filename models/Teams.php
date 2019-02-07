<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string $name
 * @property int $url_id
 * @property int $maps_played
 * @property int $wins
 * @property int $draws
 * @property int $losses
 * @property int $total_kills
 * @property int $total_deaths
 * @property int $rounds_played
 * @property float $kd_ratio
 * @property string $created_at
 *
 * @property Players[] $players
 * @property Urls $url
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url_id'], 'required'],
            [['url_id', 'maps_played', 'wins', 'draws', 'losses', 'total_kills', 'total_deaths', 'rounds_played'], 'integer'],
            [['kd_ratio'], 'double'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['url_id'], 'unique'],
            [['url_id'], 'exist', 'skipOnError' => true, 'targetClass' => Urls::className(), 'targetAttribute' => ['url_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url_id' => 'Url ID',
            'maps_played' => 'Maps Played',
            'wins' => 'Wins',
            'draws' => 'Draws',
            'losses' => 'Losses',
            'total_kills' => 'Total Kills',
            'total_deaths' => 'Total Deaths',
            'rounds_played' => 'Rounds Played',
            'kd_ratio' => 'Kd Ratio',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayers()
    {
        return $this->hasMany(Players::className(), ['team_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUrl()
    {
        return $this->hasOne(Urls::className(), ['id' => 'url_id']);
    }
}
