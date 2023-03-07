<?php

require 'vendor/autoload.php';

use Skavunga\Pharlink\{
	Scanner,
	Debugger
};

$paths = [
	"E:\SKATEK\laragon\www\hopital2\src\Controller",
	"E:\SKATEK\laragon\www\hopital2\src\Controller",
	"E:\SKATEK\laragon\www\hopital2\src\Model",
	"E:\SKATEK\laragon\www\hopital2\src\Model",
	"E:\SKATEK\laragon\www\hopital2\\templates"
];

$pharlink = "clinique_soft.phar";

$scanner = Scanner::init($paths, $pharlink);


Debugger::show($scanner::getFiles());