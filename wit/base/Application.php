<?php
/**
 * WitPHP
 * 应用类
 * Author: sunhuanzhi
 * Date: 2018/6/21 16:27
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