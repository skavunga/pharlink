<?php

namespace Skavunga\Pharlink;

/**
 * Celui qui ecris dans les fichiers
 */
class Writter
{
	private static $instance = null;

	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new Writter();
		}
		return self::$instance;
	}

	public static function write()
	{
		$str = `
		<?php
		/**
		 * Copyright (c) Skatek Corporation <skatekcorporation@gmail.com>
		 *
		 */

		include 'phar://' . ROOT . '/clinique_soft.phar/src/Controller/AppController.php';
		`;
	}
	
}