<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $country
 * @property int $last_proxy_id
 * @property string $data_json
 * @property int $created_at
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name', 'country', 'last_proxy_id', 'data_json', 'created_at'], 'required'],
            [['type', 'last_proxy_id', 'created_at'], 'integer'],
            [['data_json'], 'string'],
            [['name', 'country'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'country' => 'Country',
            'last_proxy_id' => 'Last Proxy ID',
            'data_json' => 'Data Json',
            'created_at' => 'Created At',
        ];
    }
	
	public function getData($assoc = true)
    {
        return json_decode($this->data_json,$assoc);
    }
	 
    public function setData($data)
    {
        $this->data_json = json_encode($data);
    }
	
	public function getProxy() {
		if($this->last_proxy_id == 0) 
			$proxy = Proxy::getProxyByCountry($this->country);
		 else 
		{
			$proxy = Proxy::getProxyById($this->last_proxy_id);
			if(!$proxy OR $proxy->id==0 OR $proxy->errors>22)
				$proxy = Proxy::getProxyByCountry($this->country);
		}
		
		$this->last_proxy_id = $proxy->id;
		$this->save();
		
		return $proxy->address;
	}
}
