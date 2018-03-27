<?php

function copyFile($filepath, $src_root, $dst_root = NULL) {
	$src_file = $src_root . $filepath;
	$dst_file = $dst_root . $filepath;
	createDir($dst_file);
	if (copy($src_file, $dst_file)) {
		echo 'Copied: ' . realpath($dst_file) . PHP_EOL;
	}
}

function download($url, $dir) {
	$file = file_get_contents($url);
	if ($file === false) {
		throw new RuntimeException("Can't download: " . $url);
	}
  //
	echo 'Downloaded: ' . $url . PHP_EOL;
	$urls = parse_url($url);
	$filepath = $dir . '/' . basename($urls['path']);
	file_put_contents($filepath, $file);
  //
	return $filepath;
}

function unzip($filepath, $dir) {
	$zip = new ZipArchive();
	if ($zip->open($filepath) === TRUE) {
		$tmp = explode('/', $zip->getNameIndex(0));
		$dirname = $tmp[0];
		$zip->extractTo($dir . '/');
		$zip->close();
	} else {
		throw new RuntimeException('Failed to unzip: ' . $filepath);
	}
  //
	return $dirname;
}

/**
 * Recursive Copy
 *
 * @param string $src
 * @param string $dst
 */
function recursiveCopy($src, $dst) {
	if ($src === false) {
		return;
	}
  //
	if (is_array($src)) {
		foreach($src as $key => $source) {
			recursiveCopy($source, $dst[$key]);
		}
		return;
	}
  //
	@mkdir($dst, 0755);
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS) , RecursiveIteratorIterator::SELF_FIRST);
	foreach($iterator as $file) {
		if (!$file->isDir()) {
			copyFile('', $file, $dst . '/' . $iterator->getSubPathName());
		}
	}
}

/**
 * Recursive Unlink
 *
 * @param string $dir
 */
function recursiveUnlink($dir) {
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS) , RecursiveIteratorIterator::CHILD_FIRST);
	foreach($iterator as $file) {
		if ($file->isDir()) {
			rmdir($file);
		} else {
			unlink($file);
		}
	}
	rmdir($dir);
}

/**
 * Create directory(ies) based on given path
 *
 * @param string $path
 */
function createDir($path) {
	$dir = pathinfo($path, PATHINFO_DIRNAME);
	if (is_dir($dir)) {
		return true;
	} else {
		if (createDir($dir)) {
			if (@mkdir($dir)) {
				chmod($dir, 0777);
				return true;
			}
		}
	}
	return false;
}

function moveDir($src, $dst) {
	$dir = new DirectoryIterator($src);
	foreach ($dir as $fileinfo) {
		if ($fileinfo->isDir() && !$fileinfo->isDot()) {
			recursiveCopy($src . '/' . $fileinfo->getFilename(), $dst . '/' . $fileinfo->getFilename());
		}
	}
}
function rrmdir($dir) { 
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (is_dir($dir."/".$object))
					rrmdir($dir."/".$object);
				else
					unlink($dir."/".$object);
			}
		}
		rmdir($dir);
	}
}

function updateFile($file, $update_list) {
	$contents = file_get_contents($file);
	foreach ($update_list as $key => $update) {
		$contents = str_replace($update['search'], $update['replace'], $contents);
	}
	file_put_contents($file, $contents);
}
