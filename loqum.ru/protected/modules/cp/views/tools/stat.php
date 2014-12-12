<?php $this->renderPartial('_menu');
$this->breadcrumbs=array(
	'Инструменты'=>array('/admin/tools'),
	'Статистика',
);?>
<h1>Статистика переходов</h1>

<?php $i = 0; $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
//	'filter'=>$model,
    'columns' => array(

        array(
            'name' => '#пп',
            'value' => '$row+1',

        ),
        'ip',
        array(
            'name'=>'Referer',
            'value'=>'"<span title=\'".$data["referer"]."\'>".substr($data["referer"],0,50)."</span>"',//"<span title=\"".$data[]->referer."\">"..
            'type'=>'raw'
        )
        ,
        'agent',
        'searchtext',
//        array(
//            'name'=>'*',
//            'value'=>'',
//        ),

//        '<a href="'.$row['referer'].'">'
//        .'<img src="se/'.substr($row['searchtext'],0,1)
//        .'.gif" alt="" /></a>&nbsp;'.substr($row['searchtext'],2,40):'').

        array(
            'name' => 'дата и время',
            'value' => '
             CHtml::link(date(\'d.m.Y H:i\',$data["timestamp"]),array("statInfo","id"=>$data["id_sess"]))',
            'type'=>'raw',
        ),
	),
)); ?>