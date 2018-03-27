<?php
class PostInstall
{
  public function __construct() {
  }
  public function postInstall($install_path = NULL) {
    $source_folder = '_source';
    $vendor_path = '/vendor/codeigniter/framework/';
    //
    recursiveCopy('_install/bin', $source_folder . '/bin');
    //
    // Update index.php
    $update_list = array();
    // Set system_path to CI in vendor folder
    $update_list[] = array(
      'search'  => '$system_path = \'system\';',
      'replace' => '$system_path = \'' . $source_folder . $vendor_path . 'system\';',
    );
    // Set application_folder to application in source folder
    $update_list[] = array(
      'search'  => '$application_folder = \'application\';',
      'replace' => '$application_folder = \'' . $source_folder . '/application\';',
    );
    // Update for CLI with ENVIRONMENT
    $update_list[] = array(
      'search'  => 'define(\'ENVIRONMENT\', isset($_SERVER[\'CI_ENV\']) ? $_SERVER[\'CI_ENV\'] : \'development\');',
      'replace' => file_get_contents($install_path . '/cli_update.txt'),
    );
    updateFile($source_folder . '/index.php', $update_list);
    //
    // Update config.php
    $update_list = array();
    // Set composer_autoload to vendor folder
    $update_list[] = array(
      'search'  => '$config[\'composer_autoload\'] = FALSE;',
      'replace' => '$config[\'composer_autoload\'] = realpath(APPPATH . \'../vendor/autoload.php\');',
    );
    // Set index_page to ''
    $update_list[] = array(
      'search'  => '$config[\'index_page\'] = \'index.php\';',
      'replace' => '$config[\'index_page\'] = \'\';',
    );
    updateFile($source_folder . '/application/config/config.php', $update_list);
    //
    // Move CI system and user_guide folder to vendor folder
    createDir($source_folder . $vendor_path . '.');
    rename($source_folder . '/system', $source_folder . $vendor_path . 'system');
    rename($source_folder . '/user_guide', $source_folder . $vendor_path . 'user_guide');
    //
    // Move index.php to Project root folder
    rename($source_folder . '/index.php', 'index.php');
    // Copy .htaccess for remove index.php in route
    copy('_install/ci.htaccess', '.htaccess');
    // Deny access to source folder
    copy('_install/deny.htaccess', $source_folder . '/.htaccess');
  }
}
