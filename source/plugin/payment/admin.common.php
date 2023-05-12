<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
//引入基础库
require_once DISCUZ_ROOT . './source/plugin/csu_base/admin.common.php';
C::m('#payment#payment');

$is_debug = false;
if (is_file(DISCUZ_ROOT . './dqzhiyu.dev')) {
    define('DQZHIYU_DEV', true); //开发模式
    $is_debug = true;
}
if (!$notip) {
    showtips('<ul>
        <li>' . lang('plugin/payment', 'tip') . '</li>
        <li>' . lang('plugin/payment', 'install_csu_base') . '<a href="http://www.dqzhiyu.com/article/9.html" target="_blank">http://www.dqzhiyu.com/article/9.html</a></li>
        <li>' . lang('plugin/payment', 'pay_plugin_tips') . '</li>
    </ul>');
}

function showdev($content = '') {
    if (defined('DQZHIYU_DEV')) {
        return $content;
    }
    return '';
}
//php5.5以下兼容
if (!function_exists("array_column")) {
    function array_column($array, $column_name) {
        return array_map(function ($element) use ($column_name) {
            return $element[$column_name];
        }, $array);
    }
}
?>