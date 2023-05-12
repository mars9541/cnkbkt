<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

include_once DISCUZ_ROOT.'./source/plugin/ck8_view/function.php';

	if(empty($_G['cache']['plugin'])){
		loadcache('plugin');
	}
	$config = $_G['cache']['plugin']['ck8_view'];
    $act = daddslashes($_GET['act']);
	if ($act == 'empty' && submitcheck('submit')){
		C::t('#ck8_view#ck8_view_buy_log')->delete(array('log_pay_state' => 1));
		cpmsg(lang('plugin/ck8_view','langview035'),'action=plugins&operation=config&do='.$pluginid.'&identifier=ck8_view&pmod=admin_buylist', 'succeed');
	}
	$perpage = 20;
	$curpage = empty($_GET['page']) ? 1 : intval($_GET['page']);
	$start = ($curpage-1)*$perpage;
	$log_uidval = dintval($_GET['log_uid']);
	$log_typeval = dintval($_GET['log_pay_type']);
	$log_pay_stateval = dintval($_GET['log_pay_state']);
	$log_dateline = dmktime($_GET['log_dateline']);
	$log_dateline2 = dmktime($_GET['log_dateline2']);
	$where = array();
	if($log_uidval){
        $where['log_uid'] = $log_uidval;
	}
	if($log_typeval){
        $where['log_pay_type'] = $log_typeval;
	}
	if($log_pay_stateval){
        $where['log_pay_state'] = $log_pay_stateval;
	}
	if($log_dateline){
        $where['log_date'] = $log_dateline;
	}
	if($log_dateline2){
        $where['log_date2'] = $log_dateline2;
	}
	$count = C::t('#ck8_view#ck8_view_buy_log')->get_view_buy_log_count($where);
	$mpurl = ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=ck8_view&pmod=admin_buylist&log_uid=".$log_uidval."&log_pay_type=".$log_typeval."&log_pay_state=".$log_pay_stateval
	."&log_dateline=".$log_dateline."&log_dateline2=".$log_dateline2;
	$multipage = multi($count, $perpage,$curpage,$mpurl, 0, 5);
	$log_list = C::t('#ck8_view#ck8_view_buy_log')->get_view_buy_log_list($start,$perpage,$where);
	$bnt = lang('plugin/ck8_view','langview028');
    $screen = lang('plugin/ck8_view','langview027');
	$log_pay_state = lang('plugin/ck8_view','langview031');
	$log_uid = lang('plugin/ck8_view','langview032');
    $log_data = lang('plugin/ck8_view','langview033');
	$log_pytes = array();
	$log_pytes[] = array(1,lang('plugin/ck8_view','langview024'));
	$log_pytes[] = array(2,lang('plugin/ck8_view','langview025'));
	$log_pay_states = array();
	$log_pay_states[] = array(1, lang('plugin/ck8_view','langview029'));
	$log_pay_states[] = array(2, lang('plugin/ck8_view','langview030'));
	$log_pyte = ck8_select('log_pay_type', $log_pytes, $log_typeval, array(0, lang('plugin/ck8_view','langview026')));
	$state = ck8_select('log_pay_state', $log_pay_states, $log_pay_stateval, array(0, lang('plugin/ck8_view','langview026')));
echo <<<SEARCH
        <script src="static/js/calendar.js" type="text/javascript"></script>
		<form method="post" autocomplete="off" id="tb_search" action="$mpurl">
		<table style="padding:10px 0;">
			<tbody>
			<tr>
			<th>
			    <td>&nbsp;$screen&nbsp;</td><td>$log_pyte</td>
				<td>&nbsp;&nbsp;&nbsp;$log_pay_state</td><td>&nbsp;$state&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;$log_uid</td><td>&nbsp;<td><input type="text" name="log_uid" value="" style="width:80px;"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$log_data</td><td>&nbsp;<td>
                  <input type="text" class="txt" name="log_dateline" value="{$_GET['log_dateline']}" onclick="showcalendar(event, this)">~
                  <input type="text" class="txt" name="log_dateline2" value="{$_GET['log_dateline2']}" onclick="showcalendar(event, this)">
				</td>
				<td>&nbsp;&nbsp;&nbsp;<input type="submit" class="btn" value="$bnt"></td>
			</th>
			</tr>
			</tbody>
		</table>
		</form>
SEARCH;
showformheader('plugins&operation=config&do='.$pluginid.'&identifier=ck8_view&pmod=admin_buylist&act=empty','enctype');
	showtableheader(lang('plugin/ck8_view','langview034'));
		showtablerow('',array('class="td25"'),array(
			'ID',
			lang('plugin/ck8_view','langview038'),
			lang('plugin/ck8_view','langview039'),
			lang('plugin/ck8_view','langview040'),
			lang('plugin/ck8_view','langview041'),
			lang('plugin/ck8_view','langview042'),
			lang('plugin/ck8_view','langview043'),
			lang('plugin/ck8_view','langview044'),
			lang('plugin/ck8_view','langview045'),
			lang('plugin/ck8_view','langview046'),
			lang('plugin/ck8_view','langview047')
		));
		foreach ($log_list as $v) {
			$name = getuserbyuid($v['log_authorid']);
			$name2 = getuserbyuid($v['log_uid']);
			showtablerow('', array('class="td25"'), array(
				$v['log_id'],
				$name['username'],
				$name2['username'],
				'<a href="forum.php?mod=viewthread&tid='.$v['log_tid'].'" target="_blank">'.lang('plugin/ck8_view','langview036').'</a>',
				$v['log_pay_type'] == 1 ? $v['log_money'].$_G['setting']['extcredits'][$config['credits_type']]['title'] : '--',
				$v['log_money2'],
				$v['log_pay_type'] == 1 ? lang('plugin/ck8_view','langview024') : lang('plugin/ck8_view','langview025'),
				$v['log_authorid_reap'] ? $v['log_authorid_reap'].$_G['setting']['extcredits'][$config['credits_type']]['title'] : '--',
			    $v['log_pay_state'] == 2 ? '<em style="color:#f00;">'.lang('plugin/ck8_view','langview030').'</em>' : lang('plugin/ck8_view','langview029'),
				$v['log_pay_date'] ? dgmdate($v['log_pay_date'],'Y-m-d H:i:s') : '--',
				dgmdate($v['log_date'],'Y-m-d H:i:s'),
			));
		}
		showsubmit('submit', lang('plugin/ck8_view', 'langview037'),'','',$multipage);
	showtablefooter();
showformfooter();
?>