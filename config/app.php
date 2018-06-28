<?php
/**
 * Created by PhpStorm.
 *
 * User: sunhuanzhi
 * Date: 2018/6/19
 * Time: 11:35
 */

return [
    //默认编码
    'default_charset' => 'UTF-8',
    //默认模块
    'default_module' => 'index',
    //默认控制器
    'default_controller' => 'Index',
    //默认操作
    'default_action' => 'index',
    //url大小写不敏感
    'url_insenstive' => true,
    //url模式 1 2 3
    'url_model' => '1',
    //应用目录的命名空间
    'application_namespace' => 'app',

    'tmpl_parse_string' => [
        '__ROOT__' => ROOT_PATH
    ],

    'template_cache' => true,

    'tag_block_left' => '{%',

    'tag_block_right' => '%}',

    'tag_variable_lfet' => '{{',

    'tag_variable_right' => '}}',
];