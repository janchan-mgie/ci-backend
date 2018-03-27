<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Auth_Controller.php';
class Backend_Controller extends Auth_Controller {
	public function __construct() {
		parent::__construct();
		// Load ressource
		// $this->load->config('lte_elements');
		// $this->load->config('lte_sidebar_menu');
		// $this->load->library(array('breadcrumbs', 'sidebar_menu'));
		// $this->load->helper(array('adminlte'));
    //
		$this->load->config('backend', TRUE);
		$this->load->library('template');

    $this->auth_base = $this->config->item('auth_base', 'backend');
		$this->auth_front_page = $this->config->item('auth_front_page', 'backend');
    //
		$non_backend = array(
			'login',
			'forgot_password',
			'reset_password',
			'activate',
		);
		$current_route = str_replace($this->auth_base . '/', '', uri_string());

		// if (uri_string() !== $this->auth_base . '/login') {
		if (!in_array($current_route, $non_backend)) {
    	$this->load->library('ion_auth');
		  if (!$this->ion_auth->logged_in()) {
		    $this->goto_login();
		  } else {
				$this->template_name = $this->config->item('template', 'backend');
	    	$this->template->set($this->template_name);
	    	$this->template->setModule($this->auth_base);
	    	// $this->template->setPath('x_templates');
				// Get user login infos
		    $this->template->setValue('user_info', $this->ion_auth->user()->row());
				//
				$side_menu = $this->config->item('side_menu', 'backend');
				$user_style = $this->config->item('side_menu_style', 'backend');
				$this->load->library('layout');
			  foreach ($side_menu as $key => $menu) {
					$side_menu_array[] = $this->layout->menuItem($menu, $user_style);
				}
				$this->template->setValue('side_menu_array', $side_menu_array);
		    //
				// $this->data['title_sm'] = $this->config->item('title_sm');
				// $this->data['title_lg'] = $this->config->item('title_lg');
				// $this->data['assets']   = base_url($this->config->item('assets_backend'));
				// $this->data['theme']    = $this->config->item('theme_backend');
				//
				// $this->data['sidebar_menu'] = $this->sidebar_menu->generate($this->config->item('array_sidebar_menu'));
			}
		} else {
			// None backend pages
			switch ($current_route) {
				case 'forgot_password':
					// $this->template_name = 'temp';
					break;
				case 'login':
					// $this->template_name = 'temp';
					break;
				default:
					break;
			}
		}
	}
	//
	// Overwrite Auth render function with template library
	public function _render_page($view, $data = NULL, $returnhtml = FALSE) {
		$this->viewdata = (empty($data)) ? $this->data : $data;

		if (isset($this->template_name)) {
			$view = $this->auth_base . '/' . $view;
			$this->template->setContent($view, $this->viewdata);
			$view_html = $this->template->render($this->template_name, NULL, $returnhtml);
		} else {
			$view_html = $this->load->view($view, $this->viewdata, $returnhtml);
		}

		// This will return html on 3rd argument being true
		if ($returnhtml) {
			return $view_html;
		}
	}
	// Overwrite Auth index function, redirect to front page based on config
  public function index() {
    redirect($this->config->item('auth_front_page', 'backend'));
  }
	//
	// Call Auth index function
	public function users_list() {
		parent::index();
	}
}
