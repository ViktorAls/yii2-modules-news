<?php
	
	namespace viktorals\news;

/**
 * post module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
	public $controllerNamespace = 'viktorals\news\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
	    $this->defaultRoute='post/index';
    }
}
