<!-- registartion -->
<div class="registration nuclear">
    <img src="<?=Yii::app()->theme->baseUrl;?>/images/ban.jpg" alt="" class="bg" />
    <div class="reg-in">
        <div class="search">
            <!--div class="headline">Ищу </div-->
            <h3>Ищу парня</h3>
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
                <div class="sel-block">
                    <div class="row nuclear">
                        <div class="item">
                            <b class="hd">Возраст</b>
                            <?php echo $form->dropDownList($model,'agefrom',$ages,array('empty'=>'не указан')) ?>
                        </div>
                        <div class="item item-rht">
                            <b class="hd">&nbsp;</b>
                            <?php echo $form->dropDownList($model,'ageto',$ages,array('empty'=>'не указан')) ?>
                        </div>
                    </div>
                    <div class="row big-sel nuclear">
                        <b class="hd">Откуда</b>
                        <?php echo $form->dropDownList($model,'location',Anketa::getCities(), array('empty'=>'выберите город','class'=>'mainselect')) ?>
                    </div>
                </div>
                <div class="row nucelar">
                    <? if (1) { //Yii::app()->user->role == 'admin'?>
                        <div class="item">
                            <b class="hd item">Online</b>
                            <?php echo $form->checkBox($model,'last_visit',array('value'=>'online')); //CHtml::checkBoxList('mygender',0,Anketa::$getGenders) ?>
                        </div>
                    <? } ?>
                    <input type="submit" value="Искать!" class="but" />
                </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="search enter">
            <div class="headline">Вход на сайт</div>
            <?php $model=new LoginForm;?>
            <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form-main',
            'action'=>array('site/login'),
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>
                <div class="row nuclear">
                    <span class="txt">Логин</span>
                    <?php echo $form->textField($model,'username',array('onchange'=>"",'encode' => false,'class'=>'inp')); ?>
                </div>
                <div class="row nuclear">
                    <span class="txt">Пароль</span>
                    <?php echo $form->passwordField($model,'password',array('onchange'=>"",'encode' => false,'class'=>'inp')); ?>
                </div>
                <div class="row nuclear">
                    <div class="block">
                        <div class="inp-block nuclear">
                            <label for="Anketa[rememberMe]">Запомнить</label>
                            <?php echo $form->checkBox($model,'rememberMe'); ?>
                        </div>
                        <span class="link"><?php echo CHtml::link('Забыли пароль?', array('register/remember'));?></span>
                    </div>
                    <input type="submit" value="Войти" class="but" />
                </div>
                <?php $this->endWidget(); ?>
        </div>
    </div>
    <div class="freereg nuclear">
        <a title="Зарегистрироваться" href="/register/"><img src="/themes/muksil/images/free-registration.png" alt="Зарегистрироваться" width="165" height="161" /></a>
    </div>
    <div class="wannapage">
        <a title="Зарегистрироваться" href="/register/"><img src="/themes/muksil/images/iwannapage.gif" alt="Хочу свою страницу" /></a>
    </div>
</div>
<!--/ registartion -->
