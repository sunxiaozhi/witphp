<?php

defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)) . '/');

defined('CORE_PATH') or define('CORE_PATH', __DIR__ . '/');

//设置时区
date_default_timezone_set('Asia/Shanghai');

require ROOT_PATH . 'vendor/autoload.php';

//引入加载类
require_once CORE_PATH . 'base/Loader.php';

//自动注册加载
wit\base\Loader::register();