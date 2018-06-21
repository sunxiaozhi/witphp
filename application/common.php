<?php

// 公共助手函数

if (!function_exists('P')) {
    /**
     * 打印函数
     * @param $value
     */
    function P($value)
    {
        if (is_bool($value)) {
            var_dump($value);
        } else if (is_null($value)) {
            var_dump(NULL);
        } else {
            echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>" . print_r($value, true) . "</pre>";
        }
    }
}