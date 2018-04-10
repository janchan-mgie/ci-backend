<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../libraries/Crud_Contorller.php';
require_once __DIR__ . '/../libraries/Crud.php';
class Guest_photo extends Crud {
	protected function _page_data() {
		$this->core_model->fields('id,saved')->with_guest('fields:firstname,lastname')->with_photo('fields:img_url');
	}
	protected function _page_filter() {
		// $data = $this->input->get();
		$this->_set_search_query($this->input->get());
		if (!$this->ion_auth->is_admin()) {
			$this->core_model->where('guest_id', $this->ion_auth->user()->row()->id);
		}
	}
	//
	protected function _view_add_extra() {
		foreach ($this->core_model->has_one as $key => $relation) {
			$this->load->model($relation[0], strtolower($relation[0]));
		}
		$data['all_guest'] = $this->guest_model->as_dropdown('CONCAT(firstname, " " , lastname)')->get_all();
		$data['all_photo'] = $this->photo_model->as_dropdown('img_url')->get_all();
		return $data;
	}
	protected function _view_edit_extra() {
		$this->load->model('guest_model');
		$this->load->model('photo_model');
		$data['all_guest'] = $this->guest_model->as_dropdown('CONCAT(firstname, " " , lastname)')->get_all();
		$data['all_photo'] = $this->photo_model->as_dropdown('img_url')->get_all();
		return $data;
	}
}
