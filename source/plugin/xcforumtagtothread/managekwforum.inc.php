<?php
if(!defined('IN_DISCUZ')||!defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$plugin_setname=lang('plugin/xcforumtagtothread', 'plugin');
$plugin_title=lang('plugin/xcforumtagtothread', 'thread');
$plugin_cattitle=lang('plugin/xcforumtagtothread', 'title');
$plugin_num=lang('plugin/xcforumtagtothread', 'ordernum');
$plugin_setmore=lang('plugin/xcforumtagtothread', 'pluginmore');
$plugin_status=lang('plugin/xcforumtagtothread', 'status');
$plugin_stop=lang('plugin/xcforumtagtothread', 'uncheck');
$plugin_run=lang('plugin/xcforumtagtothread', 'ischeck');
$plugin_createtimes=lang('plugin/xcforumtagtothread', 'createtimes');
$plugin_add=lang('plugin/xcforumtagtothread', 'add');
$plugin_submit_fail=lang('plugin/xcforumtagtothread','submit_fail');
$plugin_title_invalid=lang('plugin/xcforumtagtothread','title_invalid');
$plugin_titles_invalid=lang('plugin/xcforumtagtothread','titles_invalid');
$plugin_url_invalid=lang('plugin/xcforumtagtothread','url_invalid');
$plugin_back=lang('plugin/xcforumtagtothread','back');
$plugin_edit=lang('plugin/xcforumtagtothread','edits');
$pnum = empty($_GET['pagenum']) ? 20 : $_GET['pagenum'];
$page = empty($_GET['page']) ? 1 : $_GET['page'];
$do=$_GET['do'];
$pmods=$_GET['pmod'];
$operation = !empty($_GET['subconfig']) ? $_GET['subconfig'] : 'list';
if ($pmods=='managekwforum') {
    $kwlist=DB::fetch_all('select * from %t where status=0',array('xc_tagkeywords'));
    if ($operation=='list'){
        if(!submitcheck('editsubmit')) {
            showtagheader('div', 'vars', 'vars');
            showformheader("plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum&subconfig=list", '', 'varsform');
            showtableheader($plugin_setname.$plugin_setmore);
            showsubtitle(array('', $plugin_title,$plugin_cattitle,$plugin_setname,$plugin_num));
            $start_limit = ($page - 1) * $pnum;
            $listcount=DB::result_first('SELECT COUNT(*) FROM %t  ', array('xc_kwforum'));
            if ($listcount) {
                $multipage = multi($listcount, $pnum, $page, ADMINSCRIPT."?action=plugins&operation=config&do=10&identifier=xcforumtagtothread&pmod=managekwforum&pagenum=$pnum", 0, 3);
                $lists=DB::fetch_all('select a.vid,a.fid,a.kid,b.name,a.title,a.ordernum from %t a left join %t b on a.fid=b.fid  order by a.fid desc'.DB::limit($start_limit, $pnum),array('xc_kwforum','forum_forum'));
                foreach($lists as $var) {
                    showtablerow('', array('class="td25"', 'class="td28"'), array(
                        "<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$var[vid]\">",
                        $var['name'],
                        $var['title'],
                       getkwname($kwlist, $var['kid']),
                        $var['ordernum'],
                        "<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum&subconfig=edit&formid=$var[vid]\" class=\"act\">$plugin_edit</a>"
                    ));
                }
            }
            showsubmit('editsubmit', 'submit', 'del','<a href='.ADMINSCRIPT.'?action=plugins&operation=config&do='.$do.'&identifier='.$_GET['identifier'].'&pmod=managekwforum&subconfig=add> <input type="button" class="btn" id="addsubmit" name="addsubmit"  value='.$plugin_add.'></a>',$multipage);
            showtablefooter();
            showformfooter();
            showtagfooter('div');
        }else {
            if(is_array($_GET['delete'])) {
                DB::delete('xc_kwforum', DB::field('vid', $_GET['delete']));
            }
            cpmsg('plugins_edit_succeed', "action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum", 'succeed');
        }
    }elseif ($operation=='add'){
        if(!submitcheck('addsubmit')) {
            $selgroup=getcatlist(0);
            $url="plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum&subconfig=add";
            showformheader($url,'enctype');
            showtableheader();
            showsetting($plugin_title, '', '', "<select name=\"title\">".$selgroup."</select>",'',0);
            showsetting($plugin_cattitle, 'titles', '', 'text','',0);
            showsetting($plugin_setname, array('psptime',$kwlist), '','mcheckbox');
            showsetting($plugin_num, 'ordernum', 0, "number",'',0);
            showtagfooter('tbody');
            showsubmit('addsubmit','submit','','<a href='.ADMINSCRIPT.'?action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum&subconfig=list> <input type="button" class="btn" id="addsubmit" name="addsubmit"  value='.$plugin_back.'></a>');
            showtablefooter();
            showformfooter();
        }else {
            global $_G;
            $bgpicture="";
            if (empty($_GET['title'])) {
                cpmsg($plugin_title_invalid, '', 'error');
            }
            if (empty($_GET['titles'])) {
                cpmsg($plugin_titles_invalid, '', 'error');
            }
            if (empty($_GET['psptime'])) {
                cpmsg($plugin_url_invalid, '', 'error');
            }
            $data = array(
                'fid' => $_GET['title'],
                'title' => $_GET['titles'],
                'ordernum' => $_GET['ordernum'],
                'kid' =>  implode(',', $_GET['psptime']) ,
            );
            DB::insert('xc_kwforum',$data);
            cpmsg('plugins_edit_succeed', "action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum", 'succeed');
        }
    }elseif ($operation=='edit'){
        if(!submitcheck('editsubmit')) {
            $bgauto=DB::fetch_first('select * from %t where vid=%d',array('xc_kwforum',$_GET['formid']));
            $selgroup=getcatlist($bgauto['fid']);
            $url="plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum&subconfig=edit&fromid=".$_GET['formid'];
            showformheader($url,'enctype');
            showtableheader();
            showsetting($plugin_title, '', '', "<select name=\"title\">".$selgroup."</select>",'',0);
            showsetting($plugin_cattitle, 'titles', $bgauto['title'], 'text','',0);
            showsetting($plugin_setname, array('psptime',$kwlist),explode(',',$bgauto['kid']) ,'mcheckbox');
            showsetting($plugin_num, 'ordernum', $bgauto['ordernum'], "number",'',0);
            showtagfooter('tbody');
            showsubmit('editsubmit','submit','','<a href='.ADMINSCRIPT.'?action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum&subconfig=list> <input type="button" class="btn" id="addsubmit" name="addsubmit"  value='.$plugin_back.'></a>');
            showtablefooter();
            showformfooter();
        }else {
            global $_G;
            if (empty($_GET['title'])) {
                cpmsg($plugin_title_invalid, '', 'error');
            }
            if (empty($_GET['titles'])) {
                cpmsg($plugin_titles_invalid, '', 'error');
            }
            if (empty($_GET['psptime'])) {
                cpmsg($plugin_url_invalid, '', 'error');
            }
            $data = array(
                'fid' => $_GET['title'],
                'title' => $_GET['titles'],
                'ordernum' => $_GET['ordernum'],
                'kid' =>  implode(',', $_GET['psptime']) ,
            );
            DB::update('xc_kwforum',$data,array('vid'=>$_GET['fromid']));
            cpmsg('plugins_edit_succeed', "action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekwforum", 'succeed');
        }
    }
}
function getcatlist($selectid){
    global $_G;
    $plugin_num_invalid=lang('plugin/xcforumtagtothread','url_invalid');
    $grouplist=DB::fetch_all("SELECT name,fid FROM %t where type='forum' and status=1",array('forum_forum'));
    $selgroup="<option value=0>".$plugin_num_invalid."</option>";
    foreach ($grouplist as $key=>$items){
        $selgroup.= "<option value=".$items['fid']." ".($items['fid']==$selectid?'selected':'').">".$items['name']."</option>";
    }
    return $selgroup;
}
function  getkwname($kwlists,$idlist){
    $idlists=explode(',', $idlist);
    foreach ($kwlists as $key=>$item){
        if (in_array($item['kid'], $idlists)) {
            $returnvalue.=$item['kwtitle'].',';
        }
    }
    return  $returnvalue;
}
?>