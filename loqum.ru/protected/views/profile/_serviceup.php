<div style="float:right; width:300px; margin-left:50px; height:400px;">
    <?php echo CHtml::link('Просмотреть свою анкету',  $anketa->link)?>
    <?php if ($anketa->isBad() || $anketa->isinactive) { ?>
    <h2>убрана из поиска</h2>
    <? } else { ?>
    <h2>Вы на <span class="pink"><?=$anketa->place?></span> месте</h2>
    <? } ?>

    <?php $anketas = array($anketa,$anketa->next()); $model = $anketa; ?>
    <?php foreach ($anketas as $anketa) { ?>
    <?php $countphotos = count($anketa->photos);?>
    <div class="profilephoto">
        <div class="pph-place<?=$anketa->id == Yii::app()->user->id?' arrow':''?>"><?=$anketa->place?></div>
        <div class="pph-photo"><?php echo CHtml::link(CHtml::image($anketa->mainPhotoUrl), $anketa->link, array('target' => '_blank')); ?></div>
        <div class="pph-info">
            <?php echo CHtml::link($anketa->name,  $anketa->link)?>,
            Возраст: <?=$anketa->age?><br/>
            <?=$anketa->countryCity?><br>
            <?=($countphotos > 0 ? $countphotos : 'Нет') . ' фото'?>
        </div>
    </div>
    <br clear="both"/>
    <? } ?>
    <?php $anketa = $model; ?>
<? /* //TODO
    <div class="anketa-up">
        Поднятие анкеты - <span class="pink">100 рублей</span><br>
        <?php if ($anketa->balance >= 100) { ?>
        У вас на счету <span class="green">достаточно денег</span>
        <form method="post" action="/profile/orderService"><br>
            <input type="hidden" name="service" value="1"/>
            <input type="submit" name="up" class="blue-button" value="Поднять анкету"/>
        </form>
        <? } else { ?>
        У вас на счету <span class="pink">недостаточно денег</span><br><br>
        <?php $this->widget('BillingFormWidget'); ?>
        <? } ?>
        <br/>
        <?php if (0) { ?>
            <a href="/profile/payservices">Другие платные возможности</a>
        <? } ?>
    </div>
*/ ?>
</div>
