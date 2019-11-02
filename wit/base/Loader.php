<?php
/**
 * WitPHP
 * 自动加载类
 * Author: sunxiaozhi
 * Date: 2018/6/21 16:27
 */

namespace wit\base;

class Loader
{
    /**
     * 命名空间映射
     * @var array
     */
    private static $nameSpaceMap = [
        'app' => APP_PATH,
    ];

    /**
     * 注册加载
     */
    public static function register()
    {
        spl_autoload_register(['self', 'autoload'], true, true);
    }

    /**
     * 自动引入文件
     * @param $className
     */
    private static function autoload($className)
    {
        $classMap = self::classMap();

        if (isset($classMap[$className])) {
            $classFile = $classMap[$className] . '.php';
        } else {
            $classFile = self::findFile($className);

            if (!file_exists($classFile)) {
                return;
            }
        }

        self::includeFile($classFile);
    }

    /**
     * 查找文件
     * @param $className
     * @return string
     */
    private static function findFile($className)
    {
        $vendor = substr($className, 0, strpos($className, '\\')); // 顶级命名空间
        $vendorDir = isset(self::$nameSpaceMap[$vendor]) ? self::$nameSpaceMap[$vendor] : ROOT_PATH . $vendor; // 文件基目录
        $filePath = substr($className, strlen($vendor)) . '.php'; // 文件相对路径
        return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR); // 文件标准路径
    }

    /**
     * 引入文件
     * @param $classFile
     */
    private static function includeFile($classFile)
    {
        if (is_file($classFile)) {
            include $classFile;
        }
    }

    /**
     * 核心文件
     * @return array
     */
    private static function classMap()
    {
        return [
            'wit\base\Application' => CORE_PATH . 'base/Application',
        ];
    }
}