<?php
class Installer
{
	protected $project_dir = '../../';
	protected $source_dir = '../';
	protected $tmp_dir = 'tmp';
	protected $app_dir = 'application';
	protected $composer_command = 'composer';
	protected $packages = array();
  //
	public function __construct() {
		require_once 'packages.php';
		require_once 'utilities.php';
    //
    $this->packages = $packages;
    //
		$this->project_dir = __DIR__ . '/' . $this->project_dir;
		$this->source_dir = __DIR__ . '/' . $this->source_dir;
		$this->tmp_dir = __DIR__ . '/' . $this->tmp_dir;
		$this->app_dir = $this->source_dir . $this->app_dir;
    //
		@mkdir($this->tmp_dir);
	}
  //
	public function usage($self) {
		$msg = 'You can install:' . PHP_EOL;
		foreach($this->packages as $key => $value) {
			$msg .= '  ' . $value['name'] . ' (' . $key . ')' . PHP_EOL;
		}
    //
		$msg.= PHP_EOL;
		$msg .= 'Usage:' . PHP_EOL;
		$msg .= '  php install.php <package> <version/branch>' . PHP_EOL;
		$msg .= PHP_EOL;
		$msg .= 'Examples:' . PHP_EOL;
		foreach($this->packages as $key => $value) {
			$msg .= "  php $self $key " . $value['branch'] . PHP_EOL;
		}
    //
		return $msg;
	}
  //
	public function install($package, $version = NULL) {
		if (!isset($this->packages[$package])) {
			return 'Error! no such package: ' . $package . PHP_EOL;
		}
		//
		$info = $this->getPackageInfo($package);
		switch ($info['type']) {
  		case 'github':
  			$method = 'downloadFromGithub';
  			break;
  		case 'bitbucket':
  			$method = 'downloadFromBitbucket';
  			break;
  		case 'composer':
  			$method = 'requireFromComposer';
  			break;
  		case 'composer-create':
  			$method = 'createFromComposer';
  			break;
  		default:
  			throw new LogicException('Error! no such repos type: ' . $info['type']);
  			break;
		}
    //
		$version = (empty($version)) ? $info['branch'] : $version;
		$src = $this->$method($info, $version) . $info['src_pre'];
		$this->copyToApp($src, $info['dst_pre'], $info['dir'], $info['file']);
		recursiveUnlink($this->tmp_dir);
		//
		$postinstall_file = 'postinstall/' . $package . '.php';
		if (file_exists(__DIR__ . '/' . $postinstall_file)) {
			require_once $postinstall_file;
			$postInstall = new PostInstall();
			$postInstall->postInstall($this->source_dir);
		}
		//
		if (file_exists($this->source_dir . 'public')) {
			// Move folders in public to Project root folder
			moveDir('public', '..');
			// Remove public folder in source folder
			rrmdir('public');
		}
		//
		$msg = 'Installed: ' . $package . PHP_EOL;
		if (isset($info['msg'])) {
			$msg .= $info['msg'] . PHP_EOL;
		}
		//
		return $msg;
	}
  //
	private function downloadFromGithub($info, $version) {
		$repos = $info['repos'];
		//
		$url = "https://github.com/{$info['user']}/{$repos}/archive/$version.zip";
		$filepath = download($url, $this->tmp_dir);
		unzip($filepath, $this->tmp_dir);
		//
		return dirname($filepath) . "/$repos-$version/";
	}
	private function downloadFromBitbucket($info, $version) {
		$url = "https://bitbucket.org/{$info['user']}/{$info['repos']}/get/$version.zip";
		$filepath = download($url, $this->tmp_dir);
		$dirname = unzip($filepath, $this->tmp_dir);
		//
		return dirname($filepath) . "/$dirname/";
	}
  private function createFromComposer($info, $version = NULL) {
    $source_folder = '_source';
		$this->runComposer('create-project', $info['user'], $info['repos'], $version, array($source_folder));
		return $this->project_dir . $source_folder . '/';
	}
	private function requireFromComposer($info, $version = NULL) {
		$this->runComposer('require', $info['user'], $info['repos'], $version);
		return $this->source_dir . "vendor/{$info['user']}/{$info['repos']}/";
	}
	private function runComposer($type = 'require', $user, $repos, $version = NULL, $params = array()) {
		$version = (!empty($version)) ? ":$version" : '';
		exec("$this->composer_command $type $user/$repos$version " . implode(' ', $params));
	}
  //
	private function getPackageInfo($package) {
		$result = $this->packages[$package];
		$result['dir'] = isset($result['dir']) ? $result['dir'] : NULL;
		$result['file'] = isset($result['file']) ? $result['file'] : NULL;
		$result['src_pre'] = isset($result['src_pre']) ? ($result['src_pre'] . '/') : '';
		$result['dst_pre'] = (isset($result['dst_pre']) ? $result['dst_pre'] : $this->app_dir) . '/';
		return $result;
	}
  //
	private function copyToApp($src, $dst, $dir = NULL, $file = NULL) {
		$this->copyDir($dir, $src, $dst);
		$this->copyFiles($file, $src, $dst);
	}
	private function copyDir($dir = NULL, $src_root, $dst_root = NULL) {
		if (empty($dir)) {
			return;
		}
		//
		if (is_string($dir)) {
			if ($dir === '*') {
				$dir_list[] = '';
			}	else {
				$dir_list[] = $dir;
			}
		}	else {
			$dir_list = $dir;
		}
    //
		if (count($dir_list) > 0) {
			foreach($dir_list as $directory) {
				$src[] = realpath($src_root . $directory);
				createDir($dst_root . $directory . '/.');
				$dst[] = realpath($dst_root . $directory);
			}
			recursiveCopy($src, $dst);
		}
	}
	private	function copyFiles($file = NULL, $src_root, $dst_root = NULL) {
		if (empty($file)) {
			return;
		}
    //
		if (is_string($file)) {
			$file_list[] = $file;
		}	else {
			$file_list = $file;
		}
    //
		if (count($file_list) > 0) {
			foreach($file_list as $filepath) {
				copyFile($filepath, $src_root, $dst_root);
			}
		}
	}
}
