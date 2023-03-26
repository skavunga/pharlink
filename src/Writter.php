<?php

namespace Skavunga\Pharlink;

/**
 * Celui qui ecris dans les fichiers
 */
class Writter
{
	private static $instance = null;
	private static $oldFilePreffix = 'old_';
	private static $outputDir = 'output';

	private static $includeWithReturn = [
		'routes.php',
		'app_local.php',
		'app.php',
		'free_content.php'
	];

	public static function setIncludeWithReturn(array $files): array
	{
		return array_merge(self::$includeWithReturn, $files);
	}

	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new Writter();
		}
		return self::$instance;
	}

	private static function get_head()
	{
		return '<?php
/**
 * Copyright (c) 2023 - Skatek Corporation <skatekcorporation@gmail.com>
 * @author Souvenance Kavunga <skavunga@gmail.com>
 */
';
	}

	public static function putContents($root, Filename $file, $data, $showInfo = true)
	{
		if (in_array($file->name, self::$includeWithReturn)) {
			$content = self::get_head() . "return include 'phar://' . ROOT . '/{$data}';";
		} else {
			$content = self::get_head() . "include 'phar://' . ROOT . '/{$data}';";
		}

		$output = dirname(__DIR__) . DIRECTORY_SEPARATOR . self::$outputDir . str_replace($root, '', $file->path);

		$newFile = new Filename($output, true);

		if($newFile->write($content, 'w', true)) {
			if ($showInfo) {
				Debugger::info("Fichier ecris: " . $newFile->pwd());
			}

			return true;
		}

		return false;
	}
	
}