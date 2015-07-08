<?php
class ControllerModuleFeaturedManufacturers extends Controller {
	protected function index($setting) {
		$this->language->load('module/featured_manufacturers');

    $this->data['heading_title'] = $this->language->get('heading_title');

    $this->load->model('catalog/manufacturer');

    $this->load->model('tool/image');

    $manufacturersIds = explode(',', $this->config->get('featured_manufacturers'));

    if (empty($setting['limit'])) {
      $setting['limit'] = 5;
    }
    $manufacturersIds = array_slice($manufacturersIds, 0, (int)$setting['limit']);

    $this->data['manufacturers'] = array();

    foreach ($manufacturersIds as $manufacturer_id) {
      $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

      if ($manufacturer_info) {

        if ($manufacturer_info['image'] and isset($setting['show_image'])) {
          $image = $this->model_tool_image->resize($manufacturer_info['image'], $setting['image_width'], $setting['image_height']);
        } else {
          $image = false;
        }

        if ( isset($setting['show_title'])) {
          $manufacturer_title = $manufacturer_info['name'];
        } else {
          $manufacturer_title = false;
        }

        if(version_compare(VERSION, '1.5.4', "<")){
          $manufacturer_link = 'product/manufacturer/product';
        } else {
          $manufacturer_link = 'product/manufacturer/info';
        }
        $this->data['manufacturers'][] = array(
          'manufacturer_id' => $manufacturer_info['manufacturer_id'],
          'thumb'   	      => $image,
          'href'            => $this->url->link($manufacturer_link, 'manufacturer_id=' . $manufacturer_info['manufacturer_id']),
          'name'            => $manufacturer_title
        );
      }
    }

    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured_manufacturers.tpl')) {
      $this->template = $this->config->get('config_template') . '/template/module/featured_manufacturers.tpl';
    } else {
      $this->template = 'default/template/module/featured_manufacturers.tpl';
    }

    $this->render();

    ////////////////////////////////////////////////////

	}
}
?>