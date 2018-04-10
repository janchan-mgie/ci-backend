<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../libraries/Crud_Contorller.php';
require_once __DIR__ . '/../libraries/Crud.php';
class Guest extends Crud {
	protected function _page_data($where = NULL) {
		if (!$this->ion_auth->is_admin()) {
			$this->core_model->fields('id, firstname, lastname');
		}
	}
	protected function _page_filter() {
		// $this->core_model->where('email IS NOT NULL', NULL, NULL, NULL, NULL, TRUE);
		// return $this->core_model->where('email', 'like', 'test');
		// $this->core_model->where('email IS NULL', NULL, NULL, NULL, NULL, TRUE);
	}
	protected function _db_insert_extra() {
		return NULL;
  	$data['email'] = 'email@test.com';
  	$data['updated_at'] = NULL;
  	// $data['id'] = 93;
  	return $data;
	}
}
