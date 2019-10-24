<?php

namespace api\v1\controllers;

use api\v1\renders\ResponseRender;
use api\v1\renders\AccountRender;

use Yii;
use api\v1\extensions\controllers\AuthApiController;
use common\models\Account;
use common\components\ETC;
use common\components\ApiRequest;

class AccountController extends AuthApiController
{
	public function actionAll() {
		$a = Account::find()->all();
		
		return ResponseRender::success(AccountRender::all($a));
	}
	
	public function actionCreate() {
		$a = new Account;
		$a->name = $_POST['name'];
		$a->type = $_POST['type'];
		$a->country = 'TH';
		$a->data = ['address' => ETC::address2HexString($_POST['name']),
					'trx_address' => $_POST['name'],
					'key' => $_POST['password']
		];
		$a->created_at = time();
		$a->save();
		
		$res = ApiRequest::statistics('v1/account/create', ['id'=>$a->id, 'type'=>$a->type, 'name'=>$a->name]);
		
		return ResponseRender::success(['account_id'=>$a->id]);
	}
}