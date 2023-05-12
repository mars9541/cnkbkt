<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}
$method_id = csubase::getMod($_GET['method_id']); //标识
$config    = csubase::json_file(PAYMENT_METHOD_ROOT . $method_id . '/config.json');
$url       = csubase::getMod($_GET['page']);
$urls      = array_column($config['urls'], 'url');
if (!in_array($url, $urls)) {
    cpmsg_error(lang('plugin/payment', 'urlpage_not_exist'));
}
include_once PAYMENT_METHOD_ROOT . $method_id . '/' . $url . '.php';
?>