<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

include_once DISCUZ_ROOT.'./source/plugin/ck8_pay/function.php';

    $act = daddslashes($_GET['act']);
	if ($act == 'empty' && submitcheck('submit')){
		C::t('#ck8_pay#ck8_pay_log')->delete(array('p_state' => 1));
		cpmsg(lang('plugin/ck8_pay','langs015'),'action=plugins&operation=config&do='.$pluginid.'&identifier=ck8_pay&pmod=admin_paylist', 'succeed');
	}

	$perpage = 20;
	$curpage = empty($_GET['page']) ? 1 : intval($_GET['page']);
	$start = ($curpage-1)*$perpage;
	$p_uidval = dintval($_GET['p_uid']);
	$p_typeval = dintval($_GET['p_type']);
	$p_stateval = dintval($_GET['p_state']);
	$p_dateline = dmktime($_GET['p_dateline']);
	$p_dateline2 = dmktime($_GET['p_dateline2']);
    $where = array();
	if($p_uidval){
        $where['p_uid'] = $p_uidval;
	}
	if($p_typeval){
        $where['p_type'] = $p_typeval;
	}
	if($p_stateval){
        $where['p_state'] = $p_stateval;
	}
	if($p_dateline){
		$p_dateline = strtotime(date('Y-m-d',$p_dateline));
        $where['p_dateline'] = $p_dateline;
	}
	if($p_dateline2){
		$p_dateline2 = strtotime(date('Y-m-d',strtotime( "+1 day",$p_dateline2)));
        $where['p_dateline2'] = $p_dateline2;
	}

	$count = C::t('#ck8_pay#ck8_pay_log')->get_pay_log_count($where);
	$mpurl = ADMINSCRIPT."?action=plugins&operation=config&do=".$pluginid."&identifier=ck8_pay&pmod=admin_paylist&p_uid=".$p_uidval."&p_type=".$p_typeval."&p_state=".$p_stateval
	."&p_dateline=".$p_dateline."&p_dateline2=".$p_dateline2;
	$multipage = multi($count, $perpage,$curpage,$mpurl, 0, 5);
	$p_list = C::t('#ck8_pay#ck8_pay_log')->get_pay_log_list($start,$perpage,$where);
	$bnt = lang('plugin/ck8_pay','langs016');
    $screen = lang('plugin/ck8_pay','langs017');
    $p_state =  lang('plugin/ck8_pay','langs018');
    $p_uid =  lang('plugin/ck8_pay','langs019');
    $p_data =  lang('plugin/ck8_pay','langs020');
	$p_pytes = array();
	$p_pytes[] = array(1,lang('plugin/ck8_pay','langs022'));
	$p_pytes[] = array(2,lang('plugin/ck8_pay','langs023'));
	$p_pytes[] = array(3,lang('plugin/ck8_pay','langs029'));
	$p_pytes[] = array(4,lang('plugin/ck8_pay','langs024'));
	$p_pytes[] = array(5,lang('plugin/ck8_pay','langs025'));
	$p_pytes[] = array(6,lang('plugin/ck8_pay','langs033'));
	$p_pytes[] = array(7,lang('plugin/ck8_pay','langs034'));

	$p_states = array();
	$p_states[] = array(1, lang('plugin/ck8_pay','langs011'));
	$p_states[] = array(2, lang('plugin/ck8_pay','langs012'));
	$p_pyte = ck8_pay_select('p_type', $p_pytes, $p_typeval, array(0, lang('plugin/ck8_pay','langs021')));
	$state = ck8_pay_select('p_state', $p_states, $p_stateval, array(0, lang('plugin/ck8_pay','langs021')));
echo <<<SEARCH
        <script src="static/js/calendar.js" type="text/javascript"></script>
		<form method="post" autocomplete="off" id="tb_search" action="$mpurl">
		<table style="padding:10px 0;">
			<tbody>
			<tr>
			<th>
			    <td>&nbsp;$screen&nbsp;</td><td>$p_pyte</td>
				<td>&nbsp;&nbsp;&nbsp;$p_state</td><td>&nbsp;$state&nbsp;&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;&nbsp;$p_uid</td><td>&nbsp;<td><input type="text" name="p_uid" value="" style="width:80px;"></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$p_data</td><td>&nbsp;<td>
                  <input type="text" class="txt" name="p_dateline" value="{$_GET['p_dateline']}" onclick="showcalendar(event, this)">~
                  <input type="text" class="txt" name="p_dateline2" value="{$_GET['p_dateline2']}" onclick="showcalendar(event, this)">
				</td>
				<td>&nbsp;&nbsp;&nbsp;<input type="submit" class="btn" value="$bnt"></td>
			</th>
			</tr>
			</tbody>
		</table>
		</form>
SEARCH;
showformheader('plugins&operation=config&do='.$pluginid.'&identifier=ck8_pay&pmod=admin_paylist&act=empty','enctype');
	showtableheader(lang('plugin/ck8_pay','langs014'));
		showtablerow('',array('class="td25"'),array(
			'ID',
			lang('plugin/ck8_pay','langs001'),
			lang('plugin/ck8_pay','langs002'),
			lang('plugin/ck8_pay','langs003'),
			lang('plugin/ck8_pay','langs004'),
			lang('plugin/ck8_pay','langs005'),
			lang('plugin/ck8_pay','langs006'),
			lang('plugin/ck8_pay','langs007'),
			lang('plugin/ck8_pay','langs008'),
			lang('plugin/ck8_pay','langs009'),
			lang('plugin/ck8_pay','langs010')
		));
		foreach ($p_list as $v) {
			$get_name = getuserbyuid($v['p_uid']);
			showtablerow('', array('class="td25"'), array(
				$v['p_id'],
				$v['p_number'],
				$v['p_source'],
				$v['p_describe'],
				PaymentType($v['p_type']),
				$get_name['username'],
				$v['p_money'],
				$v['p_state'] == 2 ? '<em style="color:#f00;">'.lang('plugin/ck8_pay','langs012').'</em>' : lang('plugin/ck8_pay','langs011'),
				$v['p_numbered'] ? $v['p_numbered'] : '--',
				$v['p_date'] ? dgmdate($v['p_date'],'Y-m-d H:i:s') : '--',
				dgmdate($v['p_dateline'],'Y-m-d H:i:s'),
			));
		}
		showsubmit('submit', lang('plugin/ck8_pay', 'langs013'),'','',$multipage);
	showtablefooter();
showformfooter();
?>