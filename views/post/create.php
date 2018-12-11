<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\post */

$this->title = 'Добавить новую запись';
$this->params['breadcrumbs'][] = ['label' => 'Новости сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', ['model' => $model,]) ?>
