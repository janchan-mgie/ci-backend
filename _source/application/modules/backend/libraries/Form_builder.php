<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_builder {
  public $CI;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->helper('form');
	}
  function create($info) {
    $info['form_input_type'] = $info['type'];
    unset($info['type']);
    $this->CI->load->vars($info);
		$view = $this->CI->load->view('_form/field', $info, TRUE);
    $this->CI->load->clear_vars();
    return $view;
  }
  function create_all($input_list) {
    $result = '';
    foreach ($input_list as $key => $info) {
      $result .= $this->create($info);
    }
    return $result;
  }
}
