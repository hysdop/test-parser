<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

\app\assets\VueAsset::register($this);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/components/teams/teams.js', ['depends' => \app\assets\AppAsset::className()]);

$this->title = 'Команды';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div id="app">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Maps played</th>
                    <th>Wins / draws / losses</th>
                    <th>Total kills</th>
                    <th>Total deaths</th>
                    <th>Rounds played</th>
                    <th>K/D Ratio</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="item in items">
                    <tr>
                        <td>{{ item.name }}</td>
                        <td>{{ item.maps_played }}</td>
                        <td>{{ item.wins }} / {{ item.draws }} / {{item.losses }}</td>
                        <td>{{ item.total_kills }}</td>
                        <td>{{ item.total_deaths }}</td>
                        <td>{{ item.rounds_played }}</td>
                        <td>{{ item.kd_ratio }}</td>
                        <td>
                            <button class="btn btn-default" v-on:click="showPlayers(item.id)">Игроки</button>
                        </td>
                    </tr>
                    <tr v-if="showPlayersFlags.indexOf(item.id) !== -1">
                        <td colspan="7">
                            <players-list v-bind:team_id="item.id"></players-list>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

<div id="players-list-template" style="display: none">
    <table class="table">
        <thead>
            <tr>
                <th>Player</th>
                <th>K/D Diff</th>
                <th>K/D</th>
            </tr>
        </thead>
        <tbody>
        <template v-for="item in items">
            <tr>
                <td>{{ item.name }}</td>
                <td>{{ item.kd_diff }}</td>
                <td>{{ item.kd }}</td>
            </tr>
        </template>
        </tbody>
    </table>
</div>
