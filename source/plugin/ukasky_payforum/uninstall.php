<?php
/**
 * 
 * Ukasky BBS [http://bbs.ukasky.com]
 * @author Mr. Chen
 * My Blog: http://chen.disyo.com
 */

if(!defined('IN_DISCUZ') && !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//更新数据库
$tablename = DB::table(ukasky_payforum);

$sql = <<<EOF

DROP TABLE IF EXISTS `$tablename`;

EOF;

runquery($sql);
$finish = TRUE;
?>