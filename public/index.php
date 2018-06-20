<?php

//是否开启debug模式
defined('APP_DEBUG') or define('APP_DEBUG', true);

//应用目录
defined("APP_PATH") or define("APP_PATH", __DIR__ . '/../application');

//引入核心文件
require __DIR__ . '/../wit/Wit.php';

//运行框架
(new \wit\base\Application())->run();
