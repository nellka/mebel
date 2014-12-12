<?php if ($itemview == '_simplerow') : ?><div class="result"><?php endif; ?>
<?php
$this->widget('MyListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => !isset($itemview)?'_simplesmall':$itemview, // refers to the partial view named '_post'
    'emptyText' => 'Ничего не найдено',
    'ajaxUpdate'=>false, // отключаем ajax поведение
    'summaryText' => '',//'Всего: {count}',
    'id'=>isset ($listViewId)?$listViewId:'results',
    'cssFile'=>false,
    'pagerCssClass'=>'pager nuclear',
    'pager' => array(
        'id' => 'pager',
        'maxButtonCount'=>7,
        'cssFile'=>false,
        'internalPageCssClass'=>false,
        'header' => '<span class="txt">Страницы</span>',
        'nextPageLabel' =>'&gt;',
        'prevPageLabel' =>'&lt;',
    ),
));
?>
<?php if ($itemview == '_simplerow') : ?></div><?php endif; ?>
