<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	global $_G;
	loadcache('plugin');
	if (submitcheck("forumset")) {
		if(is_array($_GET['delete'])) {
				C::t('#dev8133_integralpaypal#dev8133_integralpaypal')->delete($_GET['delete']);
		}
		cpmsg(lang('plugin/dev8133_integralpaypal', 'common_06'), 'action=plugins&operation=config&identifier=dev8133_integralpaypal&pmod=adminjf', 'succeed');
	}
	
	
	if($_GET['ac']){
		if($_GET['formhash'] != $_G['formhash']) {
			exit('Access Denied');
		}
		
		if($_GET['ac']=='edit'){
		    
		    $jfid= intval($_GET['jfid']);
		    if($jfid){
		        $ws = " where id=".$jfid;
    		    $editdata = C::t('#dev8133_integralpaypal#dev8133_integralpaypal')->fetch_first_field_data("*",$ws);
		    }
		    
			if (submitcheck("editsubmit")) {
				
				if(!$_GET['intetype'] ||  !$_GET['intcount'] || !$_GET['price'] ){
				    cpmsg(lang('plugin/dev8133_integralpaypal', 'adminjf06'), '', 'error');
				}
				$arr=array(
					'intetype'=> intval($_GET['intetype']),
				    'intcount'=> intval($_GET['intcount']),
				    'zsintetype'=> intval($_GET['zsintetype']),
				    'ishowicon'=> intval($_GET['ishowicon']),
				    'zsintcount'=> intval($_GET['zsintcount']),
				    'price'=> intval($_GET['price']),
				    'remark'=> daddslashes($_GET['remark']),
				    'intesort'=> intval($_GET['intesort']),
				    'dateline'=>TIMESTAMP,
				);
				if($editdata['id']){
				    C::t('#dev8133_integralpaypal#dev8133_integralpaypal')->update($editdata['id'],$arr);
				}else{
					C::t('#dev8133_integralpaypal#dev8133_integralpaypal')->insert($arr);
				}
				cpmsg(lang('plugin/dev8133_integralpaypal', 'common_06'), 'action=plugins&operation=config&identifier=dev8133_integralpaypal&pmod=adminjf&formhash='.FORMHASH, 'succeed');
			}
			
			foreach($_G['setting']['extcredits'] as $k=>$v){
			    $intedata .= "<option value=".$k.">".$v['title']."</option>";
			    
			}
			showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=adminjf&ac=edit", 'enctype');
			showtableheader(lang('plugin/dev8133_integralpaypal', 'adminjf08'));
			showsetting( lang('plugin/dev8133_integralpaypal', 'adminjf01'), '', $editdata['intetype'], "<select name='intetype'>".$intedata."</select>");
			showsetting(lang('plugin/dev8133_integralpaypal', 'adminjf07'),'intcount',$editdata['intcount'],'text');
			showsetting(lang('plugin/dev8133_integralpaypal', 'adminjf03'),'price',$editdata['price'],'text');
			showsetting(lang('plugin/dev8133_integralpaypal', 'adminjf02'), '', $editdata['zsintetype'], "<select name='zsintetype'>".$intedata."</select>");
			showsetting(lang('plugin/dev8133_integralpaypal', 'adminjf09'),'zsintcount',$editdata['zsintcount'],'text');
			showsetting(lang('plugin/dev8133_integralpaypal', 'adminjf05'),'intesort',$editdata['intesort'],'text',"","",lang('plugin/dev8133_integralpaypal', 'adminjf11'));
			showsetting(lang('plugin/dev8133_integralpaypal', 'adminjf10'),'ishowicon',$editdata['ishowicon'],'radio');
			showsetting(lang('plugin/dev8133_integralpaypal', 'adminjf04'),'remark',$editdata['remark'],'textarea','','');
			echo '<input name="jfid" type="hidden" value="'.$editdata['id'].'" />';
			showsubmit('editsubmit', 'submit', '');
			showtablefooter();
   			showformfooter();
			exit();
		}
		cpmsg(lang('plugin/dev8133_integralpaypal', 'lang18'), 'action=plugins&operation=config&identifier=dev8133_integralpaypal&pmod=adminjf', 'succeed');
	}
	
	
    showformheader("plugins&operation=config&do=" . $plugin["pluginid"] . "&identifier=" . $plugin["identifier"] . "&pmod=adminjf");
    showtableheader(lang('plugin/dev8133_integralpaypal', 'lang46'));
    showsubtitle(array(
        "ID",
        lang('plugin/dev8133_integralpaypal', 'adminjf01'),
        lang('plugin/dev8133_integralpaypal', 'adminjf02'),
        lang('plugin/dev8133_integralpaypal', 'adminjf03'),
        lang('plugin/dev8133_integralpaypal', 'adminjf04'),
        lang('plugin/dev8133_integralpaypal', 'adminjf05'),
        lang('plugin/dev8133_integralpaypal', 'common_03'),
    ));
    
    $ppp = 25;
    $where =  " order by intesort desc";
    $tmpurl=ADMINSCRIPT.'?action=plugins&operation=config&identifier=dev8133_integralpaypal&pmod=adminjf';
    $page = max (1,intval($_GET['page']));
    $startlimit = ($page - 1) * $ppp;
    $allcount = C::t('#dev8133_integralpaypal#dev8133_integralpaypal')->count_all();
    if ($allcount) {
        $query = C::t ( '#dev8133_integralpaypal#dev8133_integralpaypal' )->fetch_all_by_limit ($startlimit, $ppp,$where);
    	foreach($query as $k=>$v){
    		$table = array();
            $table[0] = '<input type="checkbox" class="checkbox" name="delete[]" value="'.$v['id'].'" />';
            $table[1] = $v['intcount'].$_G['setting']['extcredits'][$v['intetype']]['title'];
            $table[2] =  $v['zsintcount'].$_G['setting']['extcredits'][$v['zsintetype']]['title'];
            $table[3] = $v['price'];
    		$table[5] = $v['remark'];
    		$table[51] = $v['intesort'];
    		$table[6] = '<a href='.ADMINSCRIPT.'?action=plugins&operation=config&identifier=dev8133_integralpaypal&pmod=adminjf&ac=edit&jfid='.$v['id'].'&formhash='.FORMHASH.'>'.lang('plugin/dev8133_integralpaypal', 'common_02').'</a>';
            showtablerow('',array(), $table);
    	}
    }
    $multipage = '';
    $multipage = multi ( $allcount, $ppp, $page, $_G ['siteurl'] . $tmpurl );
    if ($multipage)
        echo '<tr class="hover"><td colspan="9">' . $multipage . '</td></tr>';
	showsubmit('forumset', 'submit', 'del',' <a href='.ADMINSCRIPT.'?action=plugins&operation=config&identifier=dev8133_integralpaypal&pmod=adminjf&ac=edit&formhash='.FORMHASH.' class="addtr">'.lang('plugin/dev8133_integralpaypal', 'common_01').'</a>');
    showtablefooter();
    showformfooter();
