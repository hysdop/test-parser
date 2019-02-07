<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "players".
 *
 * @property int $id
 * @property string $name
 * @property int $team_id
 * @property string $maps
 * @property int $kd_diff
 * @property double $kd
 * @property double $rating
 * @property string $created_at
 *
 * @property Teams $team
 */
class Players extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'players';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'kd_diff'], 'integer'],
            [['kd', 'rating'], 'number'],
            [['created_at'], 'safe'],
            [['name', 'maps'], 'string', 'max' => 255],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_id' => 'id']],
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
            'team_id' => 'Team ID',
            'maps' => 'Maps',
            'kd_diff' => 'Kd Diff',
            'kd' => 'Kd',
            'rating' => 'Rating',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }
}
