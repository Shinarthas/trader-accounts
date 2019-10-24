<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "proxy".
 *
 * @property int $id
 * @property int $address
 * @property int $country
 * @property int $active
 * @property int $last_check
 */
class Proxy extends \yii\db\ActiveRecord
{
	const MAX_TIMEOUT = 4;
	public static $speed = 3900;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proxy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['address'], 'required'],
            [['active', 'last_check'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'country' => 'Country',
            'active' => 'Active',
            'last_check' => 'Last Check',
        ];
    }
	
	public static function downloadList($list = false) {
	
		if(!$list)
			$list = json_decode(file_get_contents("https://www.proxy-list.download/api/v0/get?l=en&t=https"), true)[0]['LISTA'];
			
		if(count($list)==0)
			return false;
			
		foreach($list as $proxy_data) {
			if(!$p = Proxy::findOne(['address'=>$proxy_data['IP'].':'.$proxy_data['PORT']]))
			{
				$p = new Proxy;
				$p->address = $proxy_data['IP'].':'.$proxy_data['PORT'];
				$p->country = $proxy_data['ISO'].'';
			}
			
			$p->downloaded_at = time();
			$p->save();
		}
	}
	
	public static function top() {
		foreach(Proxy::find()->where(['!=','speed',0])->orderBy("speed")->limit(3)->scalar() as $proxy) {
			if($proxy->check())
				return $proxy->address;
		}
		
		return false;
	}
	
	public static function random() {
		$proxy_count = Proxy::find()->select("count(id) AS id")->andWhere(['<','speed', self::$speed])->scalar();
		
		$proxy_found = false;
		$repeats = 0;
		
		while(!$proxy_found OR $repeats < 15 ) {
			$repeats++;
			
			$rand = rand(0, $proxy_count-1);
			
			$candidat = Proxy::find()->andWhere(['<','speed', self::$speed])->offset($rand)->limit(1)->one();
			if($candidat->check())
				return $candidat;
		}
		
		return false;
	}
	
	public static function getProxyByCountry($country) {
		return Proxy::random();
	}
	
	public static function getProxyById($id) {
		$proxy = Proxy::findOne($id);
		if($proxy->check())
			return $proxy;
		
		return Proxy::getRandomProxyByCountry($proxy->country);
	}
	
	public static function getRandomProxyByCountry($country) {	

		$proxy_count = Proxy::find()->select("count(id) AS id")->where(['country'=>$country])->andWhere(['<','speed', self::$speed])->scalar();
		
		$proxy_found = false;
		$repeats = 0;
		
		while(!$proxy_found OR $repeats < 5 ) {
			$repeats++;
			
			$rand = rand(0, $proxy_count-1);
			
			$candidat = Proxy::find()->where(['country'=>$country])->andWhere(['<','speed', self::$speed])->offset($rand)->limit(1)->one();
			if($candidat->id!=0)
				if($candidat->check())
					return $candidat;
		}
		
		return false;
	}
	
	public function check() {
		if($this->errors > 22)
			return false;
			
		if(time() - $this->last_check < 300 AND $this->available == 1)
			return true;
		
		$starttime = microtime(true);
			
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.google.com');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_PROXY, $this->address);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::MAX_TIMEOUT);
		curl_setopt($ch, CURLOPT_TIMEOUT, self::MAX_TIMEOUT); 
		
		$res = curl_exec($ch);
		
		$this->available = 0;
		
		if(strlen($res)>10000 AND preg_match("|https\:\/\/drive\.google\.com|isU", $res)) 
			$this->available = 1;
		
		
		$this->last_check = time();	
		$this->speed = (microtime(true) - $starttime)*1000;
		$this->save();
		
		if($this->available == 1)
			return true;
			
		return false;
	}
}
