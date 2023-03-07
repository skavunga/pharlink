<?php

namespace Skavunga\Pharlink;

use Cake\Filesystem\Folder;

/**
 * Scanner les dossiers
 */
class Scanner
{
	private static $pharlink = null;
	private static $pattern  = '.php';
	private static $scanFrom = [];
	private static $files    = [];
	private static $instance = null;

	public function __construct($scanFrom = null, $pharlink = null)
	{
		self::setScanFrom($scanFrom);
		self::setPharlink($pharlink);
		self::scan();
	}

	public static function init($from = null, $link = null): Scanner
	{
		if (self::$instance === null) {
			self::$instance = new Scanner($from, $link);
		}
		return self::$instance;
	}

	public static function setPharlink($value)
	{
		return self::$pharlink = $value;
	}

	public static function setScanFrom($value)
	{
		if (is_array($value)) {
			foreach ($value as $val) {
				self::setScanFrom($val);
			}
			return self::$scanFrom;
		}

		$value = new Folder($value);

		if (!empty($value->pwd())) {
			return self::$scanFrom[self::get_hash($value->pwd())] = $value;
		}

		return null;
	}

	private static function get_hash($text): string
	{
		return sha1($text);
	}

	/**
	 * Scanner les fichiers dans les dossiers
	 */
	private static function scan():int
	{
		$files = [];
		foreach (self::$scanFrom as $key => $from) 
			$files = array_merge($files, self::findRecursive($from));

		foreach ($files as $file)
			self::$files[] = new Filename($file);

		return count(self::$files);
	}

	/**
     * Returns an array of all matching files in and below current directory.
     *
     * @param string $pattern Preg_match pattern (Defaults to: .*)
     * @return array Files matching $pattern
     */
    public static function findRecursive(Folder $folder = null): array
    {
        if (!$folder->pwd()) {
            return [];
        }

        $sort = true;
        $startsOn = $folder->path;
        $out = self::_findRecursive($folder, $sort);
        $folder->cd($startsOn);

        return $out;
    }

    /**
     * Private helper function for findRecursive.
     *
     * @param bool $sort Whether results should be sorted.
     * @return array Files matching pattern
     */
    private static function _findRecursive(Folder $folder, bool $sort = false): array
    {
        [$dirs, $files] = $folder->read($sort);
        $found = [];

        foreach ($files as $file) {
            if (self::patternedFile($file)) {
                $found[] = Folder::addPathElement($folder->path, $file);
            }
        }
        $start = $folder->path;

        foreach ($dirs as $dir) {
            $folder->cd(Folder::addPathElement($start, $dir));
            $found = array_merge($found, self::findRecursive($folder, $sort));
        }

        return $found;
    }

    private static function patternedFile($file): bool
    {
    	return preg_match('/' . self::$pattern . '$/i', $file);
    }

	private static function getFoldersPath(): array
	{
		$paths = [];
		foreach (self::$scanFrom as $folder) {
			$paths[] = $folder->pwd();
		}

		return array_unique($paths);
	}

	/**
	 * List des fichiers
	 */
	public static function getFiles(): array
	{
		return self::$files;
	}

	public static function writeAll()
	{
		// code...
	}

}