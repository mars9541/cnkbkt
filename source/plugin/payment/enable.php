<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}

if (!file_exists(DISCUZ_ROOT . './source/plugin/csu_base/sql.class.php')) {
    cpmsg_error(lang('plugin/payment', 'csu_base'), 'action=cloudaddons&id=csu_base.plugin');
}
if (!in_array('csu_base', $_G['setting']['plugins']['available'])) {
    cpmsg_error(lang('plugin/payment', 'available_csu_base'));
}
?>