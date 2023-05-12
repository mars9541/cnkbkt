<?php
if (!defined('IN_DISCUZ')) {
	exit ('Access Denied');
}
$modarray = array (	
    'sh',
);

$modac = !in_array(daddslashes($_GET['modac']), $modarray) ? 'main' : $_GET['modac'];

$config  =  $_G['cache']['plugin']['dev8133_integralpaypal'];

$submodac  = daddslashes($_GET['submodac']);
$uid = intval($_G['uid']);
$username= $_G['username'];
$pcbanner = explode("||",$config['banner']);

require DISCUZ_ROOT . './source/plugin/dev8133_integralpaypal/module/dev8133_' . $modac . '.php';
?>