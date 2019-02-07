<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "urls".
 *
 * @property int $id
 * @property string $url
 * @property string $created_at
 *
 * @property Teams $teams
 */
class Urls extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'urls';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['created_at'], 'safe'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
        return $this->hasOne(Teams::className(), ['url_id' => 'id']);
    }
}
