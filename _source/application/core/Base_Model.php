<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/MY_Model_.php';
class Base_Model extends MY_Model {
  protected $return_as = 'array';
  protected $soft_deletes = TRUE;
  //
  public function __construct() {
    $this->before_delete[] = '_before_delete';
    $this->before_soft_delete[] = '_before_delete';
    $this->pagination_delimiters = (isset($this->pagination_delimiters)) ? $this->pagination_delimiters : array('span');
    //
    parent::__construct();
  }
  // Added functions
	protected function has_delete_right($data) {
		return TRUE;
	}
	protected function _before_delete($data) {
		if (!$this->has_delete_right($data)) {
			show_error('No right to delete');
		}
  	return $data;
	}
  private function get_pagination_tag($url = '', $text = '', $class = '') {
    $anchor = (trim($url) === '') ? ('<a>'.$text.'</a>') : anchor($url, $text);
    $tag = $this->pagination_delimiters[0];
    $pre_class = isset($this->pagination_delimiters[1]) ? ($this->pagination_delimiters[1] . ' ') : '';
    $pre_data = isset($this->pagination_delimiters[2]) ? (' ' . $this->pagination_delimiters[2]) : '';
    $all_class = trim($pre_class . $class);
    $class_attr = ($all_class === '') ? '' : ' class="' . $all_class . '"';
    return '<' . $tag . $pre_data . $class_attr . '>' . $anchor . '</' . $tag . '>';
  }
  // Modified functions
  public function paginate($rows_per_page, $total_rows = NULL, $page_number = 1)
  {
      $this->load->helper('url');
      $segments = $this->uri->total_segments();
      $uri_array = $this->uri->segment_array();
      $page = $this->uri->segment($segments);
      if(is_numeric($page))
      {
          $page_number = $page;
      }
      else
      {
          $page_number = $page_number;
          $uri_array[] = $page_number;
          ++$segments;
      }
      $next_page = $page_number+1;
      $previous_page = $page_number-1;

      $ary_class = isset($this->pagination_delimiters[3]) ? $this->pagination_delimiters[3] : array();
      $class_active = (isset($ary_class['active'])) ? $ary_class['active'] : '';
      $class_disabled = (isset($ary_class['disabled'])) ? $ary_class['disabled'] : '';

      if($page_number == 1)
      {
          $uri_string = '';
          $class = $class_disabled;
      }
      else
      {
          $uri_array[$segments] = $previous_page;
          $uri_string = implode('/',$uri_array);
          $class = '';
      }
      $this->previous_page = $this->get_pagination_tag($uri_string, $this->pagination_arrows[0], $class);

      if(isset($total_rows) && (ceil($total_rows/$rows_per_page) == $page_number))
      {
          $uri_string = '';
          $class = $class_disabled;
      }
      else
      {
          $uri_array[$segments] = $next_page;
          $uri_string = implode('/',$uri_array);
          $class = '';
      }
      $this->next_page = $this->get_pagination_tag($uri_string, $this->pagination_arrows[1], $class);

      $rows_per_page = (is_numeric($rows_per_page)) ? $rows_per_page : 10;

      if(isset($total_rows))
      {
          if($total_rows!=0)
          {
              $number_of_pages = ceil($total_rows / $rows_per_page);
              $links = $this->previous_page;
              unset($uri_array[$segments]);
              $uri_string = implode('/', $uri_array);
              for ($i = 1; $i <= $number_of_pages; $i++) {
                  if ($page_number == $i) {
                    $url = '';
                    $class = $class_active;
                  } else {
                    $url = $uri_string . '/' . $i;
                    $class = '';
                  }
                  $links .= $this->get_pagination_tag($url, $i, $class);
              }
              $links .= $this->next_page;
              $this->all_pages = $links;
          }
          else
          {
              $this->all_pages = $this->get_pagination_tag();
          }
      }

      if(isset($this->_cache) && !empty($this->_cache))
      {
          $this->load->driver('cache');
          $cache_name = $this->_cache['cache_name'].'_'.$page_number;
          $seconds = $this->_cache['seconds'];
          $data = $this->cache->{$this->cache_driver}->get($cache_name);
      }

      if(isset($data) && $data !== FALSE)
      {
          return $data;
      }
      else
      {
          $this->trigger('before_get');
          $this->where();
          $this->limit($rows_per_page, (($page_number-1)*$rows_per_page));
          $data = $this->get_all();
          if($data)
          {
              if(isset($cache_name) && isset($seconds))
              {
                  $this->cache->{$this->cache_driver}->save($cache_name, $data, $seconds);
                  $this->_reset_cache($cache_name);
              }
              return $data;
          }
          else
          {
              return FALSE;
          }
      }
  }
}
