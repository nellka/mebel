<?php
$this->renderPartial('_menu',compact('model'));
?>

<h1><?=$model->name . ', ' . $model->age . ', ' . $model->city . ($model->isBad() ? " / " . Anketa::$bad_statuses[$model->status_bad] : ''); ?></h1>
<p align="right">
    <?php
    echo CHtml::link('Админка',$model->link,array('target'=>'_blank')),' | ';
    echo CHtml::link('Сайт','/anketa/'.$model->id,array('target'=>'_blank')),' | ';
    echo CHtml::link('Переписка','/cp/message/list/'.$model->id,array('target'=>'_blank')),' | ';
    ?>
</p>
<?php if ($model->a2cookie) { // && $_SERVER['REMOTE_ADDR']=='89.169.186.44'
    echo "<h3>100% клоны (cookie):</h3>";
    $anketas = explode('_',trim($model->a2cookie->cookie,'_'));
    $clones = Anketa::model()->findAllByPk($anketas);
    foreach ($clones as $zombie) {
        if ($zombie->id == $model->id)
            continue;
        echo CHtml::link($zombie->name.", {$zombie->age}, {$zombie->city}",$zombie->link,array('target'=>'_blank'));
        echo ($zombie->isBad() ? " / ".Anketa::$bad_statuses[$zombie->status_bad] : '');
        echo " | ";
    }
    ?>
<br/><br/>
<? } ?>
<?php
    $etag = Yii::app()->db->createCommand('SELECT cookie FROM anketa2etag WHERE id =:id')->queryScalar(array(':id' => $model->id));
    if ($etag) {
        $ids = explode(':',$etag);
        if ($etagClones = Anketa::model()->findAllByPk($ids)) {
            echo "<h3>100% клоны (Etag):</h3>";
            foreach ($etagClones as $zombie) {
                if ($zombie->id == $model->id)
                    continue;
                echo CHtml::link($zombie->name.", {$zombie->age}, {$zombie->city}",$zombie->link,array('target'=>'_blank'));
                echo ($zombie->isBad() ? " / ".Anketa::$bad_statuses[$zombie->status_bad] : '');
                echo " | ";
            }
            echo '<br/><br/>';
        }
    }
 ?>
<h3>Подозрения (ip):</h3>
<table style="width:660px;">
<?php foreach ($iparray as $ipdata) {
    $zombie = $zombies[$ipdata['id']];
    $class = $zombie->id != $model->id ? 'red':'';
    echo "<tr><td><span ><a class='$class' target='_blank' href='http://www.nic.ru/whois/?query={$ipdata['ip']}'>{$ipdata['ip']}</span></td>";
    echo "<td nowrap='nowrap'>".FingerprintBan::drawForm(array('id_anketa'=>$zombie->id,'type'=>FingerprintBan::TYPE_IP,'value'=>$ipdata['ip']))."</td>";
    echo "<td>".CHtml::link($zombie->name.", {$zombie->age}, {$zombie->city}",$zombie->link,array('target'=>'_blank'))."</td>";
    echo CHtml::tag('td',array(),$zombie->contact_count.' cnt');
    echo CHtml::tag('td',array(),CHtml::link('переписка','/cp/message/list/'.$zombie->id,array('target'=>'_blank')));
    echo CHtml::tag('td',array(),CHtml::link('IP','/cp/anketa/zombie/'.$zombie->id,array('target'=>'_blank')));
    echo CHtml::tag('td',array('class'=>'red'),$zombie->isdeleted?'удалён':'');
    echo "</tr>";
} ?>
</table>
<?php $this->renderPartial('_fingerprints', compact('model')); ?>