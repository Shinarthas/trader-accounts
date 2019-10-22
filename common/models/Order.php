<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $main_currency
 * @property int $second_currency
 * @property int $account_id
 * @property double $tokens_count
 * @property double $rate
 * @property int $created_at
 */
class Order extends \yii\db\ActiveRecord
{

	const STATUS_NEW = 0;
	const STATUS_ERROR = 1;
	const STATUS_CREATED = 2;
	
	public static $statuses = [
		self::STATUS_NEW => 'new',
		self::STATUS_ERROR => 'error',
		self::STATUS_CREATED => 'created',
	];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['market_id', 'currency_one', 'currency_two', 'account_id', 'tokens_count', 'rate'], 'required'],

            [['market_id', 'sell','currency_one', 'currency_two', 'account_id', 'created_at'], 'integer'],

            [['tokens_count', 'rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_currency' => 'Main Currency',
            'second_currency' => 'Second Currency',
            'account_id' => 'Account ID',
            'tokens_count' => 'Tokens Count',
            'rate' => 'Rate',
            'created_at' => 'Created At',
        ];
    }
	
	public function send() {

		$exchanger = '\\common\\components\\' .$this->market->class;	

		if($this->sell == 1)
			$result = $exchanger::sellOrder($this->main_currency, $this->second_currency, $this->tokens_count, $this->rate, $this->account);
		else
			$result = $exchanger::buyOrder($this->main_currency, $this->second_currency, $this->tokens_count, $this->rate, $this->account);
			
		if($result) {
			$this->status = self::STATUS_CREATED;
			$this->save();
			return true;
		}
		
		$this->status = self::STATUS_ERROR;
		$this->save();
		return false;
		
	}
	
	public function cancel() {
		$exchanger = '\\common\\components\\' .$this->market->class;
		
		return $exchanger::cancelOrder($this->account, $this);
	}
	
	public function getAccount() {
		return $this->hasOne(Account::className(), ['id'=>'account_id']);
	}
	
	public function getMain_currency() {
		return $this->hasOne(Currency::className(), ['id'=>'currency_one']);
	}
	
	public function getSecond_currency() {
		return $this->hasOne(Currency::className(), ['id'=>'currency_two']);
	}
	
	public function getMarket() {
		return $this->hasOne(Market::className(), ['id'=>'market_id']);
	}
	
}
