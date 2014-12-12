<!-- registartion -->
<div class="registration inner-reg nuclear">
    <img src="<?=Yii::app()->theme->baseUrl;?>/images/ban1.jpg" alt="" class="bg" />
    <div class="reg-in">
        <div class="search">
            <!--div class="headline">Поиск</div-->
            <br><h3>Ищу парня</h3>
            <?php $model = new AnketaSearch; $model->loadDefaults(); ?>
            <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'search-form',
            'action'=>array('anketa/search'),
            'method'=>'get',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); /** @var $form CActiveForm */?>
            <?php $ages = array_combine(range(18,55), range(18,55)); ?>
<style>
    .inner-reg .search .row {width:270px;float:left;left:0;top:0;}
    .big-sel {margin-left:20px;}
</style>
                <div class="sel-block">
                    <div class="row nuclear">
                        <div class="item">
                            <b class="hd">Возраст</b>
                            <?php echo $form->dropDownList($model,'agefrom',$ages,array('empty'=>'не указан')) ?>
                        </div>
                        <div class="item item-last">
                            <b class="hd">&nbsp;</b>
                            <?php echo $form->dropDownList($model,'ageto',$ages,array('empty'=>'не указан')) ?>
                        </div>
                    </div>
                    <div class="row big-sel">
                        <b class="hd">Откуда</b>
                        <?php echo $form->dropDownList($model,'location',Anketa::getCities(), array('empty'=>'выберите город','class'=>'mainselect')) ?>
                    </div>
                </div>
            <? if (1) { //Yii::app()->user->role == 'admin'?>
                <div class="item">
                    <b class="hd item">Online</b>
                    <?php echo $form->checkBox($model,'last_visit',array('value'=>'online')); //CHtml::checkBoxList('mygender',0,Anketa::$getGenders) ?>
                </div>
            <? } ?>

            <input type="submit" value="Искать!" class="but" />
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<!--/ registartion -->