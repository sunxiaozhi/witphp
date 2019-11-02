<?php
/**
 * WitPHP
 * Demo控制器
 * Author: sunxiaozhi
 * Date: 2018/6/21 16:08
 */

namespace app\index\controller;

use wit\base\Controller;

class Demo extends Controller
{
    public function des()
    {
        $this->assign([
            'description' => 'demo'
        ]);

        $this->display();
    }
}