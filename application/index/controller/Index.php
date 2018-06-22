<?php
/**
 * Created by PhpStorm.
 *
 * User: sunhuanzhi
 * Date: 2018/6/19
 * Time: 20:47
 */

namespace app\index\controller;

use wit\base\Controller;

class Index extends Controller
{
    public function __init()
    {
        //P('init');
    }

    public function index()
    {
        //P('index');
        $this->assign([
            'name' => 'index',
            'version' => '1',
        ]);

        $this->display();
    }

}