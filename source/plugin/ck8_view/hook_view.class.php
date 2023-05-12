<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_ck8_view{
    public static $config;

	public function __construct(){
        self::init();
	}
	
	public function init(){
		global $_G;
		if(empty($_G['cache']['plugin'])){
			loadcache('plugin');
		}
		self::$config = $_G['cache']['plugin']['ck8_view'];
	}
	function global_header(){
		$style ='<div id="superaddition"></div>
		        <style type="text/css">
		        .b1r a#e_view{
					background:transparent url("source/plugin/ck8_view/static/img/cr1.png") no-repeat 0 0;overflow:hidden;background-position:0px 1px;
				}
			    .b2r a#e_view{
					background:transparent url("source/plugin/ck8_view/static/img/cr2.png") no-repeat 0 0;overflow:hidden;background-position:-2px 3px;
				}
				.ck8-tips-bg {
					text-align: inherit;
					font-size: 15px;
					color:#9C27B0;
					background: #fbf6e6;
					padding: 15px 15px;
					border: 2px dashed #f7e5b0;
					margin: 5px;
					border-radius: 5px;
				}
				.ck8-btn {
					height: 28px;
					line-height: 28px;
					padding: 0 12px;
					min-width: 55px;
					display: block;
					font-size: 15px;
					background-color: #f75549;
					color: #f7fafd !important;
					border-radius: 15px;
					text-decoration: none !important;
					float: right;
				}
				.ck8-tips-yd {
					text-align: inherit;
					font-size: 15px;
					line-height: 28px;
					color: #3F51B5;
					background: rgba(174, 229, 249, 0.22);
					padding: 10px 5px;
					border: 2px dashed #dfebf3;
					margin: 5px;
					border-radius: 5px;
				}
				.yds{
					margin-bottom: 10px;
					border-bottom: 1px dashed #bbe2f1;
					padding: 2px 0px;
				}
				</style>';
		return $style;
    }

	function discuzcode($param){
		global $_G;
        if($param['caller'] == 'messagecutstr' ){
		   $_G['discuzcodemessage'] = self::all_replace($_G['discuzcodemessage'],lang('plugin/ck8_view','langview048'));
		}
	}

	public static function all_replace($post,$msg=null){
		if($msg){
			$msg = $msg;
		}else{
			$msg = lang('plugin/ck8_view','langview001');
		}
        return  preg_replace('/\[ck8_view=(\d+)\]\s*(.*?)\s*((\[\/ck8_view\])|\.\.\.)/is', $msg, $post);
	}
}

class plugin_ck8_view_forum extends plugin_ck8_view{

	function post_editorctrl_left(){
		global $_G;
		$config = self::$config;
		if(in_array($_G['groupid'],dunserialize($config['group_open'])) && in_array($_G['fid'],dunserialize($config['forum_open']))){
	        return '<a href="javasrcipt:;" id="e_view" title="'.lang('plugin/ck8_view','langview002').'">'.lang('plugin/ck8_view','langview003').'</a>';
		}
	}

	function post_middle_output(){
        global $_G;
		$config = self::$config;
		$credits = $_G['setting']['extcredits'][$config['credits_type']]['title'];
        include template('ck8_view:insertion');
		return $return;
	}

	public static function viewthread_postbottom_output(){
		global $postlist;
		if(empty($postlist)){return;}
		foreach($postlist as $key =>$val){
            $postlist[$key] = self::ck8_replace($val);
		}
    }

	public static function ck8_replace($postlist){
		global $_G;
		$config = self::$config;
		$message = $postlist['message'];
		$pid = $postlist['pid'];
		$authorid = $postlist['authorid'];
		preg_match_all('/\[ck8_view=(\d+)\]\s*(.*?)\s*\[\/ck8_view\]/is',$message,$matches);
		if(!count($matches[1])){
			return $postlist;
		}
        $log_token = DB::fetch_all("SELECT log_token,log_money FROM %t WHERE log_tid=%d AND log_pid=%d AND log_uid=%d AND log_pay_state=%d",array('ck8_view_buy_log', $_G['tid'], $pid, $_G['uid'], 2));
		$examine = array();
		foreach($log_token as $key => $val){
			$examine[$val['log_token']][] = $val['log_token'];
			$examine[$val['log_token']][] = $val['log_money'];
		}
        foreach($matches[1] as $k => $v){
			if(($examine[$k+1][0] == ($k+1) && $examine[$k+1][1] == $v) || $authorid == $_G['uid'] || in_array($_G['groupid'],dunserialize($config['group_free']))){
				$message = preg_replace('/\[ck8_view=(\d+)\]\s*(.*?)\s*\[\/ck8_view\]/is',self::bought($matches[2][$k],$authorid,$pid,$k+1), $message, 1);
			}else{
				$message = preg_replace('/\[ck8_view=(\d+)\]\s*(.*?)\s*\[\/ck8_view\]/is',self::buyRead($pid, $authorid, $v, $k+1), $message, 1);
			}
		}
		$postlist['message'] = $message;
		return $postlist;
	}

