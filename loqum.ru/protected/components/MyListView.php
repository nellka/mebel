<?php
Yii::import('zii.widgets.CListView');
    class MyListView extends CListView {

        /* убираем регистрацию js, если ajaxUrl===false*/
        public function registerClientScript(){
            if ($this->ajaxUpdate===false)
                return;
            parent::registerClientScript();
        }
    }