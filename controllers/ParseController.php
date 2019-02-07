<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 06.02.19
 * Time: 21:30
 */

namespace app\controllers;


use app\models\Teams;
use app\models\Urls;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use Zend\Dom\Query;
use yii\httpclient\Client;

class ParseController extends Controller
{
    static $elementIndexIsColumn = [
        1 => 'maps_played',
        2 => 'wins_draws_losses',
        3 => 'total_kills',
        4 => 'total_deaths',
        5 => 'rounds_played',
        6 => 'kd_ratio'
    ];

    static $winsDrawsLossesByIndex = [
        0 => 'wins',
        1 => 'draws',
        2 => 'losses'
    ];

    static $playersIndexToColumn = [
        1 => 'name',
        2 => 'maps',
        3 => 'kd_diff',
        4 => 'kd',
        5 => 'rating'
    ];

    public function actionRun($id)
    {
        $urlObject = Urls::find()->where(['id' => $id])->one();
        if (!$urlObject) {
            throw new NotFoundHttpException('Адрес не найден');
        }

        $url = $urlObject->url;
        $text = null;
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();
        if ($response->isOk) {
            $text = $response->content;
        }

        $dom = new Query($text);

        $results = $dom->execute('.columns .standard-box .large-strong'); //
        if (count($results) !== 6) {
            throw new ServerErrorHttpException('Ошибка парсинга path: .columns .standard-box .large-strong');
        }

        $team = new Teams();
        $team->url_id = $urlObject->id;
        $team->name = urldecode(substr($url, strrpos($url, '/') + 1));
        $i = 1;
        foreach ($results as $item) {
            if ($i === 2) {
                // поле имеет формат '[0-9]+ / [0-9]+ / [0-9]+' - разделяем элементы
                $winsDrawsLossesAsArray = explode(' / ', $item->nodeValue);
                if (count($winsDrawsLossesAsArray) !== 3) {
                    throw new ServerErrorHttpException('Ошибка парсинга: wins / draws / losses');
                }
                foreach ($winsDrawsLossesAsArray as $subItemIndex1 => $subItemValue1) {
                    $team->{self::$winsDrawsLossesByIndex[$subItemIndex1]} = $subItemValue1;
                }
            } else {
                $team->{self::$elementIndexIsColumn[$i]} = $item->nodeValue;
            }
            $i++;
        }

        $team->created_at = new Expression('NOW()');
        $team->save();

        if (!$team->id) {
            throw new ServerErrorHttpException('Не удалось спарсить первую вкладку');
        }

        // Парсим вкладку players
        $strPos = strpos($url, 'teams');
        $playersUrl = substr_replace($url, 'players/', $strPos + 6, 0);

        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($playersUrl)
            ->send();
        if ($response->isOk) {
            $text = $response->content;
        }

        $dom = new Query($text);
        $results = $dom->execute('.player-ratings-table tbody tr');
        $playersAllRows = [];
        foreach ($results as $trItem) {
            $playerRowValues = [];
            foreach ($trItem->childNodes as $k => $tdItem) {
                if ($k % 2 == 0) { // в нечетных пустые td
                    $playerRowValues[] = $tdItem->nodeValue;
                }
            }

            $playersAllRows[] = array_merge($playerRowValues, [
                $team->id, // team_id
                date('Y-m-d H:i:s') // created_at
            ]);
        }

        \Yii::$app->db->createCommand()
            ->batchInsert('players', array_merge(self::$playersIndexToColumn, [
                'team_id',
                'created_at'
            ]), $playersAllRows)
            ->query();

        return $this->redirect(['site/teams']);
    }
}