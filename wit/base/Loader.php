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
    private static $nameSpaceMap = [
        'app' => 'application'
    ];

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
        } else {
            $classFile = self::findFile($className);
        }

        self::includeFile($classFile);
    }

    private static function findFile($className)
    {
        $classFile = '';

        return $classFile;
    }

    private static function includeFile($classFile)
    {
        if (is_file($classFile)) {
            include $classFile;
        }
    }

    //核心文件
    private static function classMap()
    {
        return [
            'wit\base\Application' => CORE_PATH . 'base/Application',
        ];
    }
}