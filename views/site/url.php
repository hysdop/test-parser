<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

\app\assets\VueAsset::register($this);
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/components/urls/urls.js', ['depends' => \app\assets\AppAsset::className()]);

$this->title = 'Добавление адреса';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="alert alert-info">
        Для вызова парсера используйте url вида parse/run?id=[id_url_object]
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="app">
        <ol>
            <li v-for="item in items">
                {{ item }}
            </li>
        </ol>

        <div class="input-group">
            <span class="input-group-addon">https://www.hltv.org/stats/teams/</span>
            <input v-model="id" type="text" class="form-control" placeholder="ID">

            <span class="input-group-addon">/</span>
            <input v-model="name" type="text" class="form-control" placeholder="NAME">

            <span class="input-group-btn">
                <button v-on:click="addUrl" class="btn btn-secondary" type="button">Добавить</button>
            </span>
        </div>
        <span style="color: #a50000" v-if="hasError">Ошибка</span>
    </div>
</div>
