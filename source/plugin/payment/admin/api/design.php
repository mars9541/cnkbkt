<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$api_id = csubase::getMod($_GET['api_id']); //标识
if ($api_id) {
    $config = C::t('#payment#payment_api')->fetch($api_id);
    if (!$config) {
        cpmsg_error(lang('plugin/payment', 'api_not_register'));
    }
} else {
    $config = ['filename' => 'source/plugin/'];
}
if (submitcheck('submit')) {
    $config = [
        'api_id'      => daddslashes($_GET['id']),
        'filename'    => daddslashes($_GET['filename']),
        'identifier'  => daddslashes($_GET['plugin_identifier']),
        'description' => daddslashes($_GET['description']),
    ];

    if ($api_id) {
        C::t('#payment#payment_api')->update($api_id, $config);
    } else {
        C::t('#payment#payment_api')->insert($config);
    }
    cpsuccess(lang('plugin/payment', 'save'), ['op' => 'design', 'api_id' => $config['api_id']]);
}
showformheader(FORM_URL . 'op=design' . ($_GET['api_id'] ? '&api_id=' . $_GET['api_id'] : ''));
showtableheader(lang('plugin/payment', 'api_design'));
showsetting(lang('plugin/payment', 'identifier'), 'plugin_identifier', $config['identifier'], 'text');
showsetting(lang('plugin/payment', 'api_id'), 'id', $config['api_id'], 'text');
showsetting(lang('plugin/payment', 'classfile'), 'filename', $config['filename'], 'text');
showsetting(lang('plugin/payment', 'description'), 'description', $config['description'], 'textarea');
showsubmit('submit');
showtablefooter();
showformfooter();
?>