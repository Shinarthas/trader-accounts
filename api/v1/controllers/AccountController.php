<?php

namespace api\v1\controllers;

use api\v1\renders\ResponseRender;
use api\v1\renders\AccountRender;

use Yii;
use api\v1\extensions\controllers\AuthApiController;
use common\models\Account;

class AccountController extends AuthApiController
{
	public function actionAll() {
		$a = Account::find()->all();
		
		return ResponseRender::success(AccountRender::all($a));
	}
}