<?php
	
	namespace frontend\modules\posts;

/**
 * post module definition class
 */
class post extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
	public $controllerNamespace = 'frontend\modules\posts\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
	    $this->defaultRoute='post/index';
    }
}
