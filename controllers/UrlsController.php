<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 06.02.19
 * Time: 23:36
 */

namespace app\controllers;


use yii\rest\ActiveController;

class UrlsController extends ActiveController
{
    public $modelClass = 'app\models\Urls';
    public $enableCsrfValidation = false;
}