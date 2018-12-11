<?php
	
	namespace viktorals\news\models;
	
/**
 * This is the model class for table "image_manager".
 *
 * @property int $id
 * @property string $name
 * @property int $item_id
 * @property string $alt
 * @property string $class
 */
class ImageManager extends \yii\db\ActiveRecord
{
	
	public $attachment;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_manager';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'item_id', 'class'], 'required'],
            [['item_id'], 'integer'],
            [['name', 'alt'], 'string', 'max' => 200],
            [['class'], 'string', 'max' => 150],
	        [['attachment'], 'image'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'item_id' => 'Номер поста',
            'alt' => 'Alt для картинки',
            'class' => 'Название таблици',
        ];
    }

    /*
     * Вернёт путь картинки,
     * */
    public function getImagesUrl(){
    	if ($this->name){
    		$path = $this->name;
    	} else $path = 'img/noimage.jpg';
	    return $path;
    }
    
}

