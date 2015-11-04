<?php

class ModelModuleRcategory extends Model {

	public function getRcategories($category_id){

		$query = $this->db->query("SELECT cr.rcategory_id, cd.name FROM " . DB_PREFIX . "category_related  cr LEFT JOIN " . DB_PREFIX . "category_description cd ON (cr.rcategory_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (cd.category_id = c2s.category_id) WHERE cr.category_id = " . (int)$category_id . " AND cd.language_id='" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY cd.name");

		return ($query->num_rows ? $query->rows : false);
	}

	public function getRproducts($category_id, $limit){

		$product_data = array();

		$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id=p2c.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2c.category_id = '" . (int)$category_id ."' ORDER BY RAND() LIMIT " . (int)$limit);

		$this->load->model('catalog/product');

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getRcategoryLink($category_id){

		$query = $this->db->query("SELECT parent_id FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");

		return ($query->row['parent_id'] == 0) ? $query->row['parent_id'] : $query->row['parent_id'] . "_" . $category_id;

	}

}