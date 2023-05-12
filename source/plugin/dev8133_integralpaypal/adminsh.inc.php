<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

echo lang('plugin/dev8133_integralpaypal', 'admincp01');
echo lang('plugin/dev8133_integralpaypal', 'admin00001')."<a href='plugin.php?id=dev8133_integralpaypal&modac=sh' target='_blank'>".$_G['siteurl']."plugin.php?id=dev8133_integralpaypal&modac=sh</a>";
echo lang('plugin/dev8133_integralpaypal', 'admin00002')."<a href='plugin.php?id=dev8133_integralpaypal' target='_blank'>".$_G['siteurl']."plugin.php?id=dev8133_integralpaypal</a>";
?>