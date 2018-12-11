<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\post */

$this->title = 'Обновить новость';
$this->params['breadcrumbs'][] = ['label' => 'Новости сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id_post]];
$this->params['breadcrumbs'][] = 'Обновить'; ?>
    
				<?= $this->render('_form', [
					'model' => $model,
				]) ?>

