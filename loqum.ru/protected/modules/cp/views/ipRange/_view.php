<?php
/* @var $this IpRangeController */
/* @var $data IpRange */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_from')); ?>:</b>
	<?php echo CHtml::encode($data->ip_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_to')); ?>:</b>
	<?php echo CHtml::encode($data->ip_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />


</div>