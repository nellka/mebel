<h1>Статистика сообщений</h1>
<?php
$this->pageTitle ='Статистика переписок';
$this->renderPartial('_menu',compact('model'));
$this->widget('zii.widgets.grid.CGridView',
    array(
        'dataProvider'=>$dataProvider,
        'template'=>'{items}',
    )
);
?>
<p>общее количество бесед.<br/>
количество бесед по каждому из условий.</p>
