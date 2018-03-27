<?php
class PostInstall
{
  public function __construct() {
  }
  public function postInstall($source = NULL) {
    $update_list = array();
    // Update for checking _ci_object_to_array existence
    $update_list[] = array(
      'search' => '$this->_ci_object_to_array($vars)',
      'replace' => '(method_exists($this, \'_ci_object_to_array\')) ? $this->_ci_object_to_array($vars) : $this->_ci_prepare_view_vars($vars)',
    );
    updateFile('application/third_party/MX/Loader.php', $update_list);
  }
}
