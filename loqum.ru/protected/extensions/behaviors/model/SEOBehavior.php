<?php
class SEOBehavior extends CActiveRecordBehavior {

    public $route;

    public $tableName='{{seo}}';

    protected $data;

    private function rules() {
		return array(
            array('metaTitle, metaKeywords, metaDescription', 'filter', 'filter'=>'strip_tags'),
			array('seoText', 'safe'),
			array('metaTitle, metaKeywords, metaDescription', 'length', 'max'=>500),
		);
    }

    public function attach($owner) {
        $validators=$owner->getValidatorList();
        foreach($this->rules() as $rule)
            $validators->add(CValidator::createValidator($rule[1],$owner,$rule[0],array_slice($rule,2)));

        parent::attach($owner);
    }
    
    public function setMetaTitle($metaTitle) {
        $this->load();
        $this->data['metaTitle']=$metaTitle;
    }
	
    public function setMetaKeywords($metaKeywords) {
        $this->load();
        $this->data['metaKeywords']=$metaKeywords;
    }

    public function setMetaDescription($metaDescription) {
        $this->load();
        $this->data['metaDescription']=$metaDescription;
    }

	 public function setSeoText($seoText) {
        $this->load();
        $this->data['seoText']=$seoText;
    }


    public function getMetaTitle() {
        $this->load();
        return $this->data['metaTitle'];
    }

    public function getMetaKeywords() {
        $this->load();
        return $this->data['metaKeywords'];
    }

    public function getMetaDescription() {
        $this->load();
        return $this->data['metaDescription'];
    }

    public function getSeoText() {
        $this->load();
        return $this->data['seoText'];
    }

    public function afterSave() {
        if($this->data===null)
            return;

        if($this->isEmpty()) {
            $sql="DELETE FROM $this->tableName WHERE route=:route AND params=:params LIMIT 1";
            Yii::app()->db->createCommand($sql)->execute(array(
                ':route'=>$this->route,
                ':params'=>$this->params,
            ));
        } else {
            $sql="INSERT INTO $this->tableName (route,params,metaTitle,metaKeywords,metaDescription,seoText) VALUES (:r,:p,:t,:k,:d,:s)" .
                 "ON DUPLICATE KEY UPDATE metaTitle=:t, metaKeywords=:k, metaDescription=:d, seoText=:s";
            Yii::app()->db->createCommand($sql)->execute(array(
                ':r'=>$this->route,
                ':p'=>$this->params,
                ':t'=>$this->metaTitle,
                ':k'=>$this->metaKeywords,
                ':d'=>$this->metaDescription,
                ':s'=>$this->seoText,
            ));
        }
    }

    protected function load() {
        if($this->data===null) {
            $meta=Yii::app()->db->createCommand()
                ->select('metaTitle,metaKeywords,metaDescription,seoText')
                ->from($this->tableName)
                ->where('route=:route AND params=:params', array(':route'=>$this->route, ':params'=>$this->params))
                ->queryRow();
            $this->data=($meta)?$meta:array('metaTitle'=>'', 'metaKeywords'=>'', 'metaDescription'=>'', 'seoText'=>'');
        }
    }

    protected function getParams() {
        return
        isset ($this->owner->seoParams) ? $this->owner->seoParams :
         'id='.$this->owner->id;
    }

    protected function isEmpty() {
        if($this->data===null)
            return true;

        $empty=true;
        foreach($this->data as $val)
            $empty=$empty && empty($val);
        return $empty;
    }

}