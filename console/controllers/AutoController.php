<?php
namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use common\models\Order;
use common\models\Proxy;

class AutoController extends Controller
{
	public function actionIndex()
	{	
		Order::findOne(1)->send();
	}
	
	public function actionLoadProxyList() {
		Proxy::downloadList();
	}
	
	public function actionReloadProxyList() {
	
		$list = json_decode(file_get_contents("https://www.proxy-list.download/api/v0/get?l=en&t=https"), true)[0]['LISTA'];
		if(count($list)==0)
			return;
		
		foreach(Account::find()->all() as $account)
		{
			$account->last_proxy_id = 0;
			$account->save();
		}
			
		
		foreach(Proxy::find()->all() as $proxy)
			$proxy->delete();
			
		Proxy::downloadList($list);
	}
	
	public function actionCheckAllProxy() {
		foreach(Proxy::find()->where(['speed'=>0])->all() as $p)
			$p->check();
	}
}