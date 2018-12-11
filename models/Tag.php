<?php
	
	namespace viktorals\news\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag".
 *
 * @property int $id_tag
 * @property int $title
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string'],
	        [['id_tag'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Номер тега в бд',
            'title' => 'Название тега',
        ];
    }
    
    public static function getFullTags(){
    	return ArrayHelper::map(self::find()->asArray()->all(),'id_tag','title');
    }
}
