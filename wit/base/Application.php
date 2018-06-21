<?php
/**
 * Created by PhpStorm.
 *
 * User: sunhuanzhi
 * Date: 2018/6/19
 * Time: 16:24
 */

namespace wit\base;

class Application
{
    public function init() {

    }

    /**
     * @throws Exception
     */
    public function run()
    {
        //new Router();
        $config = Config::get('hostname', 'database');
        var_dump($config);
    }

}