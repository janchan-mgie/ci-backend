<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout {
  public $CI;
  //
  public function __construct() {
    $this->CI =& get_instance();
    $this->CI->load->library(array('ion_auth'));
  }
	public function menuItem($menu = NULL, $style = NULL) {
    // Check user auth for item (check BLOCK before ALLOW)
		$block = isset($menu['block']) ? $menu['block'] : array();
		$allow = isset($menu['allow']) ? $menu['allow'] : array();
    if (($this->CI->ion_auth->in_group($block)) || (count($allow) > 0 && !$this->CI->ion_auth->in_group($allow))) {
  		return array(
  			'active' => FALSE,
  			'tag' => ""
  		);
    }
		// HEADER
		$name = isset($menu['name']) ? $menu['name'] : '&nbsp;';
		if (isset($menu['type']) && (strtoupper($menu['type']) === 'HEADER')) {
			return array('active' => FALSE, 'tag' => "<li class='{$style['header_class']}'>{$name}</li>");
		}
		//
		$item_class = '';
    $expand = '';
    $child_menu = '';
		$child_active = FALSE;
    if (isset($menu['children'])) {
			$item_class = $style['parent_class'];
      $expand = $style['expand'];
      $child_menu = "<ul class='{$style['child_class']}'>";
			foreach ($menu['children'] as $key => $submenu) {
				$result = $this->menuItem($submenu, $style);
				$child_menu .= $result['tag'];
				if ($result['active']) {
					$child_active = TRUE;
				}
			}
      $child_menu .= '</ul>';
    }
		//
		$extlink = (strpos($menu['url'], 'http') === 0);
		$url = isset($menu['url']) ? $menu['url'] : '';
		$icon = isset($menu['icon']) && !empty($menu['icon']) ? $menu['icon'] : 'fa';
		$active = (uri_string() === $url);
		$item_class .= ($active || $child_active) ? (' ' . $style['active_class']) : '';
		$url = $extlink ? $url : base_url($url);
		//
		$menu_item = $style['menu_item'];
		$menu_item = str_replace('||URL||', $url, $menu_item);
		$menu_item = str_replace('||TARGET||', $extlink ? '_blank' : '', $menu_item);
		$menu_item = str_replace('||ICON||', $icon, $menu_item);
		$menu_item = str_replace('||NAME||', $name, $menu_item);
		$menu_item = str_replace('||EXPAND||', $expand, $menu_item);
		$menu_item = str_replace('||CHILDMENU||', $child_menu, $menu_item);
		//
		return array(
			'active' => $active,
			'tag' => "<li class='{$item_class}'>{$menu_item}</li>"
		);
	}
}
