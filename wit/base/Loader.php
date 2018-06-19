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
    public static function register() {
        //spl_autoload_register('wit\\base\\Loader::autoload', true, true);
        spl_autoload_register(['wit\\base\\Loader', 'autoload'], true, true);
    }

    private function autoload($class) {
        $classMap = $this->classMap();

        include CORE_PATH . $class;
    }

    protected function classMap() {
        return [
          '\wit\base\Application' => CORE_PATH . 'wit/base/Application',
        ];
    }
}