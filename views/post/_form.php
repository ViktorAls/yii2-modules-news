<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Url;

?>

<div class="row">
	<?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12 col-xl-8">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Добавить новый пост</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                
                <?=$form->field($model, 'message')->widget(\vova07\imperavi\Widget::className(), [
	    'settings' => [
		    'lang' => 'ru',
		    'minHeight' => 400,
		    'buttonSource' => true,
		    'plugins' => [
			    'clips',
			    'fullscreen',
			    'table',
                'fontfamily',
                'fontsize',
                'fontcolor',
		    ],
		    'clips' => [
		            ['default','<span class="label label-default">Default</span>'],
                    ['primary','<span class="label label-primary">Primary</span>'],
                    ['success','<span class="label label-success">Success</span>'],
                    ['info','<span class="label label-info">Info</span>'],
                    ['warning','<span class="label label-warning">Warning</span>'],
                    ['danger','<span class="label label-danger">Danger</span>'],
		    ],
	    ],
    ]);?>
	                <?= $form->field($model, 'files[]')->widget(FileInput::classname(), ['options' => [
	                        'multiple' => true,
                        'accept' => 'image/*',
	                ],
		                'pluginOptions' => [
			                'deleteUrl'=>\yii\helpers\Url::to(['post/delete-img']),
			                'initialPreview'=>$model->imagesLinks,
			                'initialPreviewAsData'=>true,
			                'overwriteInitial'=>false,
			                'initialPreviewConfig'=>$model->imagesLinksData,
			                'pluginOptions' => [
				                'showPreview' => true,
				                'showCaption' =>false,
				                'showRemove' => false,
				                'showUpload' => false,
			                ],
			                'maxFileCount' => 15
		                ]
	                ]);
	                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Дополнительно</h3>
            </div>
            <div class="box-body">
                <? $icon = $model->isNewRecord ? []:Url::home(true).'/uploads/images/posts/icon/'.$model->icon; ?>
	            <?= $form->field($model, 'file')->widget(FileInput::classname(), [
		            'options' => ['accept' => 'image/*'],
		            'resizeImages'=>true,
		            'pluginOptions' => [
			            'initialPreview'=>$icon,
			            'initialPreviewAsData'=>true,
			            'overwriteInitial'=>false,
			            'initialPreviewConfig'=>'Иконка приложения',
			            'showPreview' => true,
			            'showCaption' =>true,
			            'showRemove' => false,
			            'showUpload' => false,
                        'dropZoneTitle'=>'',
		            ],
	            ]);?>
             
	            <?=$form->field($model, 'tags_arr')->widget(Select2::classname(), [
	                    'data'=>\common\models\Tag::getFullTags(),
		            'options' => ['placeholder' => 'Выбирите теги...', 'multiple' => true],
		            'pluginOptions' => [
			            'tokenSeparators' => [',', ' '],
			            'maximumInputLength' => 10,
                        'allowClear' => true
		            ],
	            ])->label('Теги новости');?>

                <?= $form->field($model, 'activ')->dropDownList(['Черновик','Опубликовать']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
            </div>
        </div>
    </div>
    
	<?php ActiveForm::end(); ?>

</div>
