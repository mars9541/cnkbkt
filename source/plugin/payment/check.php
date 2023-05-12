<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}
if (!version_compare(PHP_VERSION, '5.4.0')) {
    cpmsg_error($installlang['php_version']);
}
if (!file_exists(DISCUZ_ROOT . './source/plugin/csu_base/sql.class.php')) {
    cpmsg_error($installlang['install_csu_base'], 'action=cloudaddons&id=csu_base.plugin');
}
if (!in_array('csu_base', $_G['setting']['plugins']['available'])) {
    cpmsg_error($installlang['available_csu_base']);
}
?>