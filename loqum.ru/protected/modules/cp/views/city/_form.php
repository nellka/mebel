<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!--p class="note">Поля, помеченные <span class="required">*</span> обязательны для заполнения.</p-->
    <?php echo $model->name ?>

	<?php echo $form->errorSummary($model); ?>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>75)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>75)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order'); ?>
		<?php echo $form->textField($model,'order'); ?>
		<?php echo $form->error($model,'order'); ?>
	</div>
*/ ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'metaTitle'); ?>
		<?php echo $form->textField($model,'metaTitle',array('size'=>120)); ?>
		<?php echo $form->error($model,'metaTitle'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'seoText'); ?>
        <?php  echo $form->textArea($model,'seoText',array('rows'=>20,'cols'=>120)); ?>
        <?php /*$this->widget('application.extensions.ckfceditor.CKkceditor', array(
            "model" => $model, # Data-Model
            "attribute" => 'seoText', # Attribute in the Data-Model
            "height" => '340px',
            'config' => array(
                'contentsCss' => '/css/site.css',
                'toolbar' => AdminHelper::getCKToolbar(),
                'disableNativeSpellChecker' => false,
            ),
            "filespath" => Yii::app()->basePath . "/../upload/",
            "filesurl" => Yii::app()->baseUrl . "/upload/",
        ));*/?>
        <?php
        $dir = Yii::getPathOfAlias('application.extensions.ckfceditor.source.ckeditor');
        $assetsDir = Yii::app()->getAssetManager()->publish($dir);
        Yii::app()->clientScript->registerScriptFile($assetsDir.'/ckeditor.js');
        ?>
        <!--script src="../ckeditor.js"></script-->
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.config.toolbar = [
                ['Styles','Format','Font','FontSize'],
                '/',
                ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
                '/',
                ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
            ] ;
            CKEDITOR.replace( 'City[seoText]',{
               // toolbar : 'simple' /* this does the magic */
                });
        </script>
        <?php echo $form->error($model,'seoText'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->