<?php 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$admingroup = dunserialize($config['admingroup']);
if(!in_array($_G['groupid'],$admingroup)){
    showmessage(lang('plugin/dev8133_integralpaypal', 'qd001'));
}


if($submodac == "shsubmit"){
    
    if(empty($_GET['formhash']) || $_GET['formhash'] != formhash() ){
        showmessage('error');
    }
    
    $aid = intval($_GET['aid']);
    $wheres = " where id=".$aid;
    $query = C::t('#dev8133_integralpaypal#dev8133_integralpaypal_order')->fetch_first_field_data('*', $wheres);
    if(!$query){
        showmessage("data error");
    }
    
    if($query['ostatus'] == 2){
        showmessage(lang('plugin/dev8133_integralpaypal', 'adminpaystr_7'));
    }
    
    $updata = array(
        'ostatus'=>2,
        'shdateline'=>TIMESTAMP,
    );
    
    C::t('#dev8133_integralpaypal#dev8133_integralpaypal_order')->update($aid,$updata);
    
    //加积分
    updatemembercount($query['uid'], array('extcredits'.$query['intetype']=>$query['intcount']),true,'',0,'',lang('plugin/dev8133_integralpaypal', 'shstr01'),lang('plugin/dev8133_integralpaypal', 'shstr02'));
    updatemembercount($query['uid'], array('extcredits'.$query['zsintetype']=>$query['zsintcount']),true,'',0,'',lang('plugin/dev8133_integralpaypal', 'shstr03'),lang('plugin/dev8133_integralpaypal', 'shstr04'));
    //发消息
    $msg = lang('plugin/dev8133_integralpaypal', 'shstr05').$query['intcount'].$_G['setting']['extcredits'][$query['intetype']]['title'].lang('plugin/dev8133_integralpaypal', 'shstr06');
    notification_add($query['uid'], 'system', $msg);
    showmessage(lang('plugin/dev8133_integralpaypal', 'common_06'), 'plugin.php?id=dev8133_integralpaypal&modac=sh&page='.intval($_GET['page']),'',array('alert=>right'));
    
}elseif($submodac == "delete"){
    
    if(empty($_GET['formhash']) || $_GET['formhash'] != formhash() ){
        showmessage('error');
    }
    
    $aid = daddslashes($_GET['aid']);
    $wheres = " where orderid='".$aid."'";
    $query = C::t('#dev8133_integralpaypal#dev8133_integralpaypal_order')->fetch_first_field_data('*', $wheres);
    if(!$query){
        showmessage("data error");
    }
    C::t('#dev8133_integralpaypal#dev8133_integralpaypal_order')->delete_by_id($aid);
    
    showmessage(lang('plugin/dev8133_integralpaypal', 'common_06'), 'plugin.php?id=dev8133_integralpaypal&modac=sh&page='.intval($_GET['page']),'',array('alert=>right'));
    
}else{
    
    
    $wheres .= " order by dateline desc";
    $ppp = 25;
    $tmpurl = 'plugin.php?id=dev8133_integralpaypal&modac=sh';
    
    
    $page = max ( 1, intval($_GET ['page']));
    $startlimit = ($page - 1) * $ppp;
    $allcount = C::t('#dev8133_integralpaypal#dev8133_integralpaypal_order')->count_all($wheres);
    if ($allcount) {
        $uidccfadata = C::t ( '#dev8133_integralpaypal#dev8133_integralpaypal_order' )->fetch_all_by_limit( $startlimit, $ppp, $wheres );
    }
    $multipage = '';
    $multipage = multi ( $allcount, $ppp, $page, $_G ['siteurl'] . $tmpurl );
    
    include template('dev8133_integralpaypal:admin');
}
?>