<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {
  // CI instance
  private $CI;
  // Template Data
  private $template_data = array();
  public $template = '';
  public $template_module = '';
  public $template_path = '_templates';
	//
  public function __construct() {
		$this->CI =& get_instance();
		$this->template_data['extra_js'] = array();
		$this->template_data['extra_css'] = array();
  }
  function loadView($view = NULL, $data = NULL) {
		$this->CI->load->view($this->template_path . '/' . $this->template . '/' . $view, $data);
  }
	//
  function set($template = NULL) {
		if ($template !== NULL) {
    	$this->template = $template;
		}
  }
  function setPath($template_path = NULL) {
		if ($template_path !== NULL) {
    	$this->template_path = $template_path;
		}
  }
  function setModule($template_module = NULL) {
		if ($template_module !== NULL) {
    	$this->template_module = $template_module;
		}
  }
	//
	function setValues($array = NULL) {
		foreach ($array as $key => $value) {
    	$this->setValue($key, $value);
		}
	}
  function setValue($key = NULL, $value = NULL) {
		if ($key !== NULL) {
    	$this->template_data[$key] = $value;
		}
  }
	function setView($template_key = NULL, $view = NULL, $view_data = NULL) {
		$this->setValue($template_key, $this->CI->load->view($view, $view_data, TRUE));
	}
	// Same as setView('content', $view, $view_data);
  function setContent($view = NULL, $view_data = NULL) {
    $this->setView('content', $view, $view_data);
  }
	//
	function addJs($filename = NULL, $path = NULL) {
		$this->template_data['extra_js'][] = ($path ? $path . '/' : 'js/') . $filename . '.js';
	}
	function addCss($filename = NULL, $path = NULL) {
		$this->template_data['extra_css'][] = ($path ? $path . '/' : 'css/') . $filename . '.css';
	}
	//
  function render($template = NULL, $template_path = NULL, $return = FALSE) {
		if ($template !== NULL) {
			$this->set($template);
		}
		if ($template_path !== NULL) {
			$this->setPath($template_path);
		}
		//
    $temp_path = $this->template_path . '/' . $this->template;
    $view_path = (empty($this->template_module) ? '' : $this->template_module . '/') . $temp_path;
    $real_path = APPPATH . (empty($this->template_module) ? '' : 'modules/' . $this->template_module . '/') . 'views/' . $temp_path . '.php';
    //
    if (file_exists($real_path)) {
    	$html = $this->CI->load->view($view_path, $this->template_data, $return);
  		if ($return) {
  			return $html;
  		}
		} else {
			show_error("Template [{$this->template}] not found<br>Target path: {$real_path}", 500, "Template Not Found");
		}
  }
}
?>
