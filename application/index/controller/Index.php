<?php
/**
 * WitPHP
 * Index控制器
 * Author: sunxiaozhi
 * Date: 2018/6/21 16:27
 */

namespace app\index\controller;

use wit\base\Controller;

class Index extends Controller
{
    public function __init()
    {
        P('init_action');
    }

    public function index()
    {
        $this->assign([
            'name' => 'index',
            'version' => '4',
        ]);

        $this->display('index');
    }

}