<?php
$this->pageTitle = 'Все геи в городе '.$city->name. ' ';
if (!empty($city->metaTitle))
    $this->pageTitle = $city->metaTitle;

?>


<div class="goods-row mens-row">
    <div class="headline nuclear">
        <h2>Наши парни г. <?=$city->name?></h2>
        <span class="text city"></span>
    </div>

    <div class="row nuclear">
        <?php $this->renderPartial('/anketa/_list', array('dataProvider' => $manProvider,'itemview'=>'/anketa/_simplemain')); ?>
    </div>
</div>
<?php
$seo_text = $city->seoText ? $city->seoText : "<p>На нашем сайте знакомятся парни города {$city->name}.</p>";
?>
<div class="about nuclear">
    <?php if (!$seo_text) { ?> <h1>Все геи города <?=$city->name?></h1> <?php } ?>
    <div class="item">
        <?php echo $seo_text ?>
    </div>
    <? /*
    <div class="left-column">
        <div class="item">


        </div>
    </div>
    <div class="right-column">
        <div class="item">
        </div>
        <br clear="all">
    </div> */ ?>

    <a class="red" href="/city/">Все города &raquo;</a><br/>
</div>
