<?php

namespace wit;

use wit\base\Loader;

defined('CORE_PATH') or define('CORE_PATH', __DIR__ . '/');

require_once CORE_PATH . 'base/Loader.php';

//自动注册加载
Loader::register();