<?php
/**
 * WitPHP
 * 控制器基类
 * Author: sunhuanzhi
 * Date: 2018/6/21 16:26
 */

namespace wit\base;


class Controller
{
    /**
     * 视图类实例
     * @var \wit\base\View
     */
    protected $view;

    public function __construct()
    {
        $this->__init();

        $this->view = new View();
    }

    //初始化
    public function __init()
    {
    }

    /**
     * @return $this
     */
    protected function assign($name, $value = '')
    {
        $this->view->assign($name, $value);

        return $this;
    }

    /**
     * @return $this
     */
    protected function display()
    {
        $this->view->display();

        return $this;
    }

}