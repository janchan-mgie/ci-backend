#!/usr/bin/env php
<?php
if ($argc === 2) {
	require_once 'utilities.php';
	recursiveCopy($argv[1], './');
	if (file_exists('public')) {
		// Copy folders in public to Project root folder
		recursiveCopy('public', '..');
		// Remove public folder in source folder
		recursiveUnlink('public');
	}
} else {
	echo 'wrong';
}