	public static function buyRead($pid,$authorid,$money,$token){
		global $_G;
		$config = self::$config;
		$tid = $_G['tid'];
		$credits = $_G['setting']['extcredits'][$config['credits_type']]['title'];
		$param = rawurlencode(base64_encode(substr(md5($pid.$money.TIMESTAMP.md5($_G['config']['security']['authkey'])), 0, 8).'|'.$authorid.'|'.$tid.'|'.$pid.'|'.$money.'|'.$token.'|'.TIMESTAMP));
	    if($_G['mobile']){
			return '<div class="ck8-tips-bg">
			<span>'.lang('plugin/ck8_view','langview004').'&nbsp;&nbsp;&nbsp;&nbsp;'.lang('plugin/ck8_view','langview005').'&nbsp;<em style="color:#FF5722;font-weight:700;">'.$money.'</em>&nbsp;'.$credits.lang('plugin/ck8_view','langview006').'</span><a href="plugin.php?id=ck8_view:ck8_pay&action=payview&param='.$param.'" class="ck8-btn dialog" style="background-color:'.$config['bj_colour'].';color:'.$config['font_colour'].';">'.lang('plugin/ck8_view','langview007').'</a>
			</div>';
		}else{
			return '<div class="ck8-tips-bg">
			<span>'.lang('plugin/ck8_view','langview004').'&nbsp;&nbsp;&nbsp;&nbsp;'.lang('plugin/ck8_view','langview005').'&nbsp;<em style="color:#FF5722;font-weight:700;">'.$money.'</em>&nbsp;'.$credits.lang('plugin/ck8_view','langview006').'</span><a href="javascript:;" class="ck8-btn" title="'.lang('plugin/ck8_view','langview007').'" onclick="showWindow(\'ck8_view\', \'plugin.php?id=ck8_view:ck8_pay&action=payview&param='.$param.'\')" style="background-color:'.$config['bj_colour'].';color:'.$config['font_colour'].';">'.lang('plugin/ck8_view','langview007').'</a>
			</div>';
		}
	}

	public static function bought($msg,$authorid,$pid,$token){
		global $_G;
		$config = self::$config;
		if($authorid == $_G['uid']){
			if($_G['mobile']){
			$data ='<div class="ck8-tips-yd">
                    <div class="yds cl">'.lang('plugin/ck8_view','langview008').'<a href="plugin.php?id=ck8_view:ck8_pay&action=viewpayments&token='.$token.'&pid='.$pid.'&tid='.$_G['tid'].'" class="ck8-btns dialog y" style="background-color:'.$config['bj_colour'].';top:-5px;position: relative;color:'.$config['font_colour'].';">'.lang('plugin/ck8_view','langview009').'</a></div>'.$msg.'</div>';
			}else{
			$data ='<div class="ck8-tips-yd">
					<div class="yds cl">'.lang('plugin/ck8_view','langview008').'<a href="javascript:;" class="ck8-btn" title="'.lang('plugin/ck8_view','langview009').'" onclick="showWindow(\'viewpay\', \'plugin.php?id=ck8_view:ck8_pay&action=viewpayments&token='.$token.'&pid='.$pid.'&tid='.$_G['tid'].'\')" style="background-color:'.$config['bj_colour'].';top:-5px;position: relative;color:'.$config['font_colour'].';" >'.lang('plugin/ck8_view','langview009').'</a></div>'.$msg.'</div>';
			}
			return $data;
		}else{
			return '<div class="ck8-tips-yd"><div class="yds cl">'.lang('plugin/ck8_view','langview010').'</div>'.$msg.'</div>';
		}
	}

}

class plugin_ck8_view_group extends plugin_ck8_view_forum{
	function post_editorctrl_left(){
		global $_G;
		$config = self::$config;
		if(in_array($_G['groupid'],dunserialize($config['group_open']))){
	        return '<a href="javasrcipt:;" id="e_view" title="'.lang('plugin/ck8_view','langview002').'">'.lang('plugin/ck8_view','langview003').'</a>';
		}
	}
}

class plugin_ck8_view_search extends plugin_ck8_view{
	function forum_top_output(){
		global $threadlist;
		foreach($threadlist as &$post){
			$post['message'] = self::all_replace($post['message']);
		}
		unset($post);
		return array();
	}
}

class plugin_ck8_view_home extends plugin_ck8_view{
	function follow_top_output(){
		global $list;
		foreach ($list['content'] as &$post){
			$post['content'] = self::all_replace($post['content']);
		}
        unset($post);
		return array();
	}
}

class mobileplugin_ck8_view extends plugin_ck8_view{
	function global_header_mobile(){
		return '<link rel="stylesheet" href="source/plugin/ck8_view/static/css/style.css" type="text/css">';
	}
}

class mobileplugin_ck8_view_forum extends  mobileplugin_ck8_view{

	function post_bottom_mobile(){
		global $_G;
		$config = self::$config;
		if(in_array($_G['groupid'],dunserialize($config['group_open'])) && in_array($_G['fid'],dunserialize($config['forum_open']))){
			$credits = $_G['setting']['extcredits'][$config['credits_type']]['title'];
			include template('ck8_view:insertion');
			return $return;
		}
	}

	function viewthread_postbottom_mobile_output(){
		global $postlist;
		if(empty($postlist)){return;}
		foreach($postlist as $key =>$val){
            $postlist[$key] = plugin_ck8_view_forum::ck8_replace($val);
		}
	}
}

class mobileplugin_ck8_view_group extends mobileplugin_ck8_view_forum{
	function post_bottom_mobile(){
		global $_G;
		$config = self::$config;
		if(in_array($_G['groupid'],dunserialize($config['group_open']))){
			$credits = $_G['setting']['extcredits'][$config['credits_type']]['title'];
			include template('ck8_view:insertion');
			return $return;
		}
	}
}
?>