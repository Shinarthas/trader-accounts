<?php

namespace api\v1\controllers;

use api\v1\renders\ResponseRender;
use api\v1\renders\OrderRender;

use Yii;
use api\v1\extensions\controllers\AuthApiController;
use common\models\Order;

class OrdersController extends AuthApiController
{
	public function actionCreate() {
		$order = new Order;
		$order->attributes = $_POST;
		if(!$order->save())
			return ResponseRender::failure(ResponseRender::VALIDATION_ERROR, $order->errors);
			
		if($order->send())
			return ResponseRender::success(['order_id'=>$order->id]);
		
		ResponseRender::failure(ResponseRender::INTERNAL_SERVER_ERROR);
	}
}