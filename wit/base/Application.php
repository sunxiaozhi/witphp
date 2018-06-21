<?php
/**
 * Created by PhpStorm.
 * 应用类
 * User: sunhuanzhi
 * Date: 2018/6/19
 * Time: 16:24
 */

namespace wit\base;

class Application
{
    public function init() {

    }

    public function run()
    {
        Router::route();
    }

}