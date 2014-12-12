<?php

Yii::app()->clientScript->registerScriptFile('/js/jquery.cooike.js');
Yii::app()->clientScript->registerScriptFile('/js/scripts.js');
Yii::app()->clientScript->registerPackage('jquery');

$product->offers(array('order'=>'price_rur'));

$count = max(3, count($product->offers));
$this->pageTitle = CHtml::encode($product->name)
    ." в кредит - $count предложен".Yii::t('app','ие|ия|ий',$count)
    .'! Купить '.$product->getShortName().' в кредит не выходя из дома!';
if ($product->metaTitle) $this->pageTitle = $product->metaTitle;
$this->breadcrumbs = array(
    //'Каталог' => array('/catalog'),
);

$cat = $product->category;
//echo $product->cat_id.' '. $cat->id."###";
$bc = array(CHtml::encode($cat->name) => $cat->link);
while ($cat = $cat->lparent) {
    if ($cat->parent) // убрать верхний уровень из крошек
    $bc[CHtml::encode($cat->name)] = $cat->link;
}
$bc = array_reverse($bc);
$this->breadcrumbs = array_merge($this->breadcrumbs, $bc);

$this->breadcrumbs[ucfirst($product->brands[0]->name)]
    = '/category/' . $product->category->id . '/brand/' . $product->brands[0]->id;
//$this->breadcrumbs[] = CHtml::encode($product->name);

$price_max = 0; $price_min = 99999999;

if ($product->offers) {
    foreach ($product->offers as $offer) {
        $price_max = (int) max ($price_max,$offer->priceRur);
        $price_min = (int) min ($price_min,$offer->priceRur);
    }
$offerscount = count($product->offers);
$offer = $product->offers[0];
}
?>
<form method="post" action="/site/request" onsubmit="return checkfields();">
<div id="product_info">
<input type="hidden" name="productname" value="<?=CHtml::encode($product->name)?>" />
<input type="hidden" name="firsttotalsend" value="" />
<input type="hidden" name="monthtotalsend" value="" />
<?php echo CHtml::image($product->imageUrl,CHtml::encode($product->name),array('align'=>'left','class'=>'cimage'))
//CHtml::link(,array('product', 'id' => $product->id)); ?><h1 align="center"><?php echo CHtml::encode($product->name); ?>  <br/><span class="red">в кредит</span></h1>

<?php if ($product->offers) {?>
<div style="width:550px;margin-left:170px;">
 <span class="noffers">Цена: <?=$price_min?>
     <?=($price_min == $price_max ?'':"...$price_max");?> руб.</span><?//= "$offerscount предложен". Yii::t('app','ие|ия|ий',$offerscount); //Интернет-магазины ?></span>

<!--br/><span class="minmax">Самовывоз: <b>да</b><br/-->
Доставка: <?=$offer->ship;?> руб. или можно забрать в офисе (м. Владыкино.)<br>
Доставка: только <span class="red">Москва</span> и ближайшее Подмосковье
</span>
        <p><br>После оформления заказа <span class="red">держите телефон включенным</span> – кредитный специалист перезвонит вам для оформления кредита по телефону:<br/>
        - в рабочие дни с 10.00 до 18.00 в течение часа после заказа.<br/>
        - в выходные – с 12.00 до 18.00 в течение полутора часов.<br/>
        - если заказ сделан ночью – наутро.<br/>
            </p><p>
        Доставка: <? switch ((int)$offer->ship) {
        case 350: $t ='в течение дня после оформления кредита';break;
        case 500: $t='1-2 дня после оформления кредита';break;
        case 600: $t='1-3 дня после оформления кредита';break;
        default: $t='1-3 дня после оформления кредита';
    } echo $t;?>
        .<br/>
        Все кредитные документы доставляются одновременно с заказом.<br/>
        </p>
        
        
    </div>
<? } else {?>
    <p>ожидается в продаже.</p>
    <? } ?>
    <div style="float:none;">
        <?php //$offer = $product->offers[0];
        if ($offer->description) { ?><br/>
        <?php echo $offer->description;//str_replace(',','<br>',$offer->description); ?>
        <br>
        <?php } else {
            echo nl2br($product->description);
        } ?>
    </div>

    <!--p id="producthint"><span class="big blue">Подсказка</span>: заказ оформляйте на нашем сайте. <br/>Интернет-магазин получит его автоматически</p-->
    <br clear="all"/>

<?php if ($product->offers) { $row = 0;  ?>
<? /* <hr><h2>Где купить <?php echo $product->getShortName() ?> в кредит?</h2>*/ ?>
<table>
<!--tr class="offerrow">
    <td></td>
    <td></td>
    <td class="orange"><?= "$offerscount предложен". Yii::t('app','ие|ия|ий',$offerscount); //Интернет-магазины ?> </td>
    <td>Доставка</td>
    <td class="num">Цена</td>
    <td></td>
</tr-->
    <?php foreach ($product->offers as $offer){ ?>
<tr id="or<?=$offer->id?>" class="offerrow <?= $row++%2?'even':'odd' ?>">
    <td class="vtop bold"><?//=$row?></td>
    <td class="vtop" style="display:none;"><input type="radio" name="buyoffer" value="<?=$offer->id?>" checked="checked"/></td>
    <td></td>
    <td class="offertd"><span class="offertitle hide"><?php echo ' '.$offer->name //  CHtml::link(' '.$offer->name,array('go','id'=>$offer->id),array('target'=>'_blank'))?></span><br/>
        <span title="<?php echo $offer->priceRur?>" class="price hide"><?php echo (int) $offer->priceRur?> руб.</span>
		<?//=$offer->getAvailableText(); ?> <span style="display:none;">в <?= "<span class='shopname'>{$offer->shop->name}</span>"?></span>
		<div style="display:none"><br/><span title="<?=$offer->ship?>" class="ship"><?php echo $offer->ship?></span> руб.  доставка   <span class="shopprice" title="<?=$offer->id?>"><?php echo $offer->price_rur?></span>  </div>
		<div class="btn_buy hide"></div>
    </td><td colspan="2"></td>
<? /*    <td><?php echo CHtml::link($offer->shop->name.' '.$offer->name,array('go','id'=>$offer->id),array('target'=>'_blank'))?></td> */ ?>
<? /*    <td title="<?=$offer->ship?>" class="ship"><?php echo $offer->ship?> руб. </td>
    <td title="<?php echo $offer->priceRur?>" class="num price"><b><?php echo $offer->priceRur?> руб. </b></td>*/ ?>
<? /*    <td><img src="/imgs/buy-btn.png" alt="Купить" /> </td> */ ?>
</tr>
    <?php }
echo "</table>";
} ?>
    <?php if ($product->offers) $this->renderPartial('_creditcalc',compact('offer')) ?>
<?php
if ($product->hars) {

    echo '<table width="100%">';
    foreach ($product->hars as $har) {
        echo "<tr><td width='40%'>{$har['har_name']}</td><td>{$har['har_value']}</td></tr>";
    }
    echo '</table>';
}
?>

</div>
</form>
<?php if ($product->seoText) echo $product->seoText; ?>