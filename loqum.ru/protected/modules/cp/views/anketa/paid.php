<?php
$this->breadcrumbs=array(
    'Анкеты'=>array('index'),
	'Проплаченные',
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('anketa-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Анкеты с проплатами</h1>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'anketa-grid',
	'dataProvider'=>$dataProvider,
	'ajaxVar' => false,
    'filter'=>$model,

	'columns'=>array(
		'id',
		'email',
//		'password',
		'name',
        'location',
        array(
            'name'=>'balance',
            'header'=>'Пополнений (баланс)',
            'value'=>'$data->totalPaid . "(".$data->balance.")"',

        ),
        'contact_count',
        array(
            'name'=>'premium',
            'header'=>'Прем',
            'value'=>'$data->premium?"<span class=green>Да</span>":"<span class=pink>Нет</span>"',
            'filter' => CHtml::activeDropDownList($model, 'premium',array(0=>'Нет',2=>'Да'),array('empty'=>'Все')),
            'type'=>'raw'
        ),
        array(
            'header'=>'Переписок (Сообщений)',
            'value'=>'CHtml::link($data->dialogCount . "(".($data->totalMessagesFrom+$data->totalMessagesTo).")"
            ,"/cp/message/list/".$data->id,array("target"=>"_blank"))',
            'type'=>'raw'
        ),
        array(
            'value'=>'$data->first_visit>0?date("d.m.Y H:i",$data->first_visit):""',
            'header'=>$model->getAttributeLabel('first_visit'),
            //'filter'=>CHtml::textField($model,'first_visit'),
        ),
        array(
            'value'=>'$data->last_visit>0?date("d.m.Y H:i",$data->last_visit):""',
            'header'=>$model->getAttributeLabel('last_visit'),
        ),
        array(
            'name'=>'last_site',
            'value'=>'strpos($data->last_site,"onli")?"so": ($data->last_site=="sodeline.ru"?"sl":"")',
            'filter' => CHtml::activeDropDownList($model, 'last_site',array('atolin.ru'=>'at','soderganki-online.ru'=>'so','sodeline.ru'=>'sl'),array('empty'=>'Все')),
        ),
        array(
            'value'=>'$data->regsession?
            $data->regsession->searchtext."<br>".
            "<a href=". $data->regsession->referer .">".  substr($data->regsession->referer,0,80) . "</a>"
             ."<br/><a href=\"/cp/tools/statInfo/".$data->regsession->id_sess."\">* &rarr; ". "xxx"."</a>":""', //substr($data->regsession->firsthit->page,0,80)

            'header'=>'Реф',
            'type'=>'raw',
            //'filter'=>CHtml::textField($model,'first_visit'),
        ),

/*
        array( //"<a href=".$data->regsession->referer.">".mb_substr($data->regsession->referer,0,80,"utf-8")."</a>"
            'value'=>'$data->regsession?
            $data->regsession->searchtext."<br>".
            "<br/><a target="_blank" href=\"/cp/tools/statInfo/".$data->regsession->id_sess."\">* &rarr; ". substr( $data->regsession->firsthit->page,0,80):""',
            'header'=>'Реф',
            'type'=>'raw',
            //'filter'=>CHtml::textField($model,'first_visit'),
        ),

*/
        array(
            'value' => 'Anketa::$getGenders[$data->gender]',//$data->gender
            'header' => $model->getAttributeLabel('gender'),
            'filter' => CHtml::activeDropDownList($model, 'gender',Anketa::$getGenders,array('empty'=>'Все')),
        ),
        'age',
        /*'gender',*/

//        array(
//            'value' => '$data->isinactive',
//            'header' => $model->getAttributeLabel('isinactive'),
//            'filter' => CHtml::activeDropDownList($model, 'isinactive',array(0,1),array('empty'=>'Все')),
//        ),
//        array(
//            'value' => '$data->isdeleted',
//            'header' => $model->getAttributeLabel('isdeleted'),
//            'filter' => CHtml::activeDropDownList($model, 'isdeleted',array(0,1),array('empty'=>'Все')),
//        ),
        array(
            'class'=>'ext.zii.EImageColumn',
            'imagePathExpression'=>'$data->getMainPhotoUrl()',
        ),
        array(
            'name'=>'status_bad',
            'value' => 'Anketa::$bad_statuses[$data->status_bad]',//$data->gender
            'header' => 'К/Б',
            'filter' => CHtml::activeDropDownList($model, 'status_bad',Anketa::$bad_statuses,array('empty'=>'Все')),
        ),
        array(
            'name'=>'isdeleted',
            'value' => '$data->isdeleted == 1 ? "del":"" ',//$data->gender
            'header' => 'Del',
            'filter' => CHtml::activeDropDownList($model, 'isdeleted',array('0'=>'Нет','1'=>'Да'),array('empty'=>'Все')),
        ),

		/*
		'birthday',
Загрузите в корневой каталог вашего сайта файл с именем e5eaea070ca3.html и
содержащий текст 54220b904ed2
		'zodiac',
		'heigth',
		'weight',
		'about',
		'marital_status',
		'sexual_orientation',
		'description',
		'location',
		'icq',
		'phone',
		'mainphoto',
		'last_visit',
		'isdeleted',
		'isinactive',
		*/
//		array(
//			'class'=>'CButtonColumn',
//		),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{ip} {view} {update} {delete}',//{preview} {login}
            'buttons'=>array(
//                'anketa'=>array(
//                    'anketa'=>'Просмотр',
//                    'imageUrl'=>'/assets/b5b5c02c/gridview/view.png',
//                    'url'=>'view',
//                    'options'=>array('target'=>'_blank'),
//                ),
                'view'=>array(
                    'options'=>array('target'=>'_blank'),
                ),
                'ip'=>array(
                    'label'=>'ip',
                    'url'=>'CController::createUrl("/cp/anketa/zombie/",array("id"=>$data->id))',
                    'options'=>array('target'=>'_blank'),
                ),
                'login'=>array(
                    'label'=>'Войти',
                    'url'=>'"#".$data->id',
                    'imageUrl'=>Yii::app()->baseUrl.'/images/icon/icon_user.gif',
//                    'click'=>'function(){alert(this.href); return false;}',
                    'cssClassExpression'=>"'login'",
                    'options'=>array('class'=>'login'),
                ),
                'preview' => array(
                    'label' => 'Превью',
                    'url' => 'CController::createUrl("/cp/anketa/2big/",array("id"=>$data->id))',
                    'options'=>array('target'=>'_blank'),
                    'imageUrl' => Yii::app()->baseUrl.'/images/icon/page_user.gif',
                    //'click' => 'alert("js")',
                )

            ),
		),
	),
)); ?>

<style>
    #sidebar {margin-top:0; padding:0;}
</style>