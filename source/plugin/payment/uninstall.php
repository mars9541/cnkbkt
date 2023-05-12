<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_payment_method`;
DROP TABLE IF EXISTS `cdb_payment_api`;
DROP TABLE IF EXISTS `cdb_payment_order`;
DROP TABLE IF EXISTS `cdb_payment_log`;
EOF;
runquery($sql);
$finish = true;
?>