<?php

namespace api\v1\controllers;

use api\v1\renders\ResponseRender;
use api\v1\renders\OrderRender;

use Yii;
use api\v1\extensions\controllers\AuthApiController;
use common\models\Order;
use common\components\ApiRequest;

class OrdersController extends AuthApiController
{
	public function actionCreate() {
		
		if(!$order = Order::findOne($_POST['id'])) {
			$order = new Order;
			$order->id = $_POST['id'];
		}
		$order->attributes = $_POST;
		if(!$order->save())
			return ResponseRender::failure(ResponseRender::VALIDATION_ERROR, $order->errors);
			
		if($order->send()) {
			ApiRequest::statistics('v1/orders/create', $_POST);
			return ResponseRender::success(['order_id'=>$order->id]);
		}
		ResponseRender::failure(ResponseRender::INTERNAL_SERVER_ERROR);
	}
	
	public function actionCancel() {
		if(!$order = Order::findOne($_POST['id']))
			return ResponseRender::failure(ResponseRender::VALIDATION_ERROR, []);
		
		if($order->cancel($_POST['external_id']))
			return ResponseRender::success(['order_id'=>$order->id]);
			
		ResponseRender::failure(ResponseRender::INTERNAL_SERVER_ERROR);
	}
}