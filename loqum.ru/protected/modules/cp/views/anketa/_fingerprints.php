<?php if ($model->fingerprints): ?>
<?php
$attributes = array('user_agent','fonts','plugins',);//'accept'
$attributes = array('user_agent','fonts','plugins',);//'accept'
?>
<?php foreach ($attributes as $attribute) { ?>
    <h2><?=$attribute?></h2>
    <?php
        $prints = array();
        $i = 1;
        foreach ($model->fingerprints as $fingerprint) {
            if (!in_array($fingerprint->$attribute,$prints)) {
                $prints[] = $fingerprint->$attribute;
                if (in_array($fingerprint->$attribute,array('No Flash or Java fonts detected','undefined','undefined (via Flash)','(via Flash)'))) {
                    echo "<p class='red'>$i Нет</p>";$i++; continue;
                }
                echo
                    ($_SERVER['REMOTE_ADDR'] != '89.169.186.440')?FingerprintBan::drawForm(array('id_anketa'=>$model->id,'type'=>FingerprintBan::$types[$attribute],'value'=>md5($fingerprint->$attribute))):'',
                "<p><b>$i "
                ,mb_substr($fingerprint->$attribute,0,100000,'utf-8')," </b></p>";
                $i++;

                if(!$fingerprints = AnketaFingerprint::model()->findAllByAttributes(array($attribute.'_md5' => $fingerprint->{$attribute.'_md5'}),array('condition'=>'id_anketa <> '.$model->id,'limit'=>21))) //'id_anketa'=>'<>'.$model->id
                    continue;
                if (count($fingerprints) > 20)
                    echo "Больше 20 <span class='pointer blue toggle_sibling'> Показать/скрыть </span> <div style='display:none'>";
                else echo "<div>";
                echo "<table>";
                foreach ($fingerprints as $fpclone) {
                    $zombie = $fpclone->anketa;
//                    echo CHtml::link($zombie->name.", {$zombie->age}, {$zombie->city}",$zombie->link,array('target'=>'_blank'))  ;

//                    echo "<tr><td><span ><a class='$class' target='_blank' href='http://www.nic.ru/whois/?query={$ipdata['ip']}'>{$ipdata['ip']}</span></td>";
                    echo "<td>".CHtml::link($zombie->name.", {$zombie->age}, {$zombie->city}",$zombie->link,array('target'=>'_blank'))."</td>";
                    echo CHtml::tag('td',array(),$zombie->contact_count.' cnt');
                    echo CHtml::tag('td',array(),CHtml::link('переписка','/cp/message/list/'.$zombie->id,array('target'=>'_blank')));
                    echo CHtml::tag('td',array(),CHtml::link('IP','/cp/anketa/zombie/'.$zombie->id,array('target'=>'_blank')));
                    echo CHtml::tag('td',array('class'=>'red'),$zombie->isdeleted?'удалён':'');
                    echo "</tr>";

                    //echo CHtml::link();
                    //echo 'id='. $fpclone->id_anketa,' ',$fpclone->anketa->name,', ',$fpclone->anketa->location,', ',$fpclone->anketa->age, " * <br>";
                }
                echo "</table>";
                echo "</div>";


            }
        } ?><br/><br/>
    <?php } ?>
<?php endif; ?>
<script>
    $('.toggle_sibling').click(function(){$(this).next().toggle();});
</script>