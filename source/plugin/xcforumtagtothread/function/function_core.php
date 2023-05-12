<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function xc_xcforumtagtothread_updatecache($isexit=0){
	global $_G;
	$isgbk=false;
	if (strtolower($_G['charset'])=='gbk'||strtolower($_G['charset'])=='big5') {
		$isgbk=true;
	}
    $kwlist=DB::fetch_all('select * from %t where status=0',array('xc_tagkeywords'));
    $lists=DB::fetch_all('select fid,kid,title,ordernum,vid from %t order by ordernum desc',array('xc_kwforum'));
    $strvalue=array();
	if($isgbk){
		foreach ($lists as $k =>  $items){
			$strvalue[$k]=array('fid'=>$items['fid'],'title'=>mb_convert_encoding($items['title'],'utf-8','gbk'),'ordernum'=>$items['vid'],'kw'=> getkwname($kwlist, $items['kid']));
		}
	}else{
		foreach ($lists as $k =>  $items){
			$strvalue[$k]=array('fid'=>$items['fid'],'title'=>$items['title'],'ordernum'=>$items['vid'],'kw'=> getkwmorename($kwlist, $items['kid']));
		}
	}
	//print_r($strvalue);
    require_once libfile('function/cache');
	$data=array('xcrecom'=>json_encode($strvalue));
    $cachename='xcforumtagtothread';
    savecache($cachename, $data);
    if ($isexit==1) {
        return $data;
    }
}

function xc_xcforumtagtothread_getcache(){
    global $_G;
    require_once libfile('function/cache');
    $cachename='xcforumtagtothread';
    loadcache($cachename);
    if (empty($_G['cache'][$cachename]['xcrecom'])) {
        $dts= xc_xcforumtagtothread_updatecache(1);
        $dts=$dts['xcrecom'];
    }else {
        $dts=$_G['cache'][$cachename]['xcrecom'];
    }
	
	 if (strtolower($_G['charset'])=='gbk'||strtolower($_G['charset'])=='big5') {
        $arr=json_decode($dts,true);
        $list=array();
        foreach($arr as $k=>$item){
            $list[$k]['fid']=$item['fid'];
            $list[$k]['title']=charsetToGBK($item['title']);
            $list[$k]['ordernum']=$item['ordernum'];
            $list[$k]['kw']=charsetToGBK($item['kw']);
        }
        return $list;
    } 
    return json_decode($dts,true);
}
function  getkwname($kwlists,$idlist){
    $idlists=explode(',', $idlist);
    foreach ($kwlists as $key=>$item){
        if (in_array($item['kid'], $idlists)) {
            $returnvalue[]=mb_convert_encoding($item['kwtitle'],'utf-8','gbk');
        }
    }
    return  $returnvalue;
}

function  getkwmorename($kwlists,$idlist){
    $idlists=explode(',', $idlist);
    foreach ($kwlists as $key=>$item){
        if (in_array($item['kid'], $idlists)) {
            $returnvalue[]=$item['kwtitle'];
        }
    }
    return  $returnvalue;
}

function charsetToGBK($mixed)
{
    if (is_array($mixed)) {
        foreach ($mixed as $k => $v) {
            if (is_array($v)) {
                $mixed[$k] = charsetToGBK($v);
            } else {
                $encode = mb_detect_encoding($v, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
                if ($encode == 'UTF-8') {
                    $mixed[$k] = iconv('UTF-8', 'GBK', $v);
                }
            }
        }
    } else {
        $encode = mb_detect_encoding($mixed, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
        //var_dump($encode);
        if ($encode == 'UTF-8') {
            $mixed = iconv('UTF-8', 'GBK', $mixed);
        }
    }
    return $mixed;
}

?>