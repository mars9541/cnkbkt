<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once DISCUZ_ROOT . './source/plugin/payment/admin.common.php';
$op = csubase::getMod($_GET['op']);
if (!$op || !is_file(PLUGIN_ROOT . 'payment/admin/method/' . $op . '.php')) {
    $op = 'list';
}
include_once PLUGIN_ROOT . 'payment/admin/method/' . $op . '.php';

function getsettings($file) {
    $getsettings = csubase::json_file($file);
    if ($getsettings['displayorder']) {
        //兼容旧版本，在1.1版本中彻底废除
        $settings = [];
        foreach ($getsettings['displayorder'] as $key => $value) {
            $settings[] = [
                'title'   => $getsettings['title'][$key],
                'key'     => $getsettings['key'][$key],
                'type'    => $getsettings['type'][$key],
                'comment' => $getsettings['comment'][$key],
                'default' => $getsettings['default'][$key],
            ];
        }
        return $settings;
    }
    return $getsettings;
}

?>