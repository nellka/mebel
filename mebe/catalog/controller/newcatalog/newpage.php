<?php  
class ControllerNewcatalogNewpage extends Controller {
    public function index() {
        $this->document->setTitle($this->config->get('config_title'));
        $this->document->setDescription($this->config->get('config_meta_description'));
        $this->data['heading_title'] = $this->config->get('config_title');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/newcatalog/newpage.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/newcatalog/newpage.tpl';
            $this->data['template'] = $this->config->get('config_template');
        } else {
            $this->template = 'default/template/newcatalog/newpage.tpl';
        }
        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/subheader',
            'common/header'
        );                            
        $this->response->setOutput($this->render());
    }
}
?>