<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ETC_error".
 *
 * @property int $id
 * @property string $input_json
 * @property string $output_json
 * @property string $info_json
 * @property int $created_at
 */
class ETCError extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'etc_error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input_json', 'output_json', 'info_json'], 'string'],
            [['created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'input_json' => 'Input Json',
            'output_json' => 'Output Json',
            'info_json' => 'Info Json',
            'created_at' => 'Created At',
        ];
    }
	
	public function getInput($assoc = true)
    {
        return json_decode($this->input_json,$assoc);
    }
	 
    public function setInput($data)
    {
        $this->input_json = json_encode($data);
    }
	
	public function getOutput($assoc = true)
    {
        return json_decode($this->output_json,$assoc);
    }
	 
    public function setOutput($data)
    {
        $this->output_json = json_encode($data);
    }
	
	public function getInfo($assoc = true)
    {
        return json_decode($this->info_json,$assoc);
    }
	 
    public function setInfo($data)
    {
        $this->info_json = json_encode($data);
    }
}
