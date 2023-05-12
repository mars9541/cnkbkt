<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
if (DB::fetch_first('SELECT * FROM information_schema.tables WHERE table_name=%s', [DB::table('payment_api')])) {
    C::t('#payment#payment_api')->delete('pay_credit');
}
$finish = true;
?>