<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

define('ROOT', dirname(__FILE__) . '/');
define('CORE', dirname(__FILE__) . '/core/'); //каталог ядра
define('APP', dirname(__FILE__) . '/application/'); //каталог фронтальной части

define('UPLOAD', dirname('../main.php') . '/uploads/');
//define('CP', dirname(__FILE__) . '/cp/'); //каталог панели управления

require_once CORE . 'autoload.php';
require_once CORE . 'functions.php';

App::gi()->start();
