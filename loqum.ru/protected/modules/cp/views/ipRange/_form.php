<?php
/* @var $this IpRangeController */
/* @var $model IpRange */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ip-range-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row" style="width:170px; float:left;">
		<?php echo $form->labelEx($model,'ip_from'); ?>
		<?php echo $form->textField($model,'ip1',array('size'=>13,'maxlength'=>35)); ?>
		<?php echo $form->error($model,'ip_from'); ?>
	</div>

	<div class="row" style="width:170px; float:left;">
		<?php echo $form->labelEx($model,'ip_to'); ?>
		<?php echo $form->textField($model,'ip2',array('size'=>13,'maxlength'=>35)); ?>
		<?php echo $form->error($model,'ip_to'); ?>
	</div>
    <div class="row" style="width:200px; float:left">
        <label>Быстрый ввод диапазона (IP-IP)</label>
        <input type="text" name="fastinput" id="fastinput"/>
    </div>
    <br clear="all"/>
<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'timestamp'); ?>
	</div>
*/ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#fastinput').change(function(){
            ips = this.value.split('-');
            if (ips[1]) {
                $('#IpRange_ip1').val(ips[0]); //.trim()
                $('#IpRange_ip2').val(ips[1]); // .trim()
            }
        })
    })
</script>