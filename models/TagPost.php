<?php
	
	namespace frontend\modules\posts\models;
	
/**
 * This is the model class for table "tagPost".
 *
 * @property int $id
 * @property int $id_tag
 * @property int $id_post
 */
class TagPost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tagPost';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tag', 'id_post'], 'required'],
            [['id_tag', 'id_post'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tag' => 'Id Tag',
            'id_post' => 'Id Post',
        ];
    }
}
