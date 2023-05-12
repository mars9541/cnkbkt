<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$sql = <<<EOF
CREATE TABLE `cdb_payment_api` (
    `api_id` varchar(40) NOT NULL,
    `identifier` varchar(40) DEFAULT NULL,
    `filename` varchar(64) NOT NULL,
    `description` text,
    `method_list` char(255) NOT NULL,
    `method_rule` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`api_id`) USING BTREE
) ENGINE=InnoDB;
CREATE TABLE `cdb_payment_log` (
    `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `order_id` char(20) NOT NULL,
    `create_time` int(11) NOT NULL,
    `create_ip` char(40) NOT NULL,
    `type` tinyint(1) NOT NULL,
    `type_id` varchar(40) DEFAULT NULL,
    `type_method` varchar(128) DEFAULT NULL,
    `status` tinyint(1) NOT NULL,
    `params` text,
    `result` text,
    `comment` text,
    PRIMARY KEY (`log_id`)
) ENGINE=InnoDB;
CREATE TABLE `cdb_payment_method` (
    `method_id` varchar(40) NOT NULL,
    `title` varchar(32) DEFAULT NULL,
    `setting` text,
    `available` tinyint(1) NOT NULL DEFAULT '0',
    `displayorder` mediumint(4) DEFAULT NULL,
    `user_agent` varchar(128) DEFAULT NULL,
    PRIMARY KEY (`method_id`) USING BTREE
) ENGINE=InnoDB;
CREATE TABLE `cdb_payment_order` (
    `order_id` char(20) NOT NULL COMMENT 'YYYYmmddhhiissXXXXXXX',
    `subject` varchar(128) NOT NULL,
    `body` text,
    `url` varchar(128) DEFAULT NULL,
    `return_url` varchar(128) DEFAULT NULL,
    `uid` int(11) NOT NULL,
    `amount` int(11) NOT NULL,
    `is_refund` tinyint(1) NOT NULL DEFAULT '0',
    `api_id` varchar(40) NOT NULL,
    `params` text,
    `status` tinyint(1) unsigned NOT NULL,
    `plugin_status` tinyint(1) NOT NULL DEFAULT '0',
    `create_time` int(11) NOT NULL,
    `create_ip` varchar(40) DEFAULT NULL,
    `method_id` varchar(40) DEFAULT NULL,
    `finish_time` int(11) DEFAULT NULL,
    `finish_user` varchar(128) DEFAULT NULL,
    `finish_id` varchar(64) DEFAULT NULL,
    `expire_time` int(11) NOT NULL,
    `cancel_time` int(11) DEFAULT NULL,
    `method_extends` text,
    `method_rule` tinyint(1) NOT NULL DEFAULT '0',
    `method_list` char(255) NOT NULL DEFAULT '',
    `addition` text,
    `method_error` text,
    PRIMARY KEY (`order_id`) USING BTREE
) ENGINE=InnoDB;
EOF;
runquery($sql);
C::t('#payment#payment_api')->insert([
    'api_id'      => 'payment_test',
    'identifier'  => 'payment',
    'filename'    => 'source/plugin/payment/payment_test.class.php',
    'description' => 'PaymentTest',
    'method_list' => '',
    'method_rule' => '0',
]);
$finish = true;
?>