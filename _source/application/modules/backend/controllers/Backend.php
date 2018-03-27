<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../libraries/Backend_Controller.php';
class Backend extends Backend_Controller {
  public function index() {
    $this->template->setValue('content', 'Backend Index');
    $this->template->render();
  }
  public function home() {
    $data = array('temp' => 'Backend HOME');
    $this->template->setContent('welcome_message', $data);
    $this->template->render();
  }
}
