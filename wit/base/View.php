<?php
/**
 * WitPHP
 * 视图基类
 * Author: sunhuanzhi
 * Date: 2018/6/21 16:27
 */

namespace wit\base;


class View
{
    protected $data = [];

    protected static $config = null;

    protected static $twigEngine = null;

    protected static $twigConf = null;

    /**
     * View constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->twigInit();
    }

    /**
     * @throws Exception
     */
    public function twigInit()
    {
        if (self::$config === null) {
            if (Config::get('template_cache')) {
                $cache = ROOT_PATH . 'Runtime/Cache';
            } else {
                $cache = false;
            }

            self::$config = [
                'cache' => $cache,
                'cache_dir' => ROOT_PATH . 'Runtime/Cache/' . MODULE_NAME . '/' . CONTROLLER_NAME,
                'debug' => APP_DEBUG
            ];
        }

        $template_set = Config::get('tmpl_parse_string');

        if (self::$twigEngine === null) {

            self::$twigConf = self::$twigConf === null ? new \Twig_Loader_Filesystem() : self::$twigConf;

            self::$twigEngine = new \Twig_Environment(self::$twigConf, array(
                'cache' => self::$config['cache'],
                'debug' => self::$config['debug'],
                'charset' => Config::get('default_charset'),
                'auto_reload' => true,
                'cache_dir' => self::$config['cache_dir'],
            ));

            self::$twigEngine->addGlobal('__ROOT__', ROOT_PATH);

            if (is_array($template_set)) {
                foreach ($template_set as $k => $v) {
                    self::$twigEngine->addGlobal($k, $v);
                }
            }
        }

        /*$loader = new \Twig_Loader_Array(array(
            'index' => 'Hello {{ name }}!',
        ));
        $twigEngine = new \Twig_Environment($loader);

        echo $twigEngine->render('index', array('name' => 'Fabien'));*/
    }

    public function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->data = array_merge($this->data, $name);
        } else {
            $this->data[$name] = $value;
        }

        return $this;
    }

    public function display($path = '', $file = '')
    {
        //P(self::$twigEngine->getGlobals());exit;

        $path = $path == '' ? APP_PATH . MODULE_NAME . '/Views/' . CONTROLLER_NAME : $path;
        $file = $file == '' ? ACTION_NAME . '.html' : $file;

        self::$twigEngine->setPaths($path);
        self::$twigEngine->display($file, $this->data);
    }
}