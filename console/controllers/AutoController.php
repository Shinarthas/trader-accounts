<?php
namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use common\models\Order;


class AutoController extends Controller
{
	public function actionIndex()
	{	
		Order::findOne(1)->send();
	}

}