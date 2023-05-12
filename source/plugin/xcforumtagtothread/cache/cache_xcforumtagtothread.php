<?php 
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
function build_cache_plugin_xcforumtagtothread() {
    require_once 'source/plugin/xcforumtagtothread/function/function_core.php';
    xc_xcforumtagtothread_updatecache();
}
?>