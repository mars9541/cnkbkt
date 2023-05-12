<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include_once DISCUZ_ROOT.'./source/plugin/ck8_view/function.php';
if(empty($_G['cache']['plugin'])){
	loadcache('plugin');
}
$config = $_G['cache']['plugin']['ck8_view'];
if(!$_G['uid']){
	showmessage(lang('plugin/ck8_view','langview011'), "member.php?mod=logging&action=login",array(),array('showdialog' => 1, 'locationtime' => true));
}
$creditstitle = $_G['setting']['extcredits'][$config['credits_type']]['title'];

if($_GET['action'] == 'payview'){
	$pay_type = explode("|",$config['pay_type']);
    $credits = getuserprofile('extcredits'.$config['credits_type']);
	@list($ver,$authorid,$tid,$pid,$money,$token,$date) = daddslashes(explode("|",rawurldecode(base64_decode($_GET['param']))));
	if(!submitcheck('paydisposesubmit')){
		$vers = substr(md5($pid.$money.$date.md5($_G['config']['security']['authkey'])), 0, 8);
			if($vers != $ver){
				showmessage('parameters_error');
			}else{
				if(empty($tid) || empty($authorid) || empty($pid) || empty($token) || empty($money)){
					showmessage('undefined_action');
				}
				$log_data = array();
				$log_data['log_tid'] = dintval($tid);
				$log_data['log_pid'] = dintval($pid);
				$log_data['log_token'] = dintval($token);
				$log_data['log_authorid'] = dintval($authorid);
				$log_data['log_uid'] = $_G['uid'];
				$log_data['log_money'] =  round($money);
				$log_data['log_money2'] =  '';
				$log_data['log_pay_type'] = '';
				$log_data['log_authorid_reap'] = '';
				$log_data['log_pay_state'] = 1;
				$log_data['log_pay_date'] = '';
				$log_data['log_date'] = TIMESTAMP;
				$log_list = C::t('#ck8_view#ck8_view_buy_log')->get_view_buy_log_first(
					array(
						'log_tid' => dintval($tid),
						'log_pid' => dintval($pid),
						'log_token' => dintval($token),
						'log_authorid' => dintval($authorid),
						'log_uid' => $_G['uid'],
						'log_pay_state' => 1
					)
				);
				if($log_list['log_id']){
					C::t('#ck8_view#ck8_view_buy_log')->update($log_data,array('log_id' => $log_list['log_id']));
				}else{
					C::t('#ck8_view#ck8_view_buy_log')->insert($log_data);
				}
				unset($log_list);
			}
		include template('ck8_view:pay');
	}else{
	    $rmbpay_type = array('jfzf','wxzf', 'zfbzf');
		$tid = dintval($_GET['tid']);
		$pid = dintval($_GET['pid']);
		$token = dintval($_GET['token']);
		if(empty($_GET['formhash']) || $_GET['formhash'] != FORMHASH){
            showmessage('undefined_action', NULL);
		}
		
		if(!in_array($_GET['zffs'], $rmbpay_type)){
			showmessage(lang('plugin/ck8_view','langview012'), NULL);
		}

		$log_list = C::t('#ck8_view#ck8_view_buy_log')->get_view_buy_log_first(array('log_tid' => $tid,'log_pid' => $pid,'log_token' => $token,'log_uid' => $_G['uid'],'log_pay_state' => 1));
		$author_earnings = round($log_list['log_money'] * $config['author_earnings']);

		if($_GET['zffs'] == 'jfzf'){

			if($log_list['log_money'] > $credits){
				showmessage(lang('plugin/ck8_view','langview013'), NULL);
			}
			$log_data = array();
			$log_data['log_pay_type'] = 1;//1.积分 2.人民币
			$log_data['log_authorid_reap'] = !empty($config['author_earnings']) ? $author_earnings : '';
			$log_data['log_pay_state'] = 2;
			$log_data['log_pay_date'] = TIMESTAMP;
			
			if($log_list['log_id']){
				C::t('#ck8_view#ck8_view_buy_log')->update($log_data,array('log_id' => $log_list['log_id']));
				updatemembercount($log_list['log_uid'], array('extcredits'.$config['credits_type'] => -$log_list['log_money']), true, '',1,1,lang('plugin/ck8_view','langview014'),lang('plugin/ck8_view','langview015'));
				if(!empty($config['author_earnings'])){
					updatemembercount($log_list['log_authorid'], array('extcredits'.$config['credits_type'] => $author_earnings), true, '',1,1,lang('plugin/ck8_view','langview016'),lang('plugin/ck8_view','langview017'));
				}
				showmessage(lang('plugin/ck8_view','langview018'), 'forum.php?mod=viewthread&tid='.$tid.'',array(),array('showmsg' => 1));
			}else{
                showmessage(lang('plugin/ck8_view','langview019'), NULL);
			}

		}else if(($_GET['zffs'] == 'zfbzf' || $_GET['zffs'] == 'wxzf') && in_array('ck8_pay',$_G['setting']['plugins']['available'])){
			include_once DISCUZ_ROOT.'./source/plugin/ck8_pay/function.php';
			
			$log_money2 = $log_list['log_money'] / $config['credits_percentage'];
			$log_data = array();
			$log_data['log_money2'] = round($log_money2, 2);
			$log_data['log_pay_type'] = 2;
			$log_data['log_authorid_reap'] = !empty($config['author_earnings']) ? $author_earnings : '';
			C::t('#ck8_view#ck8_view_buy_log')->update($log_data,array('log_id' => $log_list['log_id']));

			$orderno = date('Ymd',TIMESTAMP).viewget_randChar(12).'-'.$log_list['log_id'];
			$source = GetPluginList('ck8_view');
			$describe = lang('plugin/ck8_view','langview021');
			$jmurl = $_G['siteurl'].'forum.php?mod=viewthread&tid='.$log_list['log_tid'];
			if($_GET['zffs'] == 'zfbzf'){
				$notify_url = $_G['siteurl'].'source/plugin/ck8_view/notify/notify_url.php';
				$return_url = $_G['siteurl'].'source/plugin/ck8_view/notify/return_url.php';
			}else if($_GET['zffs'] == 'wxzf'){
				$notify_url = $_G['siteurl'].'source/plugin/ck8_view/notify/wx_notify.php';
				$return_url = '';
			}

		    $p_id = creation_Pay($orderno,$source['name'], $describe, pay_type($_GET['zffs']), $log_data['log_money2'], $notify_url, $jmurl, $return_url);
			if($p_id){
				showmessage(lang('plugin/ck8_view','langview022'), 'plugin.php?id=ck8_pay:pay_dispose&p_id='.$p_id, array('p_id' => $p_id, 'pay_type' => $_GET['zffs']));
			}else{
				showmessage(lang('plugin/ck8_view','langview023'));
			}
			
		}else{
			showmessage(lang('plugin/ck8_view','langview023'));
		}
	}

} else if($_GET['action'] == 'viewpayments') {
	$perpage = 10;
	$curpage = empty($_GET['page']) ? 1 : intval($_GET['page']);
	$start = ($curpage-1)*$perpage;
    $where = array();
	$where['log_authorid'] = $_G['uid'];
	$where['log_tid'] = dintval($_GET['tid']);
	$where['log_pid'] = dintval($_GET['pid']);
	$where['log_token'] = dintval($_GET['token']);
	$where['log_pay_state'] = 2;
	$log_list = C::t('#ck8_view#ck8_view_buy_log')->get_view_buy_log_list($start,$perpage,$where);
	$g_lists = array();
	foreach($log_list as $k => $v){
        $g_uid = getuserbyuid($v['log_uid']);
		$g_lists[$k]['log_uid'] = $g_uid['username'];
		$g_lists[$k]['log_money'] = $v['log_money'].'<font style="color:#999;font-size:13px;">'.$creditstitle.'</font>';
		$g_lists[$k]['log_money2'] = $v['log_money2'] !=0 ? $v['log_money2'].'<font style="color:#999;font-size:12px;">RMB</font>' :'--';
		$g_lists[$k]['log_pay_type'] = $v['log_pay_type'] == 1 ? lang('plugin/ck8_view','langview024') : lang('plugin/ck8_view','langview025');
		$g_lists[$k]['log_authorid_reap'] = $v['log_authorid_reap'].'<font style="color:#999;font-size:13px;">'.$creditstitle.'</font>';
		$g_lists[$k]['log_date'] = dgmdate($v['log_date'], 'Y-m-d');
		$g_lists[$k]['pay_type'] = $v['log_pay_type'];
	}
    include template('ck8_view:pay_view');
}
?>