<?php 
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
loadcache('plugin');

class plugin_xcforumtagtothread{
    public $showposition;
    public $isuse;
    public $sign;
    function __construct(){
        global $_G;
        $pluginvalue=$_G['cache']['plugin']['xcforumtagtothread'];
        $this->isuse=$pluginvalue['isopen'];
        $this->showposition=$pluginvalue['titleposition'];
        $this->sign=$pluginvalue['tagsign'];
    }	
}

class plugin_xcforumtagtothread_forum extends plugin_xcforumtagtothread{
    public  function post_top(){
        global $_G;
        //fid to list
        $fid=$_G['fid'];
        if (intval($fid)>0&&$this->isuse){
            require_once 'source/plugin/xcforumtagtothread/function/function_core.php';
            $list=xc_xcforumtagtothread_getcache();
            foreach ($list as $key=>$values){
                if ($values['fid']==$fid) {
                    $pagekwlist[]=$values;
                }
            }
            $positions=$this->showposition;
            $signs=$this->sign;
            if (!empty($signs)) {
                $arrsigns=explode(',', $signs);
                if (sizeof($arrsigns)>1) {
                    $leftsign=$arrsigns[0];
                    $righsign=$arrsigns[1];
                }
            }
            include template('xcforumtagtothread:selectlist');
            return $return;
        }
    }
}
?>