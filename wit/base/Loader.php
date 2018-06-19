<?php
/**
 * Created by PhpStorm.
 *
 * User: sunhuanzhi
 * Date: 2018/6/19
 * Time: 14:32
 */

namespace wit\base;

class Loader
{
    //注册加载
    public static function register()
    {
        spl_autoload_register('wit\\base\\Loader::autoload', true, true);
    }

    //自动引入文件
    private static function autoload($class)
    {
        $classMap = self::classMap();

        if (isset($classMap[$class])) {
            $file = $classMap[$class] . '.php';
        } elseif (strpos($class, '\\') !== false) {
            // 包含应用（application目录）文件
            $file = APP_PATH . str_replace('\\', '/', $class) . '.php';
            if (!is_file($file)) {
                return;
            }
        } else {
            die('类文件不存在');
        }

        require $file;
    }

    //核心文件
    protected static function classMap()
    {
        return [
            'wit\base\Application' => CORE_PATH . 'base/Application',
        ];
    }
}