<?php
$this->breadcrumbs=array(
	'Анкеты',
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('index')),
	array('label'=>'Премиум', 'url'=>array('index','Anketa[premium]'=>1)),
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

<h1>Управление анкетами</h1>
<? /*
<p>
Можно использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>).
</p>*/ ?>
<? /*
<?php echo CHtml::link('Продвинутый поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form --> */ ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'anketa-grid',
	'dataProvider'=>$model->search(),
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
            ,"/cp/message/list/".$data->id,array("target"=>"_blank"))'
                . (true?'. " <a onclick=\"return confirm_delete();\" href=/cp/message/deleteUserMessages/id/{$data->id}>del</a>"  ':''),
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
            'value'=>'strpos($data->last_site,"uksil")?"mk": ($data->last_site=="sodeline.ru"?"sl":"")',
            'filter' => CHtml::activeDropDownList($model, 'last_site',array('loqum.ru'=>'lq','muksil.ru'=>'mk'),array('empty'=>'Все')),
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
<script type="text/javascript">
    $(document).ready(function() {
        $('body').delegate('a.login','click', function (e) {
            e.preventDefault();
            $('#login1').val(this.hash.substr(1));
            $('#pass1').val(this.hash.substr(1));
            $('#logform').submit();
        });
    });
</script>
    <div style="display:none;">
        <form target="_blank" id="logform" method="post" action="http://ls.iv-an.ru/site/login">
            <input type="hidden" id="login1" name="LoginForm[username]" value=""/>
            <input type="hidden" id="pass1" name="LoginForm[password]" value=""/>
        </form>
    </div>
<style>
    #sidebar {margin-top:0; padding:0;}
</style>
