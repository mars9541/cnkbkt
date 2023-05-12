<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
define('IDENTIFIER','hax_avatarfilletedcorner');
global $_G;
loadcache('plugin');
$lang=lang('plugin/'.IDENTIFIER);
include template(IDENTIFIER.':about');

?>