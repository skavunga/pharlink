<?php

namespace Skavunga\Pharlink;

/**
 * Celui qui ecris dans les fichiers
 */
class Writter
{
	private static $instance = null;
	private static $oldFilePreffix = 'old_';

	private static $includeWithReturn = [
		'routes.php',
		'app_local.php',
		'app.php',
		'free_content.php'
	];

	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new Writter();
		}
		return self::$instance;
	}

	private static function get_head()
	{
		return "
		<?php
		/**
		 * Copyright (c) 2023 - Skatek Corporation <skatekcorporation@gmail.com>
		 * @author Souvenance Kavunga <skavunga@gmail.com>
		 */

		";
	}

	public static function putContents(Filename $file, $data, $showInfo = true)
	{
		if (in_array($file->name, self::$includeWithReturn)) {
			$content = self::get_head() . "return include 'phar://{$data}';";
		} else {
			$content = self::get_head() . "include 'phar://{$data}';";
		}

		$newName = $file->Folder->pwd() . DIRECTORY_SEPARATOR . self::$oldFilePreffix . $file->name;

		if ($file->copy($newName)) {
			if ($showInfo) {
				Debugger::info($file->pwd() . " copié vers " . $newName);
			}
		}

		if($file->write($content, 'w', true)) {
			if ($showInfo) {
				Debugger::info("Fichier ecris: " . $file->pwd());
			}

			return true;
		}

		return false;
	}

	public static function restoreContent(Filename $file, $showInfo = true)
	{
		$oldFile = new Filename($file->Folder->pwd() . DIRECTORY_SEPARATOR . self::$oldFilePreffix . $file->name);

		if ($oldFile->copy($file->pwd())) {
			if ($showInfo) {
				Debugger::info($oldFile->pwd() . " copié vers " . $file->pwd());
			}

			return $oldFile->delete();
		}

		return false;
	}
	
}