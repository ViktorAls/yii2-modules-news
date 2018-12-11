<?php

use kartik\editable\Editable;
use yii\helpers\Html;
	use yii\grid\GridView;
    use yii\widgets\Pjax;
    
$this->title = 'Управление тегами новостей';
?>
<div class="tag-index">
<div class="row">
    <div class="col-md-8">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Теги к новостям</h3>
            </div>
            <div class="box-body">
	            <?php Pjax::begin(); ?>
	            <?= GridView::widget([
		            'dataProvider' => $dataProvider,
		            'columns' => [
			            ['class' => 'yii\grid\SerialColumn'],
			            ['label'=>'title', 'content'=>function($model){
				            return Editable::widget([
					            'name'=>'tags',
					            'value'=>$model->title,
					            'pjaxContainerId'=>'p0',
					            'formOptions'=>[
						            'action' => ['tag/update?type=ajax&id='.$model->id_tag]],
					            'asPopover' => true,
					            'editableButtonOptions'=>['label'=>'<i class="fas fa-pen"></i>'],// значек редактирования
					            'format' => Editable::FORMAT_BUTTON,// редактирвоание по стоке или кнопки
					            'preHeader'=>' ',// иконка когда редактируем
					            'header' => 'Тег: '.$model->title,
					            'size'=>'md',
					            'options' => ['class'=>'form-control', 'placeholder'=>'Enter person name...']
				            ]);
			            }
			            ],
			            [
				            'class' => 'yii\grid\ActionColumn',
				            'template' => '{delete}',
			            ],
		            ],
	            ]); ?>
	            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Добавить тег</h3>
            </div>
            <div class="box-body">
	            <?php $form = ActiveForm::begin(); ?>
             
	            <?= $form->field($model, 'title')->textInput() ?>

                <div class="form-group">
		            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success btn-block']) ?>
                </div>
	
	            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
</div>

