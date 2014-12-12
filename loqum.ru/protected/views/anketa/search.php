<?php
 $this->pageTitle = 'Поиск';
$this->breadcrumbs=array(
//	'Анкеты'=>array('/anketa'),
	'Поиск',
);?>
<h1>Ищу парня</h1>
<?php
//if (isset(Yii::app()->user->searchdata))
//    print_r(Yii::app()->user->searchdata);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-form',
    'action'=>array('anketa/search'),
    'method'=>'get',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); /** @var $form CActiveForm */?>
    <table style="width:300px">
        <?php if (0 && Yii::app()->user->isGuest) { ?>
        <tr>
            <td>Я</td>
            <td><?php echo $form->dropDownList($model,'mygender',Anketa::$getGenders) ?></td>
        </tr>
        <? } ?>
<? /*
        <tr>
            <td>Ищу</td>
            <td><?php echo $form->checkBoxList($model,'gender',Anketa::$getGendersGenitive); //CHtml::checkBoxList('mygender',0,Anketa::$getGenders) ?></td>
        </tr>
*/ ?>
<? /*
        <tr>
            <td>Последнее посещение</td>
            <td><?php echo $form->dropDownList($model,'last_visit',$model->getLastVisitValues(),array('empty'=>'за все время')); //CHtml::checkBoxList('mygender',0,Anketa::$getGenders) ?></td>
        </tr>
*/ ?>
        <? if (1) { // Yii::app()->user->role == 'admin' ?>
            <tr>
                <td>Online</td>
                <td><?php echo $form->checkBox($model,'last_visit',array('value'=>'online')); //CHtml::checkBoxList('mygender',0,Anketa::$getGenders) ?></td>
            </tr>
        <? } ?>
        <tr>
            <td>Возраст</td>
            <td>от <?php echo $form->textField($model,'agefrom',array('size'=>2)) ?> до <?php echo $form->textField($model,'ageto',array('size'=>2)) ?></td>
        </tr>
        <tr>
            <td>Откуда</td>
            <td>
<?php echo $form->dropDownList($model,'location',Anketa::getCities(), array('empty'=>'выберите город','class'=>'mainselect')) ?>
            </td>
        </tr>
<? /*
        <tr>
            <td>Цели встречи</td>
            <td>
                <?php echo $form->checkBoxList($model,'goals',array_combine(Anketa::goalsArray(),Anketa::goalsArray())); ?>
            </td>
        </tr>
*/ ?>
<? /*        <tr>
            <td>Рост</td>
            <td>от <?php echo $form->textField($model,'heigthfrom',array('size'=>3)) ?> до <?php echo $form->textField($model,'heigthto',array('size'=>3)) ?></td>
        </tr>
        <tr>
            <td>Вес</td>
            <td>от <?php echo $form->textField($model,'weightfrom',array('size'=>3)) ?> до <?php echo $form->textField($model,'weightto',array('size'=>3)) ?></td>
        </tr> */ ?>
<? /*        <tr>
            <td>Пол</td>
            <td><?php echo $form->dropDownList($model,'gender',Anketa::$getGenders) ?></td>
        </tr> */ ?>
<?/*
        <tr>
            <td>с фото</td>
            <td> <?php echo $form->checkBox($model,'withphoto'); ?></td>
        </tr>
*/ ?>
        <tr>
            <td colspan="2"><input type="submit" value="Найти"/>
                <!--input name="savedata" value="Сохранить условия и найти" type="submit"/--></td>
        </tr>
    </table>
<?php $this->endWidget(); ?>

<?php
//$itemview = $_SERVER['REMOTE_ADDR'] == '89.169.186.44'?'_simplerow':'_simplesmall';
$itemview = '_simplerow';
$this->renderPartial('_list',array('dataProvider'=>$model->search(),'itemview'=>$itemview));
?>