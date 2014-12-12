<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_from')); ?>:</b>
	<?php echo CHtml::encode($data->id_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_to')); ?>:</b>
	<?php echo CHtml::encode($data->id_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datestamp')); ?>:</b>
	<?php echo CHtml::encode($data->datestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viewed')); ?>:</b>
	<?php echo CHtml::encode($data->viewed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deleted')); ?>:</b>
	<?php echo CHtml::encode($data->deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />


</div>