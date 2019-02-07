<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 07.02.19
 * Time: 2:40
 */

namespace app\controllers;


use yii\db\Query;
use yii\rest\ActiveController;

class PlayersController extends ActiveController
{
    public $modelClass = 'app\models\Players';
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $qR = (new Query())
            ->from('players');

        if (\Yii::$app->request->get('team_id', 0)) {
            $qR->andWhere(['team_id' => \Yii::$app->request->get('team_id')]);
        }

        $data = $qR->all();

        return $data;
    }
}