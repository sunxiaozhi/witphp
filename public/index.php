<?php

//是否开启debug模式
defined('APP_DEBUG') or define('APP_DEBUG', true);

//设置初始目录
defined("APP_PATH") or define("APP_PATH", dirname(dirname(__FILE__)) . '/');

//引入核心文件
require APP_PATH . 'wit/Wit.php';

//运行框架
(new \wit\base\Application())->run();
