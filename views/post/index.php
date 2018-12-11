<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\admin\controllers\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление постами сайта';
?>
<div class="col-md-11 mt-3">
    <?php Pjax::begin(); ?>
         <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Управление постами </h3>
                <p class="close text-black-50">
		            <?= Html::a('<i class="far fa-plus-square"></i>', ['create'],['title'=>'Добавить новый пост']) ?>
		            <?= Html::a('<i class="fas fa-tags"></i>', \yii\helpers\Url::to(['tag/index']),['title'=>'Управление тегами']) ?>
                </p>
            </div>
            <div class="box-body">
				<?= GridView::widget([
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,
					 'afterRow' =>function ($model, $key, $index, $grid)
                        {
                          if(count($model['tags'])>=1) {
                          $title = array_column($model['tags'], 'title');
                          $output='';
                          foreach ($title as $value){
                              $output .=' '.'<span class="label label-info"> '.$value.'</span>';
                          }
                          return '<tr><td colspan=10>'.$output.'</td></tr>';
                          }
                        },
					'columns' => [
						['class' => 'yii\grid\SerialColumn'],
						[
							'label'=>'Пользователь',
							'attribute'=>'id_user',
							'value'=>function($data){
								return $data['worker']['surname'].' '.$data['worker']['name'].' '.$data['worker']['patronymic'];
							},
							    'filter' => kartik\select2\Select2::widget([
							            'model'=>$searchModel,
							            'attribute'=>'id_user',
                                    'data' => \viktorals\news\models\Post::getUserList(),
                                    'options' => [
                                        'placeholder' => 'Поиск по автору...',
                                    ],
                                ]),
						],
						'title',
						'activ:boolean',
						[
						    'class' => 'yii\grid\ActionColumn',
                            'template' => ' {link}{update} {view} {delete}',
                            'buttons' => [
                                'link' => function ($url,$model,$key) {
				                    if ($model['activ'] == 0){
                                        return Html::a('<span class="glyphicon glyphicon-ok">  </span> ', $url);}
				                    },
                            ],
                        ],
                    ],
				]); ?>
            </div>
        </div>
    
    <?php Pjax::end(); ?>
</div>
