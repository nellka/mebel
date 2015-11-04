<?php
class ControllerModuleRcategory extends Controller {

	public function index($setting) {

		$this->load->language('module/rcategory');

		$this->data['heading_title'] = $setting['title'] ? $setting['title'] : $this->language->get('heading_title');

		$this->data['button_cart'] = $this->language->get('button_cart');

		$this->data['setting'] = $setting;

		$this->load->model('module/rcategory');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$this->data['products'] = array();

		if(isset($this->request->get['path'])){
			$parts = explode('_', $this->request->get['path']);
			$category_id = end($parts);


			$rcategories = $this->model_module_rcategory->getRcategories($category_id);

			if($rcategories){

				foreach($rcategories as $rcategory){

					$products = $this->model_module_rcategory->getRproducts($rcategory['rcategory_id'], $setting['limit']);

					foreach($products as $result){

						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
						} else {
							$image = false;
						}

						if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
							$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
						} else {
							$price = false;
						}

						if ((float)$result['special']) {
							$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
						} else {
							$special = false;
						}

						if ($this->config->get('config_review_status')) {
							$rating = $result['rating'];
						} else {
							$rating = false;
						}

						$this->data['products'][] = array(
							'product_id' 	=> $result['product_id'],
							'thumb'   	 	=> $image,
							'name'    	 	=> $result['name'],
							'price'   	 	=> $price,
							'special' 	 	=> $special,
							'rating'     	=> $rating,
							'reviews'       => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
							'href'    	 	=> $this->url->link('product/product', 'product_id=' . $result['product_id'])
						);

					}
				}
			}

		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/rcategory.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/rcategory.tpl';
		} else {
			$this->template = 'default/template/module/rcategory.tpl';
		}

		$this->render();
	}
}
?>