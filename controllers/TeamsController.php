<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 07.02.19
 * Time: 0:01
 */

namespace app\controllers;


use yii\rest\ActiveController;

class TeamsController extends ActiveController
{
    public $modelClass = 'app\models\Teams';
    public $enableCsrfValidation = false;
}