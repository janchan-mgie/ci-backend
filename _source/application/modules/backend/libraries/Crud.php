<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../libraries/Backend_Controller.php';
class Crud extends Backend_Controller {
	public $module;
	public $controller;
	public $controller_url;
	public $per_page;
	public $back_url;
	//
	public function __construct() {
    parent::__construct();
		//
		$this->module = $this->router->fetch_module();
		$this->controller = $this->router->class;
		$this->controller_url = $this->module . '/' . $this->controller . '/';
		$this->per_page = 3;
	 	$this->load->model($this->controller . '_model', 'core_model');
	}
	//
	protected function _page_data() {
		// Default : Select ALL fields
		// e.g. $this->core_model->fields('id, firstname, lastname');
	}
	protected function _page_filter() {
		// Default : No filter
		// e.g. $this->core_model->where('id', 1);
	}
	//
	protected function _view_add_extra() {
		return array();
	}
	protected function _view_edit_extra() {
		return array();
	}
	//
	protected function _db_insert_extra() {
		return NULL;
	}
	protected function _db_update_extra() {
		return NULL;
	}
	//
	protected function _after_create($info = NULL) {
		$this->_back_index($info);
	}
	protected function _after_update($info = NULL) {
		redirect($this->_get_back_url());
	}
	protected function _after_delete($info = NULL) {
		redirect($this->_get_referrer());
	}
	//
	function index() {
		redirect($this->controller_url . 'page');
	}
	function page($page = 1) {
		// $this->core_model->pagination_delimiters = array('<li>','</li>', '<li class="active">', '<li class="disabled">');
		$this->core_model->pagination_delimiters = array('li', "temp", 'data="test"', array('active' => 'active', 'disabled' => 'disabled'));
		// $this->_page_filter();
		// $total_records = $this->core_model->count_rows();
		$total_records = $this->_get_total_records();
		$this->_page_filter();
		$this->_page_data();
		$data_list = $this->core_model->paginate($this->per_page, $total_records);
		//
		if ($data_list === FALSE) {
			if ($page != 1) {
				redirect($this->controller_url . 'page');
			} else {
				$data_list = array();
			}
		}
		$data[$this->controller . '_list'] = $data_list;
		$data['total_records'] = $total_records;
		$data['pagination'] = $this->core_model->all_pages;
		// TEMP: to-be-removed
		$this->load->library('table');
		//
		$this->_render($data);
	}
	//
	function add() {
		if (!empty($this->input->post())) {
			// $record_id = FALSE;
      // $this->form_validation->set_rules($this->core_model->rules['insert']);
			// if ($this->form_validation->run()) {
			// 	$record_id = $this->core_model->insert($this->input->post());
			// }
			//
			$record_id = $this->core_model->from_form(NULL, $this->_db_insert_extra(), NULL)->insert();
			//
			if ($record_id !== FALSE) {
				// Add success
				$this->_after_create();
				return;
			}
		} else {
			$this->_set_back_url();
		}
		$this->load->library('Form_builder');
		$this->form = new Form_builder();
		$this->_render(array_merge(array('back_url' => $this->_get_back_url()), $this->_view_add_extra()));
	}
	//
	function edit($id) {
		$record = $this->core_model->get($id);
		// check if the record exists before trying to edit it
		if (isset($record['id'])) {
			if (!empty($this->input->post())) {
				$record_id = $this->core_model->from_form(NULL, $this->_db_update_extra(), array('id'))->update(NULL, array('id' => $id));
				//
				// $record_id = FALSE;
	     	// $this->form_validation->set_rules($this->core_model->rules['update']);
				// if ($this->form_validation->run()) {
				// 	$record_id = $this->core_model->update($this->input->post(), $id);
				// }
				//
				if ($record_id !== FALSE) {
					// Edit success
					$this->_after_update();
					return;
				}
			} else {
				$this->_set_back_url();
			}
			$this->load->library('Form_builder');
			$this->form = new Form_builder();
			$this->_render(array_merge(array($this->controller => $record, 'back_url' => $this->_get_back_url()), $this->_view_edit_extra()));
		} else {
			show_error('The users_group you are trying to edit does not exist.');
		}
	}
	//
	function remove($id) {
		$record = $this->core_model->get($id);
		// check if the record exists before trying to delete it
		if (isset($record['id'])) {
			$this->core_model->delete($id);
			$this->_after_delete();
			return;
		} else {
			show_error('The users_group you are trying to delete does not exist.');
		}
	}
	//
	private function _get_referrer() {
		$this->load->library('user_agent');
		return empty($this->agent->referrer()) ? base_url($this->controller_url) : $this->agent->referrer();
	}
	private function _set_back_url() {
		$this->session->set_userdata($this->controller . '_back_url', $this->_get_referrer());
	}
 	protected function _get_back_url() {
		return $this->session->userdata($this->controller . '_back_url');
	}
	private function _back_index($info = NULL) {
		redirect($this->controller_url);
	}
	//
	private function _get_total_records() {
		$this->_page_filter();
		return $this->core_model->count_rows();
	}
	protected function _set_search_query($data = NULL) {
		if (count($data) !== 0) {
			foreach ($data as $key => $value) {
				// Check whether the field exists in table
				if ($this->db->field_exists($key, $this->core_model->table)) {
					$this->core_model->where($key, $value);
				}
			}
		}
	}
	//
	private function _render($data) {
		$data['controller_url'] = $this->controller_url;
		$this->template->setContent($this->controller . '/' . $this->router->method, $data);
		$this->template->render();
	}
	//
	private function _db_query() {
		var_dump($this->db->last_query());
	}
}
