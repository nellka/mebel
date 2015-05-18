<?php
/* @var $this SiteController */
$me = Yii::app()->user->me;
$this->pageTitle=$me->username;
?>

<h3>Сформировать заказ</h3>
<b><i>Логин: </i></b><?=$me->username?><br>
<b><i>Email: </i></b><?=$me->email?><br>
<b><i>Телефон:</i></b> <?=$me->phone?><br><br>


<?php $this->pageTitle = 'Список товаров - сформировать заказ'; /** @var $currentFolder MessageFolder */?>
<h3>Список товаров</h3>

<div id="message-list-sort">
<?php echo CHtml::beginForm(array('order/doOrder'),'post',array('onsubmit'=>'js:return checkForm();')); ?>
<?php foreach ($products as $data){ 
    $this->renderPartial('_productlist_item',compact('data','anketa','newCnt','new','cnt','k','message','lastvisit','countphotos'));
} ?>

<div class="row">
	Комментарий к заказу<br>
	<?php echo CHtml::textArea('comment','',array('rows'=>6, 'cols'=>50)); ?>
</div>	
	
<?php echo CHtml::submitButton('Заказать',array('class'=>'blue-button')); ?>
<?php echo CHtml::endForm(); ?>
</div>
<script type="text/javascript">
    function checkForm(){
        if ($('input[name="id[]"]:checked').size()==0) {
            alert ('Следует выбрать товары для заказа');
            return false;
        }
        return true;
    }
</script>