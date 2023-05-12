<?php
if(!defined('IN_DISCUZ')||!defined('IN_ADMINCP')) {
	exit('Access Denied');
}
global $_G;
$pres=$_G['config']['db']['1']['tablepre'];
$viptool=$pres.'xc_tagkeywords';
$viprel=$pres.'xc_kwforum';
$sql = <<<EOF
drop table IF EXISTS `$viptool`;
drop table IF EXISTS `$viprel`;
EOF;
runquery($sql);
$cachenames='xcforumtagtothread';
if(!empty($cachenames)) {
    C::t('common_syscache')->delete($cachenames);
}
updatecache();
$finish = TRUE;
?>