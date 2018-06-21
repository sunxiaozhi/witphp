<?php
/**
 * WitPHP
 * 配置类
 * Author: sunhuanzhi
 * Date: 2018/6/21 16:27
 */

namespace wit\base;


class Config
{
    private static $config;

    /**
     * @param $name
     * @param string $file
     * @return bool
     * @throws Exception
     */
    public static function get($name, $file = '')
    {
        $config_path = ROOT_PATH . 'config/';
        $file = !empty($file) ? $config_path . $file . '.php' : $config_path . 'app.php';

        if (isset(self::$config[md5($file)][$name])) {
            return self::$config[md5($file)][$name];
        }

        if (file_exists($file)) {
            $conf = require $file;
            if (!empty($conf[$name])) {
                self::$config[md5($file)][$name] = $conf[$name];
                return $conf[$name];
            }
        } else {
            Error::Thrown('找不到配置文件');
        }

        return '';
    }

    /**
     * @param $name
     * @param $value
     * @param string $file
     * @return bool
     */
    public static function set($name, $value, $file = '')
    {
        $config_path = ROOT_PATH . 'config/';
        $file = !empty($file) ? $config_path . $file . '.php' : $config_path . 'app.php';

        if (is_array($value)) {
            foreach ($value as $k => $v) {
                self::$config[md5($file)][$name][$k] = $v;
            }
        } else {
            self::$config[md5($file)][$name] = $value;
        }
        return true;
    }
}