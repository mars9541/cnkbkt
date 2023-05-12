<?php
if(!defined('IN_DISCUZ')||!defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$plugin_setname=lang('plugin/xcforumtagtothread', 'plugin');
$plugin_title=lang('plugin/xcforumtagtothread', 'mtitle');
$plugin_num=lang('plugin/xcforumtagtothread', 'ordernum');
$plugin_setmore=lang('plugin/xcforumtagtothread', 'pluginmore');
$plugin_status=lang('plugin/xcforumtagtothread', 'status');
$plugin_stop=lang('plugin/xcforumtagtothread', 'uncheck');
$plugin_run=lang('plugin/xcforumtagtothread', 'ischeck');
$plugin_createtimes=lang('plugin/xcforumtagtothread', 'createtimes');
$plugin_add=lang('plugin/xcforumtagtothread', 'add');
$plugin_submit_fail=lang('plugin/xcforumtagtothread','submit_fail');
$plugin_title_invalid=lang('plugin/xcforumtagtothread','key_invalid');
$plugin_num_invalid=lang('plugin/xcforumtagtothread','url_invalid');
$plugin_back=lang('plugin/xcforumtagtothread','back');
$plugin_edit=lang('plugin/xcforumtagtothread','edits');
$pnum = empty($_GET['pagenum']) ? 20 : $_GET['pagenum'];
$page = empty($_GET['page']) ? 1 : $_GET['page'];
$do=$_GET['do'];
$pmods=$_GET['pmod'];
$operation = !empty($_GET['subconfig']) ? $_GET['subconfig'] : 'list';
if ($pmods=='managekeyword') {
    if ($operation=='list'){
        if(!submitcheck('editsubmit')) {
            showtagheader('div', 'vars', 'vars');
            showformheader("plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword&subconfig=list", '', 'varsform');
            showtableheader($plugin_setname.$plugin_setmore);
            showsubtitle(array('', $plugin_title,$plugin_logo,$plugin_url,$plugin_status,$plugin_createtimes,$plugin_num,));
            $start_limit = ($page - 1) * $pnum;
            $listcount=DB::result_first('SELECT COUNT(*) FROM %t  ', array('xc_tagkeywords'));
            if ($listcount) {
                $multipage = multi($listcount, $pnum, $page, ADMINSCRIPT."?action=plugins&operation=config&do=10&identifier=xcforumtagtothread&pmod=managekeyword&pagenum=$pnum", 0, 3);
                $lists=DB::fetch_all('select * from %t   order by ordernum desc,createtime desc'.DB::limit($start_limit, $pnum),array('xc_tagkeywords'));
                foreach($lists as $var) {
                    showtablerow('', array('class="td25"', 'class="td28"'), array(
                        "<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$var[kid]\">",
                        $var['kwtitle'],
                        $var['isecheck']==0?$plugin_run:$plugin_stop,
                        dgmdate($var['createtime'],'dt'),
                        $var['ordernum'],
                        "<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword&subconfig=edit&formid=$var[kid]\" class=\"act\">$plugin_edit</a>"
                    ));
                }
            }
            showsubmit('editsubmit', 'submit', 'del','<a href='.ADMINSCRIPT.'?action=plugins&operation=config&do='.$do.'&identifier='.$_GET['identifier'].'&pmod=managekeyword&subconfig=add> <input type="button" class="btn" id="addsubmit" name="addsubmit"  value='.$plugin_add.'></a>',$multipage);
            showtablefooter();
            showformfooter();
            showtagfooter('div');
        }else {
            if(is_array($_GET['delete'])) {
                DB::delete('xc_tagkeywords', DB::field('kid', $_GET['delete']));
            }
            cpmsg('plugins_edit_succeed', "action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword", 'succeed');
        }
    }elseif ($operation=='add'){
        if(!submitcheck('addsubmit')) {
            $url="plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword&subconfig=add";
            showformheader($url,'enctype');
            showtableheader();
            showsetting($plugin_title, 'title', '', 'text','',0);
            showsetting($plugin_num, 'num', 0, "number",'',0);
            showsetting($plugin_status,  array('status',array(array(1,$plugin_stop),array(0,$plugin_run)),'showinvite'),0,'mradio','',0);
            showtagfooter('tbody');
            showsubmit('addsubmit','submit','','<a href='.ADMINSCRIPT.'?action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword&subconfig=list> <input type="button" class="btn" id="addsubmit" name="addsubmit"  value='.$plugin_back.'></a>');
            showtablefooter();
            showformfooter();
        }else {
            global $_G;
            $bgpicture="";
            if (empty($_GET['title'])) {
                cpmsg($plugin_title_invalid, '', 'error');;
            }
            $data = array(
                'kwtitle' => $_GET['title'],
                'ordernum' => $_GET['num'],
                'status' => $_GET['status'],
                'createtime' => time(),
            );
            DB::insert('xc_tagkeywords',$data);
            cpmsg('plugins_edit_succeed', "action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword", 'succeed');
        }
    }elseif ($operation=='edit'){
        if(!submitcheck('editsubmit')) {
            $bgauto=DB::fetch_first('select * from %t where kid=%d',array('xc_tagkeywords',$_GET['formid']));
            $url="plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword&subconfig=edit&fromid=".$_GET['formid'];
            showformheader($url,'enctype');
            showtableheader();
            showsetting($plugin_title, 'title', $bgauto['kwtitle'], 'text','',0);
            showsetting($plugin_num, 'num', $bgauto['ordernum'], "number",'',0);
            showsetting($plugin_status,  array('status',array(array(1,$plugin_stop),array(0,$plugin_run)),'showinvite'),$bgauto['status'],'mradio','',0);
            showtagfooter('tbody');
            showsubmit('editsubmit','submit','','<a href='.ADMINSCRIPT.'?action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword&subconfig=list> <input type="button" class="btn" id="addsubmit" name="addsubmit"  value='.$plugin_back.'></a>');
            showtablefooter();
            showformfooter();
        }else {
            global $_G;
            if (empty($_GET['title'])) {
                cpmsg($plugin_title_invalid, '', 'error');;
            }
            $data = array(
                'kwtitle' => $_GET['title'],
                'ordernum' => $_GET['num'],
                'status' => $_GET['status'],
                'createtime' => time(),
            );
            DB::update('xc_tagkeywords',$data,array('kid'=>$_GET['fromid']));
            cpmsg('plugins_edit_succeed', "action=plugins&operation=config&identifier=xcforumtagtothread&pmod=managekeyword", 'succeed');
        }
    }
}
?>