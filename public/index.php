<?php


define('ROOT_PATH',  realpath(dirname(dirname(__FILE__))));
define('APPLICATION_PATH', dirname(dirname(__FILE__)));
//echo APPLICATION_PATH;
$application = new Yaf\Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
