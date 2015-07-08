<?php  
class ControllerModuleMainCategory extends Controller {
	protected function index($setting) {
	  
		$this->language->load('module/category');

		$this->data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$this->data['category_id'] = $parts[0];
		} else {
			$this->data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$total = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category['category_id']));

			$children_data = array();

			//$children = $this->model_catalog_category->getCategories($category['category_id']);
			if ($category['image'] && file_exists(DIR_IMAGE . $category['image'])) {
				$image = '/image/' . $category['image'];
			} else {
				$image = 'no_image.jpg';
			}

				
			$this->data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $total . ')' : ''),
				'image'      =>$image,
				//'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);	
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/maincategory.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/maincategory.tpl';
		} else {
			$this->template = 'default/template/module/maincategory.tpl';
		}
		$this->render();
	}
}
?>