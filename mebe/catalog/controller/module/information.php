<?php  
class ControllerModuleInformation extends Controller {
	protected function index() {
	    $params = array(4=>array('hide_in_left'=>true,'css'=>""),
	                    3=>array('hide_in_left'=>true,'css'=>""),
	                    5=>array('hide_in_left'=>true,'css'=>""),
	                    8=>array('hide_in_left'=>false,'css'=>"info1"),
	                    9=>array('hide_in_left'=>false,'css'=>"info2"),
	                    10=>array('hide_in_left'=>false,'css'=>"info3"),
	                    6=>array('hide_in_left'=>false,'css'=>"info4"),
	                    11=>array('hide_in_left'=>false,'css'=>"info5"),
	                    12=>array('hide_in_left'=>false,'css'=>"info6"),
	                    13=>array('hide_in_left'=>false,'css'=>"info7"),
	                    14=>array('hide_in_left'=>false,'css'=>"info8"),
	                    15=>array('hide_in_left'=>false,'css'=>"info9"));
		$this->language->load('module/information');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
    	
		$this->data['text_contact'] = $this->language->get('text_contact');
    	$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		
		$this->load->model('catalog/information');
		
		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
      		$this->data['informations'][] = array(
        		'title' => $result['title'],
        		'hide' => $params[$result['information_id']]['hide_in_left'],
        		'css' => $params[$result['information_id']]['css'],
	    		'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
      		);
    	}

		$this->data['contact'] = $this->url->link('information/contact');
    	$this->data['sitemap'] = $this->url->link('information/sitemap');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/information.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/information.tpl';
		} else {
			$this->template = 'default/template/module/information.tpl';
		}
		
		$this->render();
	}
}
?>