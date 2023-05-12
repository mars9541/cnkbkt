<?php
if (!defined('IN_DISCUZ')) {
    exit('Access denid');
}

class plugin_csu_base {
    public function common() {
        if (!function_exists('sql')) {
            require_once DISCUZ_ROOT . './source/plugin/csu_base/sql.class.php';
        }
    }
}
class mobileplugin_csu_base {
    public function common() {
        if (!function_exists('sql')) {
            require_once DISCUZ_ROOT . './source/plugin/csu_base/sql.class.php';
        }
    }
}
?>