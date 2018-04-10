<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../libraries/Backend_Controller.php';
class Crud_Contorller extends Backend_Controller {
	public $module;
	public $controller;
	public $controller_url;
	public $per_page;
	public $view_data_name;
	//
	public function __construct() {
    parent::__construct();
		//
		$this->module = $this->router->fetch_module();
		$this->controller = $this->router->class;
		$this->controller_url = $this->module . '/' . $this->controller . '/';
		$this->per_page = 5;
		$this->view_data_name = $this->router->class . '_list';
	 	$this->load->model($this->controller . '_model', 'core_model');
	}
	//
	function page_data($where = NULL) {
		return NULL;
	}
	function page_filter($where = NULL) {
		return $where;
	}
	function add_validation() {
	}
	function add_data() {
  	return NULL;
	}
	function add_extra_data() {
  	return NULL;
	}
	function before_add() {
	}
	function post_add() {
		redirect($this->controller_url);
	}
	//
	function edit_validation() {
	}
	function edit_data() {
  	return NULL;
	}
	function edit_extra_data() {
		return NULL;
	}
	function before_edit() {
	}
	function post_edit() {
		redirect($this->controller_url);
	}
	//
	function before_remove() {
	}
	function post_remove() {
		redirect($this->controller_url);
	}
	//
	//
	function index() {
		redirect($this->controller_url . 'page');
	}
	function page($page = 1) {
		$where = $this->page_filter();
		$total_records = $this->core_model->count_rows($where);
		$data[$this->controller . '_list'] = $this->page_data($where)->paginate($this->per_page, $total_records);
		//
		$data['pagination'] = $this->core_model->all_pages;
		//
		$this->_render($data);
	}
	//
	function add() {
		$this->load->library('form_validation');
		$this->add_validation();
		if ($this->form_validation->run()) {
			$this->before_add();
			$record_id = $this->core_model->insert($this->add_data());
			$this->post_add();
		} else {
			$this->_render($this->add_extra_data());
		}
	}
	//
	function edit($id) {
		// check if the record exists before trying to edit it
		$data[$this->controller] = $this->core_model->get($id);
		if (isset($data[$this->controller]['id'])) {
			$this->load->library('form_validation');
			$this->edit_validation();
			if ($this->form_validation->run()) {
				$this->before_edit();
				$this->core_model->update($this->edit_data(), $id);
				$this->post_edit();
			} else {
				$this->_render(array_merge($data, $this->edit_extra_data()));
			}
		} else {
			show_error('The users_group you are trying to edit does not exist.');
		}
	}
	//
	function remove($id) {
		$record = $this->core_model->get($id);
		// check if the record exists before trying to delete it
		if (isset($record['id'])) {
			$this->before_remove();
			$this->core_model->delete($id);
			$this->post_remove();
		} else {
			show_error('The users_group you are trying to delete does not exist.');
		}
	}
	//
	function _render($data) {
		$data['controller_url'] = $this->controller_url;
		$this->template->setContent($this->controller . '/' . $this->router->method, $data);
		$this->template->render();
	}
}
