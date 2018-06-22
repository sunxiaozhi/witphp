<?php
/**
 * WitPHP
 * 路由类
 * Author: sunhuanzhi
 * Date: 2018/6/21 16:08
 */
namespace wit\base;

class Router
{
    /**
     * 路由管理
     * @throws Exception
     * @throws \Exception
     */
    public static function route()
    {
        $urlMod = Config::get('url_model');
        switch ($urlMod) {
            case '1':
                self::general();
                break;
            case '2':
                self::pathInfo();
                break;
            case '3':
                self::rewrite();
                break;
            default:
                self::general();
        }
    }

    /**
     * 普通模式
     * @throws Exception
     * @throws \Exception
     */
    private static function general()
    {
        $m = isset($_GET['m']) ? $_GET['m'] : Config::get('default_module');
        $c = isset($_GET['c']) ? $_GET['c'] : Config::get('default_controller');
        $a = isset($_GET['a']) ? $_GET['a'] : Config::get('default_action');

        //不区分URL大小写
        if (Config::get('url_insenstive')) {
            self::urlDecode($m, $c, $a);
        }

        //定义当前模块控制器方法
        define('MODULE_NAME', $m);
        define('CONTROLLER_NAME', $c);
        define('ACTION_NAME', $a);

        //加载模块和控制器方法
        $class = Config::get('application_namespace') . '\\' . $m . '\\controller\\' . $c;
        if (!file_exists(APP_PATH . $m . '/controller/' . $c . '.php')) {
            Error::Thrown('找不到控制器' . $c);
        }

        $controller = new $class();
        $action = get_class_methods($class);

        if (!in_array($a, $action)) {
            Error::Thrown('找不到方法' . $a);
        }

        $controller->$a();
    }

    /**
     * PATHINFO模式
     * @throws Exception
     * @throws \Exception
     */
    private static function pathInfo()
    {
        $url = @$_SERVER['PATH_INFO'];

        if ($url == null or $url == '/') {
            $m = Config::get('default_module');
            $c = Config::get('default_controller');
            $a = Config::get('default_action');
        } else {
            $pathinfo = explode('/', trim($url, '/'));
            $m = $pathinfo[0];
            $c = $pathinfo[1];
            $suffix = strripos($pathinfo[2], '.');
            $a = !empty($suffix) ? substr($pathinfo[2], 0, $suffix) : $pathinfo[2];
        }

        //解析PATHINFO多余参数
        self::parameter($url);

        //不区分URL大小写
        if (Config::get('URL_INSENSITIVE')) {
            self::urlDecode($m, $c, $a);
        }

        //定义当前模块控制器方法
        define('MODULE_NAME', $m);
        define('CONTROLLER_NAME', $c);
        define('ACTION_NAME', $a);

        //加载模块和控制器方法
        $class = Config::get('application_namespace') . '\\' . $m . '\\controller\\' . $c;

        if (!file_exists(APP_PATH . $m . '/controller/' . $c . '.php')) {
            Error::Thrown('找不到控制器' . $c);
        }

        $controller = new $class();

        $action = get_class_methods($class);

        if (!in_array($a, $action)) {
            Error::Thrown('找不到方法' . $a);
        }

        $controller->$a();
    }

    /**
     * 解析URL多余参数
     * @param $parm
     */
    private static function parameter($parm)
    {
        $parameter = explode('/', trim($parm, '/'));
        $count = count($parameter) + 2;
        $i = 3;
        while ($i < $count) {
            if (isset($parameter[$i + 1])) {
                $suffix = strripos($parameter[$i + 1], '.');
                $option = !empty($suffix) ? substr($parameter[$i + 1], 0, $suffix) : $parameter[$i + 1];
                $_GET[$parameter[$i]] = $option;
            }
            $i = $i + 2;
        }
    }

    /**
     * URL伪静态模式
     * @throws Exception
     * @throws \Exception
     */
    private static function rewrite()
    {
        $url = $_SERVER['REQUEST_URI'];
        $replace = $_SERVER['SCRIPT_NAME'];

        if ($url = str_replace($replace, '', $url)) {
            $url = str_replace(ROOT_PATH . '/', '', $url);
        }

        if ($url == null or $url == '/') {
            $m = Config::get('default_module', 'Home');
            $c = Config::get('default_controller', 'Index');
            $a = Config::get('default_action', 'index');
        } else {
            $reweite = explode('/', trim($url, '/'));
            $m = $reweite[0];
            $c = $reweite[1];
            $suffix = strripos($reweite[2], '.');
            $a = !empty($suffix) ? substr($reweite[2], 0, $suffix) : $reweite[2];
        }

        //解析参数
        self::parameter($url);

        //不区分URL大小写
        if (Config::get('URL_INSENSITIVE')) {
            self::urlDecode($m, $c, $a);
        }

        //定义当前模块控制器方法
        define('MODULE_NAME', $m);
        define('CONTROLLER_NAME', $c);
        define('ACTION_NAME', $a);

        //加载模块和控制器方法
        $class = '\\' . $m . '\\controller\\' . $c . 'controller';
        if (!file_exists(APP_PATH . $m . '/controller/' . $c . 'controller.class.php')) {
            Error::Thrown('找不到控制器' . $c);
        }

        $controller = new $class();

        $action = get_class_methods($class);

        if (!in_array($a, $action)) {
            Error::Thrown('找不到方法' . $a);
        }

        $controller->$a();
    }

    /**
     * linux下URL大小写转换
     * @param $m
     * @param $c
     * @param $a
     * @throws \Exception
     */
    private static function urlDecode(&$m, &$c, &$a)
    {
        if (!IS_WIN) {
            $filenames = scandir(APP_PATH . $m . '/controller/');
            $count = strlen($c);
            foreach ($filenames as $filename) {
                $file = substr($filename, 0, $count);
                if (strtolower($file) == strtolower($c)) {
                    $c = $file;
                    break;
                }
            }
            $class = '\\' . $m . '\\controller\\' . $c . 'controller';
            if (!file_exists(APP_PATH . $m . '/controller/' . $c . 'controller.class.php')) {
                Error::Thrown('找不到控制器' . $c);
            }
            $actions = get_class_methods(new $class());
            foreach ($actions as $action) {
                if (strtolower($a) == strtolower($action)) {
                    $a = $action;
                    break;
                }
            }
        }
    }
}