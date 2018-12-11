<?php
	
	namespace viktorals\news\models;
use Yii;

/**
 * This is the model class for table "worker".
 *
 * @property int $id_prepod
 * @property string $name
 */
class Worker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'worker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_prepod'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_prepod' => 'Id Prepod',
            'name' => 'Name',
        ];
    }
}
