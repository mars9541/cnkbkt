<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access denid');
}
if (!DB::fetch_first('SELECT * FROM information_schema.tables WHERE table_name=%s', [DB::table('payment_api')])) {
    cpmsg_error($installlang['install_payment'], 'action=cloudaddons&id=payment.plugin');
}
if (!in_array('payment', $_G['setting']['plugins']['available'])) {
    cpmsg_error($installlang['available_payment']);
}
?>