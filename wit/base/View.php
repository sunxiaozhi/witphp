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

    /**
     * View constructor.
     * @throws Exception
     */
    public function __construct()
    {
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

    /**
     * @param string $file
     * @throws Exception
     */
    public function display($file = '')
    {
        if (Config::get('template_cache')) {
            $cache = ROOT_PATH . 'runtime/cache';
        } else {
            $cache = false;
        }

        $loader = new \Twig_Loader_Filesystem(APP_PATH . MODULE_NAME . '/view/' . strtolower(CONTROLLER_NAME) . '/');
        $twig = new \Twig_Environment($loader, array(
            'cache' => $cache,
            'auto_reload' => true,
        ));

        $template_set = Config::get('tmpl_parse_string');

        if (is_array($template_set)) {
            foreach ($template_set as $k => $v) {
                $twig->addGlobal($k, $v);
            }
        }

        $file = $file ? $file : ACTION_NAME;

        $template = $twig->load($file . '.html');

        echo $template->render($this->data);
    }
}