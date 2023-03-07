<?php

namespace Skavunga\Pharlink;

/**
 * Debugger
 */
class Debugger
{	
	public static function show($var, $showHtml = false, $showFrom = true)
	{
		if ($showFrom) {
            $calledFrom = debug_backtrace();
            echo '<strong>' . substr(str_replace(dirname(__DIR__), '', $calledFrom[0]['file']), 1) . '</strong>';
            echo ' (line <strong>' . $calledFrom[0]['line'] . '</strong>)';
        }
        echo "\n<pre" . ($showHtml ? ' style="color: #000; background: #FFF; font: 9pt \'Courier New\', Courier, monospace; padding: 10px;"' : '') . '>';
        print_r($var);
        echo '</pre>';
	}
}