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
        spl_autoload_register(['self', 'autoload'], true, true);
    }

    //自动引入文件
    private static function autoload($className)
    {
        $classMap = self::classMap();

        if (isset($classMap[$className])) {
            $classFile = $classMap[$className] . '.php';
        } elseif (strpos($className, '\\') !== false) {
            // 包含应用（application目录）文件
            $classFile = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!is_file($classFile)) {
                die('类文件不存在');
            }
        } else {
            die('类文件不存在');
        }

        include $classFile;
    }

    //核心文件
    protected static function classMap()
    {
        return [
            'wit\base\Application' => CORE_PATH . 'base/Application',
        ];
    }
}