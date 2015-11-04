<?php
class ControllerModuleFilterPro extends Controller {

	protected function index($setting) {
		if($setting['type'] == 1) {
			$this->language->load('product/filter');
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_list'] = $this->language->get('text_list');
			$this->data['text_grid'] = $this->language->get('text_grid');
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');

			$sort = 'p.sort_order';
			$order = 'ASC';
			$limit = $this->config->get('config_catalog_limit');

			$url = '';

			if(isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href' => $this->url->link('product/filter', 'sort=p.sort_order&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href' => $this->url->link('product/filter', 'sort=pd.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href' => $this->url->link('product/filter', 'sort=pd.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href' => $this->url->link('product/filter', 'sort=p.price&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href' => $this->url->link('product/filter', 'sort=p.price&order=DESC' . $url)
			);

			if($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href' => $this->url->link('product/filter', 'sort=rating&order=DESC' . $url)
				);

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => $this->url->link('product/filter', 'sort=rating&order=ASC' . $url)
				);
			}

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href' => $this->url->link('product/filter', 'sort=p.model&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href' => $this->url->link('product/filter', 'sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if(isset($this->request->get['sort'])) {
				$url .= 'sort=' . $this->request->get['sort'];
			}

			if(isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$this->data['limits'] = array();

			$this->data['limits'][] = array(
				'text' => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href' => $this->url->link('product/filter', $url . '&limit=' . $this->config->get('config_catalog_limit'))
			);

			$this->data['limits'][] = array(
				'text' => 25,
				'value' => 25,
				'href' => $this->url->link('product/filter', $url . '&limit=25')
			);

			$this->data['limits'][] = array(
				'text' => 50,
				'value' => 50,
				'href' => $this->url->link('product/filter', $url . '&limit=50')
			);

			$this->data['limits'][] = array(
				'text' => 75,
				'value' => 75,
				'href' => $this->url->link('product/filter', $url . '&limit=75')
			);

			$this->data['limits'][] = array(
				'text' => 100,
				'value' => 100,
				'href' => $this->url->link('product/filter', $url . '&limit=100')
			);


			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;

			$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

			$this->data += $this->language->load('product/category');
			$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filterpro_container.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/filterpro_container.tpl';
			} else {
				$this->template = 'default/template/module/filterpro_container.tpl';
			}
		} else {
			$this->language->load('module/filterpro');

			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');
			$this->data['text_price_range'] = $this->language->get('text_price_range');
			$this->data['text_manufacturers'] = $this->language->get('text_manufacturers');
			$this->data['text_tags'] = $this->language->get('text_tags');
			$this->data['text_categories'] = $this->language->get('text_categories');
			$this->data['text_attributes'] = $this->language->get('text_attributes');
			$this->data['text_all'] = $this->language->get('text_all');
			$this->data['clear_filter'] = $this->language->get('clear_filter');
			$this->data['text_instock'] = $this->language->get('text_instock');

			$this->data['pds_sku'] = $this->language->get('pds_sku');
			$this->data['pds_upc'] = $this->language->get('pds_upc');
			$this->data['pds_location'] = $this->language->get('pds_location');
			$this->data['pds_model'] = $this->language->get('pds_model');
			$this->data['pds_brand'] = $this->language->get('pds_brand');
			$this->data['pds_stock'] = $this->language->get('pds_stock');
			$this->data['symbol_right'] = $this->currency->getSymbolRight();
			$this->data['symbol_left'] = $this->currency->getSymbolLeft();

			$this->data['setting'] = $setting;

			if(VERSION == '1.5.0') {
				$filterpro_setting = unserialize($this->config->get('filterpro_setting'));
			} else {
				$filterpro_setting = $this->config->get('filterpro_setting');
			}

			$this->data['heading_title'] = $filterpro_setting['filterpro_name'];

			$category_id = false;
			$this->data['path'] = "";
			if(isset($this->request->get['path'])) {
				$this->data['path'] = $this->request->get['path'];
				$parts = explode('_', (string)$this->request->get['path']);
				$category_id = array_pop($parts);
			}

			$manufacturer_id = false;
			if(isset($this->request->get['manufacturer_id'])) {
				$manufacturer_id = $this->request->get['manufacturer_id'];
				$data = array(
					'filter_manufacturer_id' => $this->request->get['manufacturer_id']
				);
			} else {
				$data = array(
					'filter_category_id' => $category_id,
					'filter_sub_category' => false
				);
			}

			$this->load->model('catalog/product');
			$product_total = $this->model_catalog_product->getTotalProducts($data);
			if($product_total < 2) {
				return;
			}

			$this->data['category_id'] = $category_id;

			$data = array('category_id' => $category_id, 'manufacturer_id' => $manufacturer_id);

			$this->load->model('module/filterpro');

			$this->data['manufacturers'] = false;
			if(isset($this->request->get['manufacturer_id'])) {
				$this->data['manufacturer_id'] = $this->request->get['manufacturer_id'];
			} else {
				if($filterpro_setting['display_manufacturer'] != 'none') {
					$this->data['manufacturers'] = $this->model_module_filterpro->getManufacturers($data);
					$this->data['display_manufacturer'] = $filterpro_setting['display_manufacturer'];
					$this->data['expanded_manufacturer'] = isset($filterpro_setting['expanded_manufacturer']) ? 1 : 0;
				}
			}
			$this->data['options'] = $this->model_module_filterpro->getOptions($data);
			$this->load->model('tool/image');
			foreach($this->data['options'] as $i => $option) {
				if(!isset($filterpro_setting['display_option_' . $option['option_id']])) {
					$filterpro_setting['display_option_' . $option['option_id']] = 'none';
				}
				$display_option = $filterpro_setting['display_option_' . $option['option_id']];
				if($display_option != 'none') {
					$this->data['options'][$i]['display'] = $display_option;
					$this->data['options'][$i]['expanded'] = isset($filterpro_setting['expanded_option_' . $option['option_id']]) ? 1 : 0;
					foreach($this->data['options'][$i]['option_values'] as $j => $option_value) {
						$this->data['options'][$i]['option_values'][$j]['thumb'] = $this->model_tool_image->resize($this->data['options'][$i]['option_values'][$j]['image'], 20, 20);
					}
				} else {
					unset($this->data['options'][$i]);
				}
			}
			$this->data['tags'] = array();


			if(version_compare(VERSION, "1.5.4") <= 0 && $filterpro_setting['display_tags'] != 'none') {
				$this->data['tags'] = $this->model_module_filterpro->getTags($data);
				$this->data['expanded_tags'] = isset($filterpro_setting['expanded_tags']) ? 1 : 0;
			}

			$this->data['categories'] = false;
			if($filterpro_setting['display_categories'] != 'none') {
				$this->data['categories'] = $this->model_module_filterpro->getSubCategories($data);
				$this->data['expanded_categories'] = isset($filterpro_setting['expanded_categories']) ? 1 : 0;
			}

			$this->data['attributes'] = $this->model_module_filterpro->getAttributes($data);


			foreach($this->data['attributes'] as $j => $attribute_group) {
				foreach($attribute_group['attribute_values'] as $attribute_id => $attribute) {
					if(!isset($filterpro_setting['display_attribute_' . $attribute_id])) {
						$filterpro_setting['display_attribute_' . $attribute_id] = 'none';
					}
					$display_attribute = $filterpro_setting['display_attribute_' . $attribute_id];
					if($display_attribute != 'none') {
						if($display_attribute == 'slider') {
							$values = $this->data['attributes'][$j]['attribute_values'][$attribute_id]['values'];
							$first = $values[0];
							$this->data['attributes'][$j]['attribute_values'][$attribute_id]['suffix'] = preg_replace("/^[0-9]*/", '', $first);

							$values = array_map('intVal', $values);
							$values = array_unique($values);
							sort($values);
							$this->data['attributes'][$j]['attribute_values'][$attribute_id]['values'] = $values;
						}
						$this->data['attributes'][$j]['attribute_values'][$attribute_id]['display'] = $display_attribute;
						$this->data['attributes'][$j]['attribute_values'][$attribute_id]['expanded'] = isset($filterpro_setting['expanded_attribute_' . $attribute_id]) ? 1 : 0;
					} else {
						unset($this->data['attributes'][$j]['attribute_values'][$attribute_id]);
						if(!$this->data['attributes'][$j]['attribute_values']) {
							unset($this->data['attributes'][$j]);
						}
					}
				}
			}

			$this->data['filter_groups'] = array();
			$this->load->model('catalog/category');

			$this->data['option_main_checkbox'] = isset($filterpro_setting['option_main_checkbox']) ? 1 : 0;
			if(version_compare(VERSION, "1.5.5") >= 0 && $filterpro_setting['filters']==1) {
				$this->data['expanded_filters'] = isset($filterpro_setting['expanded_filters']) ? 1 : 0;
				$filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);
				
				if ($filter_groups) {
					foreach ($filter_groups as $filter_group) {
						$filter_data = array();
						
						foreach ($filter_group['filter'] as $filter) {
							$data = array(
								'filter_category_id' => $category_id,
								'filter_filter'      => $filter['filter_id']
							);	
							
							$filter_data[] = array(
								'filter_id' => $filter['filter_id'],
								'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($data) . ')' : '')
							);
						}
						
						$this->data['filter_groups'][] = array(
							'filter_group_id' => $filter_group['filter_group_id'],
							'name'            => $filter_group['name'],
							'filter'          => $filter_data
						);
					}
				} 
			}

			$this->data['price_slider'] = $filterpro_setting['price_slider'];
			$this->data['attr_group'] = $filterpro_setting['attr_group'];

			$this->data['instock_checked'] = isset($filterpro_setting['instock_checked']) ? 1 : 0;
			$this->data['instock_visible'] = isset($filterpro_setting['instock_visible']) ? 1 : 0;

			if($this->data['options'] || $this->data['manufacturers'] || $this->data['attributes'] || $this->data['price_slider']) {
				$this->document->addScript('catalog/view/javascript/jquery/jquery.tmpl.min.js');
				$this->document->addScript('catalog/view/javascript/jquery/jquery.deserialize.min.js');
				$this->document->addScript('catalog/view/javascript/jquery/jquery.loadmask.min.js');
				$this->document->addScript('catalog/view/javascript/filterpro.min.js');
				$this->document->addScript('catalog/view/javascript/jquery/jquery.lazyload.min.js');

				if(isset($filterpro_setting['jscrollpane'])) {
					$this->document->addScript('catalog/view/javascript/jquery/jscrollpane/jquery.mousewheel.js');
					$this->document->addScript('catalog/view/javascript/jquery/jscrollpane/jquery.jscrollpane.min.js');
					$this->document->addStyle('catalog/view/javascript/jquery/jscrollpane/jquery.jscrollpane.css');
				}

				if (isset($filterpro_setting['theme_mega'])){
					$this->document->addStyle('catalog/view/theme/default/stylesheet/filterpro-mega.css');
					$this->document->addScript('catalog/view/javascript/jquery/qtip2/mega/jquery.qtip.min.js');
					$this->document->addStyle('catalog/view/javascript/jquery/qtip2/mega/jquery.qtip.min.css');
				} else{
					$this->document->addStyle('catalog/view/theme/default/stylesheet/filterpro.css');
					$this->document->addScript('catalog/view/javascript/jquery/qtip2/jquery.qtip.min.js');
					$this->document->addStyle('catalog/view/javascript/jquery/qtip2/jquery.qtip.min.css');
				}
				$this->document->addStyle('catalog/view/theme/default/stylesheet/jquery.loadmask.css');
				if($this->config->get('config_template') == 'shoppica2') {
					$this->document->addStyle('catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css');
				}
			}

			$this->data['filter_redirect'] = false;
			if(isset($this->request->get['filter_redirect'])) {
				$this->data['filter_redirect'] = $this->request->get['filter_redirect'];
			}

			$this->data['filter_hash'] = false;
            if(isset($this->request->get['filter_id'])) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filterpro_seo WHERE `url`='" . $this->db->escape("filter_id=" . $this->request->get['filter_id']) . "'");
                if ($query->num_rows){
                    $filterpro_seo = unserialize($query->row['data']);
                    $this->data['filter_hash'] = $filterpro_seo['url'];
                }
            }

			$this->data['filterpro_container'] = $filterpro_setting['filterpro_container'];
			$this->data['filterpro_afterload'] = html_entity_decode($filterpro_setting['filterpro_afterload'], ENT_QUOTES, 'UTF-8');

			if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filterpro.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/filterpro.tpl';
			} else {
				$this->template = 'default/template/module/filterpro.tpl';
			}
		}
		$this->render();
	}

	public function getProducts() {
		if(!isset($this->request->post['min_price'])) {
			return;
		}
		$this->load->model('module/filterpro');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$getTotals = false;
		if(isset($this->request->post['getTotals']) && $this->request->post['getTotals']) {
			$getTotals = true;
		}


		list($filterpro_setting, $page, $limit, $manufacturer_id, $attribute_value, $option_value, $category_id, $data) = $this->model_module_filterpro->getData();

		$totals_manufacturers = array();
		if ($getTotals && $filterpro_setting['display_manufacturer'] != 'none' && !isset($this->request->post['manufacturer_id'])){
			$totals_manufacturers = $this->model_module_filterpro->getTotalManufacturers($data);
		}

		$totals_options = array();
		$totals_attributes = array();
		$totals_categories = array();
		$totals_tags = array();

		if($getTotals) {
			$totals_options = $this->model_module_filterpro->getTotalOptions($data);
			if(!isset($this->filterpro_setting['option_total_simple'])) {
				if($option_value) {
					foreach($option_value as $option_id => $option_value_id) {
						foreach($totals_options as $i => $totals_option) {
							if($totals_option['o'] == $option_id) {
								unset($totals_options[$i]);
							}
						}
						$temp_data = $data;
						unset($temp_data['option_value'][$option_id]);
						foreach($this->model_module_filterpro->getTotalOptions($temp_data) as $option) {
							if($option['o'] == $option_id) {
								$totals_options[] = $option;
							}
						}
					}
				}
			}

			$totals_attributes = $this->model_module_filterpro->getTotalAttributes($data);
			if(!isset($filterpro_setting['attr_total_simple'])) {
				foreach($attribute_value as $attribute_id => $values) {
					foreach($totals_attributes as $i => $attribute) {
						if($attribute['id'] == $attribute_id) {
							unset($totals_attributes[$i]);
						}
					}

					$temp_data = $data;
					unset($temp_data['attribute_value'][$attribute_id]);
					foreach($this->model_module_filterpro->getTotalAttributes($temp_data) as $attribute) {
						if($attribute['id'] == $attribute_id) {
							$totals_attributes[] = $attribute;
						}
					}
				}
			}

			$totals_tags = array();

			if(version_compare(VERSION, "1.5.4") <= 0) {
				$totals_tags = $this->model_module_filterpro->getTotalTags($data);
			}

			$totals_categories = $this->model_module_filterpro->getTotalCategories($data, $category_id);
		}
		$results = $this->model_module_filterpro->getProducts($data);

		$min_price = false;
		$max_price = false;

		if(isset($this->request->post['getPriceLimits']) && $this->request->post['getPriceLimits']) {
			$priceLimits = $this->model_module_filterpro->getPriceLimits(array('category_id' => $category_id, 'manufacturer_id' => $manufacturer_id));
			$min_price = $priceLimits['min_price'];
			$max_price = $priceLimits['max_price'];
		}

		$this->request->get['path'] = isset($this->request->post['path']) ? $this->request->post['path'] : '';

		$product_total = $this->model_module_filterpro->getTotalProducts($data);
		$result_html = $this->getHtmlProducts($results, $product_total);

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&page={page}');
		$pagination = $pagination->render();

		$k = 1;
		if((float)$filterpro_setting['tax'] > 0) {
			$k = 1 + (float)$filterpro_setting['tax'] / 100;
		}
		$min_price = $this->currency->convert($min_price * $k, $this->config->get('config_currency'), $this->currency->getCode());
		$max_price = $this->currency->convert($max_price * $k, $this->config->get('config_currency'), $this->currency->getCode());




		$json = json_encode(array('result_html' => $result_html, 'min_price' => $min_price, 'max_price' => $max_price, 'pagination' => $pagination,
								 'totals_data' =>
								 $getTotals ?
										 array('manufacturers' => $totals_manufacturers,
														'options' => $totals_options,
														'attributes' => $totals_attributes,
														'categories' => $totals_categories,
														'tags' => $totals_tags)
										 : false));
		$this->response->setOutput($json);
	}


	private function getHtmlProducts($results, $product_total) {

		$this->data += $this->language->load('product/category');

		$this->data['use_lazyload'] = isset($filterpro_setting['use_lazyload']) ? 1 : 0;

		$this->data['products'] = array();

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}
			//this for swap image
			$images = $this->model_catalog_product->getProductImages($result['product_id']);

            if(isset($images[0]['image']) && !empty($images[0]['image'])){
              $images =$images[0]['image'];
           } 
			//  var_dump( $image,$images);
			 //  echo '<br><br>';
				//
			$this->data['products'][] = array(
				'product_id'  => $result['product_id'],
				'thumb'       => $image,
				'name'        => $result['name'],
				// for swap image
				'thumb_swap'  => $this->model_tool_image->resize($images, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')), 
				//
				 'length' =>	$result['length'],
				 'width' =>	$result['width'],
				 'height' =>	$result['height'],  	
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'price'       => $price,
				'special'     => $special,
				'tax'         => $tax,
				'rating'      => $result['rating'],
				'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'])
			);
		}
//die();  
		if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filterpro_list.tpl') &&
		   file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filterpro_grid.tpl')
		) {
			$this->template = $this->config->get('config_template') . '/template/module/filterpro_list.tpl';
			$return['list'] = $this->render();
			$this->template = $this->config->get('config_template') . '/template/module/filterpro_grid.tpl';
			$return['grid'] = $this->render();
			return $return;
		} elseif(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filterpro_products.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/filterpro_products.tpl';
		} else {
			$this->template = 'default/template/module/filterpro_products.tpl';
		}
		return $this->render();
	}
}

?>