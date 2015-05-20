<h1>Мои заказы</h1>

<div class="search-form" style="display:none">

</div><!-- search-form -->


<?php 
$i = 1;
foreach ($model->search()->getData() as $data) {?>
    <div class="view">
    <b><?=$i.'. '.CHtml::link("Заказ №".$data->order_id,"/order/view/id/$data->order_id")?></b><br>
    Создан: <?=$data->date?><br>
    Статус: <?=ORDER::$getStatus[$data->order_status_id]?><br>
    </div>
<?
$i++;
} /*$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'order_id',		
		array(
	        'name'=>'order_id',
	        'type'=>'raw',	        
	        'value'=>'',
        ),	
        
        array(
	        'header'=>'Пользователь',
	        'type'=>'raw',	        
	        'value'=>'CHtml::link($data->us->username,"/cp/user/view/id/$data->user_id",array("target"=>"_blank"))',
        ),	
        array(
	        'name'=>'order_status_id',
	        'type'=>'raw',	        
	        'value'=>'ORDER::$getStatus[$data->order_status_id]',
        ),	
        'ip',
        'date',	
		
	),
));*/ ?>
