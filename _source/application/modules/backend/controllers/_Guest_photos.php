<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../libraries/Backend_Controller.php';
class Guest_photos extends Backend_Controller {
	public $module;
	public $controller;
	public $controller_url;
	public $per_page;
	public $view_data_name;
	//
	public function __construct() {
    parent::__construct();
		//
	 	$this->load->model('guest_photo_model', 'core_model');
		$this->module = $this->router->fetch_module();
		$this->controller = $this->router->class;
		$this->controller_url = $this->module . '/' . $this->controller . '/';
		$this->per_page = 5;
		$this->view_data_name = $this->router->class;
	}
	//
	function index() {
		redirect($this->controller_url . 'page');
	}
	function page($page = 1) {
		$where = array('1' => 1);
		$total_records = $this->core_model->count_rows($where);
		//
		$data[$this->view_data_name] = $this->core_model->where($where)->fields('id,saved')->with_guest('fields:name')->with_photo('fields:img_url')->paginate($this->per_page, $total_records);
		//
		$data['pagination'] = $this->core_model->all_pages;
		//
		$this->_render($data);
	}
	//
	function edit($id) {
		// check if the record exists before trying to edit it
		$data[$this->view_data_name] = $this->core_model->get($id);
		if (isset($data[$this->view_data_name]['id'])) {
			$this->load->library('form_validation');
			//
			$this->form_validation->set_rules('photo_id','Photo','required');
			//
			if ($this->form_validation->run()) {
				$params = array(
					'photo_id' => $this->input->post('photo_id'),
				);
				//
				$this->core_model->update($params, $id);
				redirect($this->controller_url);
			} else {
				$this->load->model('guest_model');
				$data['all_guest'] = $this->guest_model->get_all();
				$this->load->model('photo_model');
				$data['all_photo'] = $this->photo_model->get_all();
				//
				$this->_render($data);
			}
		} else {
			show_error('The users_group you are trying to edit does not exist.');
		}
	}
	//
	function add() {
		$this->load->library('form_validation');
		//
		$this->form_validation->set_rules('guest_id','Guest','required');
		$this->form_validation->set_rules('photo_id','Photo','required');
		//
		if ($this->form_validation->run()) {
			$params = array(
				'guest_id' => $this->input->post('guest_id'),
				'photo_id' => $this->input->post('photo_id'),
			);
			//
			$record_id = $this->core_model->insert($params);
			redirect($this->controller_url);
		} else {
			$this->load->model('guest_model');
			$data['all_guest'] = $this->guest_model->get_all();
			$this->load->model('photo_model');
			$data['all_photo'] = $this->photo_model->get_all();
			//
			$this->_render($data);
		}
	}
	//
	function remove($id) {
		$record = $this->core_model->get($id);
		// check if the record exists before trying to delete it
		if (isset($record['id'])) {
			$this->core_model->delete($id);
			redirect($this->controller_url);
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
