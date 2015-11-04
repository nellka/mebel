<?
class ControllerCatalogSpecial extends Controller{
    public function index(){
        $template="default/template/catalog/special.tpl"; // .tpl location and file
        // Если используется модель, создаем ее и снимаем комент
        // $this->load->model('catalog/special.php');
        $this->template = ''.$template.'';
        $this->children = array(
        'common/header',
        'common/content_top',
        'common/column_left',
        'common/column_right',
        'common/content_bottom',
        'common/footer'
        );
        $this->response->setOutput($this->render());
    }
}
?>