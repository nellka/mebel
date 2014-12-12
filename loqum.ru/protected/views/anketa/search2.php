<?php
$this->breadcrumbs=array(
//	'Анкеты'=>array('/anketa'),
	'Поиск',
);?>
<h1>Поиск анкет</h1>
<?php
//if (isset(Yii::app()->user->searchdata))
//    print_r(Yii::app()->user->searchdata);

print_r (AnketaSearch::getLastVisitValues());
$times = array();
$times[-1] = time();
foreach (AnketaSearch::getLastVisitValues() as $k=>$v){
    $times[$k] = strtotime($k);
}
foreach ($times as $time) {
    echo "<br>$time - ".date ('d.m.Y H:i',$time);
}
echo "<br><br>";
echo $model->last_visit;
echo strtotime($model->last_visit);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-form',
    'action'=>array('anketa/search'),
    'method'=>'get',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); /** @var $form CActiveForm
 * @var $model AnketaSearch; */?>
    <table>
        <?php if (0 && Yii::app()->user->isGuest) { ?>
        <tr>
            <td>Я</td>
            <td><?php echo $form->dropDownList($model,'mygender',Anketa::$getGenders) ?></td>
        </tr>
        <? } ?>
<? /*
        <tr>
            <td>Ищу</td>
            <td><?php echo $form->checkBoxList($model,'gender',Anketa::$getGenders); //CHtml::checkBoxList('mygender',0,Anketa::$getGenders) ?></td>
        </tr>
*/ ?>
        <tr>
            <td>Последнее посещение</td>
            <td><?php echo $form->dropDownList($model,'last_visit',$model->getLastVisitValues(),array('empty'=>'за все время')); //CHtml::checkBoxList('mygender',0,Anketa::$getGenders) ?></td>
        </tr>
        <tr>
            <td>Возраст</td>
            <td>от <?php echo $form->textField($model,'agefrom',array('size'=>2)) ?> до <?php echo $form->textField($model,'ageto',array('size'=>2)) ?></td>
        </tr>
        <tr>
            <td>Откуда</td>
            <td>
<?php echo $form->dropDownList($model,'location',array(
    'Москва'=>'Москва',
    'Санкт-Петербург'=>'Санкт-Петербург',
    'Саратов'=>'Саратов',
    'Красноярск'=>'Красноярск',
    'Екатеринбург'=>'Екатеринбург',
    'Воронеж'=>'Воронеж',
    'Краснодар'=>'Краснодар',
    'Ростов-на-Дону'=>'Ростов-на-Дону',
    'Иркутск'=>'Иркутск',
    'Хабаровск'=>'Хабаровск',
    'Пермь'=>'Пермь'), array('empty'=>'выберите город')) ?>
            </td>
        </tr>
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
        <tr>
            <td>с фото</td>
            <td> <?php echo $form->checkBox($model,'withphoto'); ?></td>
        </tr>
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