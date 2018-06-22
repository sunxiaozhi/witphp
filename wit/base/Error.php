<?php
/**
 * WitPHP
 * 错误处理类
 * Author: sunhuanzhi
 * Date: 2018/6/21 16:27
 */

namespace wit\base;

class Error
{
    //存放错误配置
    private static $headr = null;

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

        if (self::$headr === null) {
            self::$headr = new \Whoops\Handler\PrettyPageHandler();
        }

        //设置错误标题
        self::$headr->setPageTitle('WitPHP运行出现错误！');
        self::$whoops->pushHandler(self::$headr);
        self::$whoops->register();
    }

}