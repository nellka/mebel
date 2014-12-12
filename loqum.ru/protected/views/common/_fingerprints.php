<?php if (!Yii::app()->user->getState('AnketaFingerprint') && !Yii::app()->user->isGuest) {
    Yii::app()->clientScript->registerScriptFile('/js/jquery.flash.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile('/js/plugin-detect-0.6.3.js',CClientScript::POS_HEAD);
    ?>
<div id="b2info"></div>
<script type="text/javascript" src="/js/fetch_whorls.js"></script>
<? } ?>
<?php if (!Yii::app()->user->isGuest && time()-Yii::app()->user->getState('EtagFingerprint') > 3600) {
    Yii::app()->user->setState('EtagFingerprint',time());
    echo CHtml::image('/images/0x0.gif');
} ?>