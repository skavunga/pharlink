<?php

namespace Skavunga\Pharlink;

/**
 * Filename
 */
class Filename
{
	private $fullname = null;
	private $directory = null;
	private $name = null;
	
	public function __construct($filename)
	{
		$name = explode('\\', $filename);

		if (count($name)) {
			$file = $name[count($name) - 1];
			$this->fullname = $filename;
			$this->directory = rtrim(str_replace($file, '', $filename), DIRECTORY_SEPARATOR);
			$this->name = $file;
		}
	}

	public function getFullname()
	{
		return $this->fullname;
	}

	public function getDirectory()
	{
		return $this->directory;
	}

	public function name()
	{
		return $this->name;
	}
}