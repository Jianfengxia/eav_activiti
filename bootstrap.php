<?php


// 定义 BASE_PATH

define('BASE_PATH', __DIR__);

// Autoload 自动载入

require BASE_PATH.'/vendor/autoload.php';


// whoops 错误提示

$whoops = new \Whoops\Run;

$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

$whoops->register();


