<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once DISCUZ_ROOT . './source/plugin/payment/admin.common.php';
$op = csubase::getMod($_GET['op']);
if ($op && is_file(PLUGIN_ROOT . 'payment/admin/api/' . $op . '.php')) {
    $api_id = csubase::getMod($_GET['api_id']); //标识
    if ($_GET['op'] != 'design') {
        if (!$api_id) {
            cpmsg_error(lang('plugin/payment', 'admin_api_id_lost'));
        }
        $config = C::t('#payment#payment_api')->fetch($api_id);
        if (!$config) {
            cpmsg_error(lang('plugin/payment', 'api_not_register'));
        }
    }
} else {
    $op = 'list';
}
include_once PLUGIN_ROOT . 'payment/admin/api/' . $op . '.php';

?>