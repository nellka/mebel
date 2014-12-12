<?php

$cs = Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/lightbox/js/jquery.lightbox-0.5.min.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/init_lightbox.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->request->baseUrl . '/js/lightbox/css/jquery.lightbox-0.5.css');

if (!isset ($hidebuttons)) $hidebuttons = false;
if ($hidebuttons) {
    $this->breadcrumbs=array(
    	'Профиль'=>array('/profile'),
    	'Мои фото'=>array('/profile/photos'),
    	'Предпросмотр',
    );
} else {
//$this->breadcrumbs=array(
    //	'Анкеты'=>array('index'),
    //	'Поиск',
    //);
}
$this->layout = '//layouts/column1';
//if (!isset ($models)) {
//    $models = Anketa::model()->
//}

?>
<?php if  ($hidebuttons) { ?> <a href="javascript:history.back();">Вернуться </a> <?php } ?>
<?php if ($count) echo
"<h1>"
.Yii::t('app', ' Найдена | Найдено | Найдено | Найдено ', $count)
."<span id=\"totalcount\">$count</span>  "
.Yii::t('app', ' анкета| анкеты| анкет| анкеты', $count)."</h1>"; ?>

<?php //print_r (Yii::app()->user->searchdata);?>
<table id="big2foto" width="100%" align="center" style="text-align:center;">
    <tr>
        <td align="center">
<?php $this->renderPartial('//anketa/_simplebig',array('model'=>$models[0],'hidebuttons'=>$hidebuttons)) ?>
        </td>
        <td align="center">
<?php $this->renderPartial('//anketa/_simplebig',array('model'=>$models[1],'hidebuttons'=>$hidebuttons)) ?>
        </td>
    </tr>
</table>
<?php if (!Yii::app()->request->getIsAjaxRequest()) { ?>
<script language="javascript" type="text/javascript">
function reloaded() {
	deccount();
	rescroll();
	reimage ();
}
function deccount(){
        val = $('#totalcount').html()-1;
        $('#totalcount').html(val);
}

<?php if (!$hidebuttons) { ?>
$("#big2foto .like").live('click', function () {
    div = $(this).parent('div');
    divid = div.attr('id').substr(1, 100);
    try {
        otherdivid = $('#big2foto div.simplebig').not('#u' + divid).attr('id').substr(1, 100);
    } catch (e) {
        otherdivid = 0;
    }

    $.post('/anketa/getajax/' + otherdivid, {like:divid},
    function (data) {
        div.parent().html(data);
        reloaded();
    }
    );
});
$("#big2foto .dislike").live ('click', function() {
    div = $(this).parent('div');
    divid = div.attr('id').substr(1,100);
    try {
        otherdivid = $('#big2foto div.simplebig').not('#u'+divid).attr('id').substr(1,100);
    } catch (e) {
        otherdivid=0;
    }

   $.post('/anketa/getajax/'+otherdivid,{dislike:divid}, //+otherdivid
        function(data){
            div.parent().html(data);
            reloaded();
        }
    );
});
$("#big2foto .next").live ('click', function() {
    div = $(this).parent('div');
    divid = div.attr('id').substr(1,100);
    try {
        otherdivid = $('#big2foto div.simplebig').not('#u'+divid).attr('id').substr(1,100);
    } catch (e) {
        otherdivid=0;
    }

   $.post('/anketa/getajax/'+otherdivid,{next:divid},
        function(data){
            div.parent().html(data);
            reloaded();
        }
    );
});
    <?php } ?>

var leftlast;
var rightlast;
function reimage () {
set2biglightbox();
}
function rescroll() {
	// $('#big2foto.photos').each( function(index,el) {
		//var lastLi[index] = ul.find('li:last-child');
	// });
	var div1 = $('div.photos').eq(0),
		div2 = $('div.photos').eq(1),
		ulPadding = 10;


	/*div1.css('border','solid 1px #ccc');*/
    var div1Width = div1.width();
    var div2Width = div2.width();

    //Remove scrollbars
    //div.css({overflow: 'hidden'});

    //Find last image container
    var lastLi1 = div1.find('a:last-child img');
    var lastLi2 = div2.find('a:last-child img');

    //When user move mouse over menu

    div1.mousemove(function(e){
      if (lastLi1.data()==null) return;
      var ulWidth = lastLi1[0].offsetLeft + lastLi1.outerWidth() + ulPadding;
      var left = (e.pageX - div1.offset().left) * (ulWidth-div1Width) / div1Width;
      div1.scrollLeft(left);		  
	})
    div2.mousemove(function(e){
      if (lastLi2.data()==null) return;
      var ulWidth = lastLi2[0].offsetLeft + lastLi2.outerWidth() + ulPadding;
      var left = (e.pageX - div2.offset().left) * (ulWidth-div2Width) / div2Width;
      div2.scrollLeft(left);		  
	})	
}

$(document).ready (function() {
rescroll() ;
reimage ();
});

</script>
<? } ?>
<?php
if (!Yii::app()->request->isAjaxRequest)
    if (!$hidebuttons && $this->getRoute() != 'anketa/index') {
        ?>
    <p align="center"><?php echo CHtml::link('Хватит', array('anketa/search', 'id' => 'clean'))?>
        | <?php echo CHtml::link('Новый поиск', array('anketa/search', 'id' => 'newsearch'))?></p>
    <p align="center"></p>
    <?php } ?>
