<?php
	
	namespace viktorals\post\models;
	
	
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "post".
 *
 * @property int $id_post
 * @property int $id_user
 * @property string $title
 * @property string $message
 * @property string $date
 * @property string $icon
 * @property bool $activ
 */
class Post extends \yii\db\ActiveRecord
{
	
	public $file;
	public $files;
	public $tags_arr;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'message','activ','tags_arr'], 'required'],
            [['id_user'], 'integer'],
            [['message'], 'string'],
            [['date','tags','files','tags_arr','icon','id_user'], 'safe'],
            [['activ'], 'boolean'],
	        [['file'],'image'],
            [['title'], 'string', 'max' => 150],
            [['icon'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_post' => 'Номер поста',
            'id_user' => 'Опубликовал',
            'title' => 'Заголовок',
            'message' => 'Сообщение',
            'date' => 'Дата',
            'icon' => 'Иконка',
            'activ' => 'Видимость',
	        'file'=>'Главное фото',
	        'files'=>'Дополнительные фотографии'
        ];
    }
    
	/**
	 * Перед сохранением
	 */
	public function beforeSave($insert){
		$this->id_user = yii::$app->user->identity->id;
		if($file = UploadedFile::getInstance($this, 'file')){
			$this->saveOne($file);
		}
		return parent::beforeSave($insert);
    }
	
    /**
	 * При выборки
	 */
	public function afterFind()
	{
		$this->tags_arr = $this->tags;
	}
	
	/**
	 * После сохранения
	 **/
	public function afterSave($insert, $changedAttributes)
	{
		if($files = UploadedFile::getInstances($this, 'files')){
			$this->saveLot($files);
		}
		$this->workTag();
		parent::afterSave($insert, $changedAttributes);
	}
	
	/**
	 * перед удалением
	 */
	public function beforeDelete()
	{
		TagPost::deleteAll(['id_post'=>$this->id_post]);
		$this->additionalFilesDelete();
		return parent::beforeDelete();
	}
	
	/**
	 * Работа с тегами
	 * Удалить теги  которые были исправлены при изменении записи
	 * Добавить новые теги, при необходимости
	 */
	public function workTag(){
		$v_arr = ArrayHelper::map($this->tags,'id_tag','id_tag');
		foreach ($this->tags_arr as $one){
			if(!in_array($one,$v_arr)){
				$model= new TagPost();
				$model->id_post=$this->id_post;
				$model->id_tag=$one;
				$model->save();
			}
			if(isset($v_arr[$one])){
				unset($v_arr[$one]);
			}
		}
		foreach ($v_arr as $one){TagPost::deleteAll(['id_tag'=>$one,'id_post' => $this->id_post]);}
	}
	
	/**
	 *Удалить дополнительные файлы из базы и сервера
	 */
	public function additionalFilesDelete(){
		$dir = yii::getAlias('@images');
		$images = ImageManager::find()->where('item_id=:id',[':id'=>$this->id_post])->asArray()->all();
		foreach ($images as $image){
			if (file_exists($dir.'/'.$this->id_post.'/'.$image['name'])) {
				unlink($dir . '/' . $this->id_post . '/' . $image['name']);
			}
		}
		$this->isFileDelete(yii::getAlias('@icon').'/'.$this->icon);
		if (is_dir($dir.'/'.$this->id_post)){
			rmdir($dir.'/'.$this->id_post);
		}
		ImageManager::deleteAll(['item_id'=>$this->id_post]);
	}
	
	/**
	 * Сохранение одной картинки (icon)
	 * @param $file
	 * @throws \yii\base\Exception
	 * Для грузки 1 файла на сервер  и сохранении его в базу данных
	 */
	public function saveOne($file){
		$dir = Yii::getAlias('@icon');
		$this->createDir($dir);
		$this->isFileDelete($dir .'/'.$this->icon);
		$this->icon = strtotime('now').'_'.Yii::$app->getSecurity()->generateRandomString(6) . '.' . $file->extension;
		$file->saveAs($dir.'/'.$this->icon);
	}
	
	/**
	 * Для загрузки нескольких файлов на сервер и сохранении путей в базу данных
	 * @param $files
	 * @throws \yii\base\Exception
	 * @throws \yii\base\InvalidConfigException
	 */
	public function saveLot($files){
		$dir = Yii::getAlias('@images/'.$this->id_post);
		$this->createDir($dir);
		foreach ($files as $file) {
			$ob = new ImageManager();
			$ob->name = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(6) . '.' . $file->extension;
			$this->isFileDelete($dir.'/'.$ob->name);
			$ob->item_id=$this->id_post;
			$ob->class = $this->formName();
			$ob->alt = $file->baseName;
			$ob->save();
			$file->saveAs($dir.'/'.$ob->name);
		}
	}
	
	/**
	 * Если папки нету, то создалить её
	 * @param $dir
	 * @throws \yii\base\Exception
	 * $dir - путь для проверки существования папки
	 */
	public function createDir($dir){
		if (!is_dir($dir)){
			FileHelper::createDirectory($dir);
		}
	}
	
	/**
	 * Для удаления файла, если он есть, то удалить его
	 * @param $filename
	 */
	public function isFileDelete($filename){
		
		if (is_file($filename)) {
			unlink($filename);
		}
	}
	
	/**
	 * Все пользователи которые публиковали записи
	 */
	public static function getUserList(){
		$mas = self::find()->asArray()->with('worker')->asArray()->all();
		$user = [];
		foreach ($mas as $ma){
			$user[$ma['worker']['id_user']] = $ma['worker']['surname'].' '.$ma['worker']['name'].' '.$ma['worker']['patronymic'];
		}
		return $user;
	}
	
	/**
	 * пути для картинок
	 */
	public function getImagesLinks(){
		$imagesUrl=[];
		$dir =  Url::home(true).'/uploads/images/posts/Post/'.$this->id_post;
		$a = ArrayHelper::getColumn($this->images,'imagesUrl');
		foreach ($a as $ima){
			array_push($imagesUrl,$dir.'/'.$ima);
		}
		return $imagesUrl;
	}
	
	/**
	 * Данные для картинкок
	 */
	public function getImagesLinksData(){
		$arr = ArrayHelper::toArray($this->images,[ImageManager::className()=>['caption'=>'name','key'=>'id']]);
		return $arr;
	}
	
	/**
	 * Связи с другими таблицами
	 */
	public function getPostTags(){
		return $this->hasMany(TagPost::className(),['id_post'=>'id_post']);
	}
	
	public function getImages(){
		return $this->hasMany(ImageManager::className(),['item_id'=>'id_post'])->andWhere(['class'=>self::tableName()]);
	}
	
	public function getTags(){
		return $this->hasMany(Tag::className(),['id_tag'=>'id_tag'])->via('postTags');
	}
	
	public function getWorker(){
		return $this->hasOne(Worker::className(),['id_user'=>'id_user']);
	}
	
}
