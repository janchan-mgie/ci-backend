#!/usr/bin/env php
<?php
require_once 'installer.php';
$installer = new Installer();

if ($argc >= 2) {
	$package = $argv[1];
	$version = ($argc > 2) ? $argv[2] : NULL;
	echo $installer->install($package, $version);
} else {
	echo $installer->usage($argv[0]);
}
