<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}
if (submitcheck('op', 1)) {
    $method_id = csubase::getMod($_GET['method_id']); //标识
    C::t('#payment#payment_method')->update($method_id, ['available' => 0]);
    cpsuccess(lang('plugin/payment', 'unavailable_success'));
}
?>