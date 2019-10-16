<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "market".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $class
 * @property int $created_at
 */
class Market extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'market';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url', 'class', 'created_at'], 'required'],
            [['created_at'], 'integer'],
            [['name', 'url', 'class'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'class' => 'Class',
            'created_at' => 'Created At',
        ];
    }
}
