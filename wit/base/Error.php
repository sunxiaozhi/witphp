<?php
/**
 * WitPHP
 * 错误处理类
 * Author: sunxiaozhi
 * Date: 2018/6/21 16:27
 */

namespace wit\base;

class Error
{
    //存放错误配置
    private static $handler = null;

    //存放错误对象
    private static $whoops = null;

    /**
     * 抛出错误信息
     * @param $message
     * @param int $lever
     * @throws Exception
     */
    public static function Thrown($message, $lever = E_NOTICE)
    {
        $exception = new Exception($message, $lever, $lever);
        throw $exception;
    }

    /**
     * 注册错误信息捕获
     */
    public static function Register()
    {
        if (self::$whoops === null) {
            self::$whoops = new \Whoops\Run();
        }

        if (self::$handler === null) {
            self::$handler = new \Whoops\Handler\PrettyPageHandler();
        }

        //设置错误标题
        self::$handler->setPageTitle('WitPHP运行出现错误！');
        self::$whoops->pushHandler(self::$handler);
        self::$whoops->register();
    }

}