<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); 
0
|| checktplrefresh('./template/elec_20220314_miaoly/common/header.htm', './template/elec_20220314_miaoly/common/header_common.htm', 1677554256, '2', './data/template/2_2_common_header_misc_stat.tpl.php', './template/elec_20220314_miaoly', 'common/header_misc_stat')
|| checktplrefresh('./template/elec_20220314_miaoly/common/header.htm', './template/elec_20220314_miaoly/common/pubsearchform.htm', 1677554256, '2', './data/template/2_2_common_header_misc_stat.tpl.php', './template/elec_20220314_miaoly', 'common/header_misc_stat')
|| checktplrefresh('./template/elec_20220314_miaoly/common/header.htm', './template/default/common/header_qmenu.htm', 1677554256, '2', './data/template/2_2_common_header_misc_stat.tpl.php', './template/elec_20220314_miaoly', 'common/header_misc_stat')
;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">


<head>


    <meta http-equiv="X-UA-Compatible" content="IE=edge">


<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />


<?php if($_G['config']['output']['iecompatible']) { ?><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE<?php echo $_G['config']['output']['iecompatible'];?>" /><?php } ?>


<title><?php if(!empty($navtitle)) { ?><?php echo $navtitle;?> - <?php } if(empty($nobbname)) { ?> <?php echo $_G['setting']['bbname'];?> - <?php } ?> Powered by Discuz!</title>


<?php echo $_G['setting']['seohead'];?>





<meta name="keywords" content="<?php if(!empty($metakeywords)) { echo dhtmlspecialchars($metakeywords); } ?>" />


<meta name="description" content="<?php if(!empty($metadescription)) { echo dhtmlspecialchars($metadescription); ?> <?php } if(empty($nobbname)) { ?>,<?php echo $_G['setting']['bbname'];?><?php } ?>" />


<meta name="generator" content="Discuz! <?php echo $_G['setting']['version'];?>" />


<meta name="author" content="Discuz! Team and Comsenz UI Team" />


<meta name="copyright" content="2001-2013 Comsenz Inc." />


<meta name="MSSmartTagsPreventParsing" content="True" />


<meta http-equiv="MSThemeCompatible" content="Yes" />


<base href="<?php echo $_G['siteurl'];?>" /><link rel="stylesheet" type="text/css" href="data/cache/style_2_common.css?<?php echo VERHASH;?>" /><link rel="stylesheet" type="text/css" href="data/cache/style_2_misc_stat.css?<?php echo VERHASH;?>" /><?php if($_G['uid'] && isset($_G['cookie']['extstyle']) && strpos($_G['cookie']['extstyle'], TPLDIR) !== false) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['cookie']['extstyle'];?>/style.css" /><?php } elseif($_G['style']['defaultextstyle']) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['style']['defaultextstyle'];?>/style.css" /><?php } ?><script type="text/javascript">var STYLEID = '<?php echo STYLEID;?>', STATICURL = '<?php echo STATICURL;?>', IMGDIR = '<?php echo IMGDIR;?>', VERHASH = '<?php echo VERHASH;?>', charset = '<?php echo CHARSET;?>', discuz_uid = '<?php echo $_G['uid'];?>', cookiepre = '<?php echo $_G['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_G['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_G['config']['cookie']['cookiepath'];?>', showusercard = '<?php echo $_G['setting']['showusercard'];?>', attackevasive = '<?php echo $_G['config']['security']['attackevasive'];?>', disallowfloat = '<?php echo $_G['setting']['disallowfloat'];?>', creditnotice = '<?php if($_G['setting']['creditnotice']) { ?><?php echo $_G['setting']['creditnames'];?><?php } ?>', defaultstyle = '<?php echo $_G['style']['defaultextstyle'];?>', REPORTURL = '<?php echo $_G['currenturl_encode'];?>', SITEURL = '<?php echo $_G['siteurl'];?>', JSPATH = '<?php echo $_G['setting']['jspath'];?>', CSSPATH = '<?php echo $_G['setting']['csspath'];?>', DYNAMICURL = '<?php echo $_G['dynamicurl'];?>';</script>


<script src="<?php echo $_G['setting']['jspath'];?>common.js?<?php echo VERHASH;?>" type="text/javascript"></script>


    <script src="template/elec_20220314_miaoly/style/js/jquery.min.js" type="text/javascript"></script>


<?php if(empty($_GET['diy'])) { $_GET['diy'] = '';?><?php } if(!isset($topic)) { $topic = array();?><?php } ?>



<meta name="application-name" content="<?php echo $_G['setting']['bbname'];?>" />
<meta name="msapplication-tooltip" content="<?php echo $_G['setting']['bbname'];?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

<?php if($_G['setting']['portalstatus']) { ?>
<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['1']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['portal']) ? 'http://'.$_G['setting']['domain']['app']['portal'] : $_G['siteurl'].'portal.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/portal.ico" />
<?php } ?>

<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['2']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['forum']) ? 'http://'.$_G['setting']['domain']['app']['forum'] : $_G['siteurl'].'forum.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/bbs.ico" />

<?php if($_G['setting']['groupstatus']) { ?>
<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['3']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['group']) ? 'http://'.$_G['setting']['domain']['app']['group'] : $_G['siteurl'].'group.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/group.ico" />
<?php } if(helper_access::check_module('feed')) { ?>
<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['4']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['home']) ? 'http://'.$_G['setting']['domain']['app']['home'] : $_G['siteurl'].'home.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/home.ico" />
<?php } if($_G['basescript'] == 'forum' && $_G['setting']['archiver']) { ?>

<link rel="archives" title="<?php echo $_G['setting']['bbname'];?>" href="<?php echo $_G['siteurl'];?>archiver/" />

<?php } if(!empty($rsshead)) { ?>
<?php echo $rsshead;?><?php } if(widthauto()) { ?>

<link rel="stylesheet" id="css_widthauto" type="text/css" href='<?php echo $_G['setting']['csspath'];?><?php echo STYLEID;?>_widthauto.css?<?php echo VERHASH;?>' />
<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>

<?php } if($_G['basescript'] == 'forum' || $_G['basescript'] == 'group') { ?>

<script src="<?php echo $_G['setting']['jspath'];?>forum.js?<?php echo VERHASH;?>" type="text/javascript"></script>

<?php } elseif($_G['basescript'] == 'home' || $_G['basescript'] == 'userapp') { ?>

<script src="<?php echo $_G['setting']['jspath'];?>home.js?<?php echo VERHASH;?>" type="text/javascript"></script>

<?php } elseif($_G['basescript'] == 'portal') { ?>

<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>

<?php } if($_G['basescript'] != 'portal' && $_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>

<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>

<?php } if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>

<link rel="stylesheet" type="text/css" id="diy_common" href="<?php echo $_G['setting']['csspath'];?><?php echo STYLEID;?>_css_diy.css?<?php echo VERHASH;?>" />

<?php } ?>

</head><body id="nv_<?php echo $_G['basescript'];?>" class="pg_<?php echo CURMODULE;?><?php if($_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)) { ?> <?php echo $cat['bodycss'];?><?php } ?>" onkeydown="if(event.keyCode==27) return false;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>

<?php if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?> <?php include template('common/header_diy'); ?> 

<?php } ?> 

<?php if(check_diy_perm($topic)) { ?> <?php include template('common/header_diynav'); ?> 

<?php } ?> 

<?php if(CURMODULE == 'topic' && $topic && empty($topic['useheader']) && check_diy_perm($topic)) { ?> 

<?php echo $diynav;?> 

<?php } ?> 

<?php if(empty($topic) || $topic['useheader']) { ?> 

<?php if($_G['setting']['mobile']['allowmobile'] && (!$_G['setting']['cacheindexlife'] && !$_G['setting']['cachethreadon'] || $_G['uid']) && ($_GET['diy'] != 'yes' || !$_GET['inajax']) && ($_G['mobile'] != '' && $_G['cookie']['mobile'] == '' && $_GET['mobile'] != 'no')) { ?>

<div class="xi1 bm bm_c"> 请选择 <a href="<?php echo $_G['siteurl'];?>forum.php?mobile=yes">进入手机版</a> <span class="xg1">|</span> <a href="<?php echo $_G['setting']['mobile']['nomobileurl'];?>">继续访问电脑版</a> </div>

<?php } ?> 

<?php if($_G['setting']['shortcut'] && $_G['member']['credits'] >= $_G['setting']['shortcut']) { ?>

<div id="shortcut"> <span><a href="javascript:;" id="shortcutcloseid" title="关闭">关闭</a></span> 您经常访问 <?php echo $_G['setting']['bbname'];?>，试试添加到桌面，访问更方便！ <a href="javascript:;" id="shortcuttip">添加 <?php echo $_G['setting']['bbname'];?> 到桌面</a> </div>
<script type="text/javascript">setTimeout(setShortcut, 2000);</script>

<?php } ?> 

<style type="text/css">
#nv_vip #pt { display: none}
#nv_vip .mn { float: none !important; margin: 0 auto; margin-top: 20px; margin-bottom: 30px}
#nv_vip .sd { display: none}
#nv_vip #ct { border: 0}
#nv_vip .tb { padding: 0; border-bottom: 0}
#nv_vip .tb a { padding: 2px 15px; margin: 0; border: 0; font-size: 15px; background: none}
#nv_vip .tb li:last-child a { margin: 0}
#nv_vip .tb .a a { color: #FFFFFF; font-weight: 400; background: #FF6651; border-radius: 3px}
#nv_vip .orights p { padding-bottom: 10px; border-bottom: 1px dashed #EEEEEE}
#nv_vip .btn, #nv_vip .btn span { background: #999999 !important; border-radius: 3px}
#nv_vip .pay { border-radius: 3px}

.header1 .menu ul li a { font-family: 'Microsoft Yahei','Helvetica Neue',Helvetica,Arial,sans-serif}
#scbar_type_menu { left: 0 !important}
.nfl .f_c { width: 466px; padding: 20px 0 0 0}
#messagelogin .flb { padding-left: 40px}
.unchk { background-position: 0 4px}
.chked { background-position: 0 -36px}
.focusbox {
    text-align: center;
    background-color: #384047;
    color: #eee;
    padding: 45px 0;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
}
.focusbox .focusbox-title {
    font-weight: normal;
    font-size: 21px;
    margin: 0;
font-family: 'Microsoft Yahei','Helvetica Neue',Helvetica,Arial,sans-serif
}
.focusbox .wp { width: 100%}
.footer-main, .footer-main a { font-size: 12px; color: #BBBBBB}
.pbg { height: 10px; overflow: hidden; background: #F3F3F3}
.pbr { overflow: hidden; background: #5AAF4A !important}
.pm_o { width: auto !important}
#nv_home .ct2_a .mn .tb li.y a { padding-right: 20px !important}
.miao_list li { float: left; position: relative !important; left: auto !important; top: auto !important; width: 18.5%; margin: 0 1.875% 2.5% 0; overflow: hidden}
.miao_list li:nth-child(5n) { margin: 0 0 30px 0}
.miao_list .info_box { font-family: 'Microsoft Yahei','Helvetica Neue',Helvetica,Arial,sans-serif}
.miao_list h3 { height: 42px; line-height: 21px; overflow: hidden}
.miao_list h3 a { font-size: 15px; color: #555555; font-weight: bold}
.miao_list .img_box { display: block; margin-bottom: 10px; overflow: hidden}
.miao_list .time { color: #BBBBBB; margin-top: 8px}
.xh-btn {
    box-shadow: 0 1px 2px rgb(0 0 0 / 10%);
    display: inline-block;
    margin-bottom: 0;
    font-weight: 400;
    text-align: center;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.5;
    border-radius: 3px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.xh-btn-sm {
    padding: 4px 16px;
margin: 0 5px;
    font-size: 14px;
    line-height: 1.33;
    border-radius: 3px;
}
.xh-btn-warning {
    color: #fff;
    background-color: #f0ad4e;
    border-color: #eea236;
}
a.xh-btn:link {
    text-decoration: none;
    color: #fff;
}
@media (max-width: 1200px) {
.section { width: 94%; margin: 0 auto}
.section .wp { width: 100% !important}
#ct { width: 94% !important}
.searchform { padding: 0 !important}
#nv_search .ptw { padding-top: 0 !important}
#nv_search #scform, #nv_search #scform_form { width: 100% !important}
#nv_search .td_srchtxt { width: 80% !important; box-sizing: border-box}
#nv_search .td_srchbtn { width: 20% !important; box-sizing: border-box}
#nv_search .slst { width: 100% !important}
.tl .th .by { display: block !important}
#atarget { display: none}
.thread_rec { display: block !important}
.th .tf a#filter_dateline { display: none}
.focusbox { padding: 4% 0 !important}
.focusbox .focusbox-title { padding: 0 3%; font-size: 18px !important}
#nv_vip .mn { width: 100% !important}
#nv_vip .tb a { padding: 0 10px; font-size: 13px}
.vipindex, .orights { border: 1px solid #E3E3E3; border-radius: 3px; background: none}
.vipindex .title, .orights h3.title, .orights { background: none}
.vipindex .content, .vipblock .content { border: 0}
.sright { display: none}
.orights h3.title { padding-left: 25px; line-height: 48px}
.orights li { width: 50%}
.pay ul li span { width: 120px}
.pay_btn { padding-left: 120px}
}
@media (max-width: 1000px) {
.miao_list li { float: left; width: 23.5% !important; margin: 0 2% 2.5% 0 !important; overflow: hidden}
.miao_list li:nth-child(5n) { margin: 0 2% 2.5% 0 !important}
.miao_list li:nth-child(4n) { margin: 0 0 2.5% 0 !important}
.miao_list .img_box { height: 320px; overflow: hidden}
.miao_list .img_box img { height: 320px !important}
}
@media (max-width: 700px) {
.miao_list li { float: left; width: 32% !important; margin: 0 2% 2.5% 0 !important; overflow: hidden}
.miao_list li:nth-child(5n) { margin: 0 2% 2.5% 0 !important}
.miao_list li:nth-child(4n) { margin: 0 2% 2.5% 0 !important}
.miao_list li:nth-child(3n) { margin: 0 0 2.5% 0 !important}
.miao_list .img_box { height: 300px; overflow: hidden}
.miao_list .img_box img { height: 300px !important}
}
@media (max-width: 520px) {
.miao_list li { float: left; width: 48% !important; margin: 0 4% 2.5% 0 !important; overflow: hidden}
.miao_list li:nth-child(5n) { margin: 0 4% 2.5% 0 !important}
.miao_list li:nth-child(4n) { margin: 0 4% 2.5% 0 !important}
.miao_list li:nth-child(3n) { margin: 0 4% 2.5% 0 !important}
.miao_list li:nth-child(2n) { margin: 0 0 2.5% 0 !important}
.miao_list .img_box { height: 320px; margin-bottom: 0 !important; overflow: hidden}
.miao_list .img_box img { min-height: 320px; height: auto !important}
.miao_list h3 { height: 21px !important}
.miao_list h3 a { font-size: 12px !important}
.info_box { padding: 10px ; border: 1px solid #F4F4F4; border-top: 0}
}
@media (max-width: 1200px) {
#fwin_login.fwinmask { top: 78px !important; left: 5% !important; margin: 0 !important}
.flb { padding: 20px !important}
.phone_box1 { padding: 0 20px !important}
#fwin_login.fwinmask { width: 90% !important; background: #FFFFFF}
#fwin_content_login { width: 100% !important}
.fwin .rfm, .nfl .f_c .rfm, .rfm .px1 { width: 100% !important; box-sizing: border-box}
#fwin_login.fwinmask table { width: 100% !important}
.flbc { right: 20px !important; top: 20px !important}
.login_pn { height: 36px !important; line-height: 36px !important; margin: 0 !important; font-size: 15px !important}
.member_boxx1 { margin: 20px 0 !important}
.rfm table { width: 100% !important}
.rfm { width: 100% !important}
.rfm th { width: 30% !important}
.rfm .px { width: 60% !important}
.fwin .rfm .px { width: 100% !important}
.tipcol { display: none !important}
}
</style><?php echo adshow("headerbanner/wp a_h");?><link rel="stylesheet" type="text/css" id="time_diy" href="template/elec_20220314_miaoly/style/css/style.css" />
<div class="header1 cl" style="position: relative;">
      <div id="body_overlay" style="display: none;"></div>
            <script type="text/javascript">
      jQuery(document).ready(function(jQuery) {
jQuery('.m_menu').click(function(){
jQuery('#body_overlay').fadeIn(50);
jQuery('.icon-cancel-fine').fadeIn(50);
})
jQuery('.icon-cancel-fine').click(function(){
jQuery('#body_overlay').fadeOut(50);
jQuery('.icon-cancel-fine').fadeOut(50);
})
jQuery('#body_overlay').click(function(){
jQuery('#body_overlay').fadeOut(50);
jQuery('.icon-cancel-fine').fadeOut(50);
})

})
    </script>
      <div class="elecom_navigate menu">
        <ul>
          
          <?php if(is_array($_G['setting']['navs'])) foreach($_G['setting']['navs'] as $nav) { ?> 
          
          <?php if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?>
          
          <li <?php echo $nav['nav'];?>>
          <i></i>
          </li>
          
          <?php } ?> 
          
          <?php } ?>
          <?php if($_G['uid']) { ?>
          <li><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出登录</a></li>
          <?php } else { ?>
          <?php } ?>
        </ul>
        
        <?php if(!empty($_G['setting']['pluginhooks']['global_nav_extra'])) echo $_G['setting']['pluginhooks']['global_nav_extra'];?> 
        
      </div>
</div>
<div style="width: 100%; background: #FFFFFF;" class="tpboxx1 cl">
<div class="wp cl">
  <div class="headerx">
   <div class="section">
      <!-- 站点LOGO -->
      <div class="logo">
        <?php $mnid = getcurrentnav();?>        <h2><?php if(!isset($_G['setting']['navlogos'][$mnid])) { ?><a href="<?php if($_G['setting']['domain']['app']['default']) { ?>http://<?php echo $_G['setting']['domain']['app']['default'];?>/<?php } else { ?>./<?php } ?>" title="<?php echo $_G['setting']['bbname'];?>"><img src="template/elec_20220314_miaoly/style/logo.png"></a><?php } else { ?><img src="template/elec_20220314_miaoly/style/logo.png"><?php } ?></h2>
      </div>
      <a href="search.php?mod=forum" style="position: absolute; right: 15%; top: 19px;"><img src="template/elec_20220314_miaoly/style/search.svg" style="width: 20px; height: 20px;"></a>
      <div class="m_menu"><em></em><em></em><em></em></div>
      <script type="text/javascript">
      jQuery(".m_menu").click(function(){

jQuery('.elecom_navigate').addClass("on");

})
jQuery(".icon-cancel-fine").click(function(){

jQuery('.elecom_navigate').removeClass("on");

})
jQuery("#body_overlay").click(function(){

jQuery('.elecom_navigate').removeClass("on");

})
    </script>
</div>
</div>
</div>
</div>
<div class="wp cl" style="position: relative;">
<div class="wx_show cl" style="width: 360px;
    height: 380px;
    padding: 0;
    margin: 0 auto;
    margin-left: 360px;
    background: #FFF;
    position: fixed;
    top: 150px;
    display: none;
    z-index: 999;
    border: 0;
    border-top: 0;
    box-shadow: none;">
    <div class="cl">
    <img src="template/elec_20220314_miaoly/style/wxshow.png" style="float: left; margin: 50px 0 0 50px;">
    </div>
    <div class="cl" style="display: block; width: 100%; text-align: center; padding-top: 15px;">
    <a style="font-size: 16px; color: red; text-align: center;">扫码查看手机版</a>
    </div>
</div>
</div>
      <div class="search_bg1" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0px; z-index: 300;"></div>
      <script type="text/javascript">


      jQuery(document).ready(function(jQuery) {


jQuery('.layui-icon').click(function(){


jQuery('.search_bg1').fadeIn(200);


jQuery('.wx_show').fadeIn(300);


})


jQuery('.search_bg1').click(function(){


jQuery('.search_bg1').fadeOut(50);


jQuery('.wx_show').fadeOut(300);


})





})


    </script>
<div id="elecom_nav">

  <div class="wp cl">

  <?php if(!empty($_G['setting']['pluginhooks']['global_cpnav_top'])) echo $_G['setting']['pluginhooks']['global_cpnav_top'];?>

  <?php if(!empty($_G['setting']['pluginhooks']['global_cpnav_extra1'])) echo $_G['setting']['pluginhooks']['global_cpnav_extra1'];?>

  <?php if(!empty($_G['setting']['pluginhooks']['global_cpnav_extra2'])) echo $_G['setting']['pluginhooks']['global_cpnav_extra2'];?>

  </div>

  <div class="l_box cl" style="padding: 0;">

   <div class="wp cl">

     <!-- 站点LOGO -->

      <div class="navbar-header"> 

         <?php $mnid = getcurrentnav();?> <h2><?php if(!isset($_G['setting']['navlogos'][$mnid])) { ?><a href="<?php if($_G['setting']['domain']['app']['default']) { ?>http://<?php echo $_G['setting']['domain']['app']['default'];?>/<?php } else { ?>./<?php } ?>" title="<?php echo $_G['setting']['bbname'];?>"><?php echo $_G['style']['boardlogo'];?></a><?php } else { ?><?php echo $_G['setting']['navlogos'][$mnid];?><?php } ?></h2>

      </div>

      <!-- 导航 -->

      <div class="navigate">

        <ul>

          <?php if(is_array($_G['setting']['navs'])) foreach($_G['setting']['navs'] as $nav) { ?> 

          <?php if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?>

          <li <?php if($mnid == $nav['navid']) { ?>class="a" <?php } ?>

        <?php if(!empty($subnavs)) { ?>class="b" <?php } ?>

        <?php echo $nav['nav'];?>>

          </li>

          <?php } ?> 

          <?php } ?>

        </ul>

        <?php if(!empty($_G['setting']['pluginhooks']['global_nav_extra'])) echo $_G['setting']['pluginhooks']['global_nav_extra'];?> 

      </div>

      

      <div style="display: none; float: right;"><?php include template('member/login_simple'); ?></div>

      <!-- 用户信息 --> 

      <?php if($_G['uid']) { ?>

      <div class="elecom_user logined">

        <div class="elecom_user_info">

          <div class="user-main ">

            <div class="avatar"> <a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" target="_blank" title="访问我的空间" id="umnav" onMouseOver="showMenu({'ctrlid':this.id,'ctrlclass':'a'})"> 

              <?php echo avatar($_G[uid],small);?>              </a><?php if($_G['member']['newprompt']) { ?><span class="unread_num png"><?php echo $_G['member']['newprompt'];?></span><?php } if($_G['member']['newpm']) { ?><span class="unread_num2 png"><?php echo $_G['member']['newpm'];?></span><?php } ?></div>

            <span class="nickname"><?php echo $_G['member']['username'];?></span><span class="arrow"></span></div>

          <div class="user_menu">
            <div role="tooltip" id="van-popover-3718" aria-hidden="true" class="van-popover van-popper van-popper-nav van-popper-avatar">
  <div data-v-5314bca5="" class="vp-container">
    <div class="cl" style="padding: 20px 20px 0 20px;"><span style="float: left;">会员：</span> <p data-v-5314bca5="" class="nickname1" style="float: left; text-align: left;"><?php echo $_G['member']['username'];?></p><span style="float: left; padding-left: 10px;">您好！</span></div>
    <div data-v-5314bca5="" class="level-content">
      <div data-v-5314bca5="" class="level-info"><span data-v-5314bca5="" class="grade"><a id="nte_menu" href="home.php?mod=space&amp;do=notice" class="notification">提醒<?php if($_G['member']['newprompt']) { ?><span style="padding-left: 5px;color: #CE2727;"><?php echo $_G['member']['newprompt'];?></span><?php } ?></a></span><a href="home.php?mod=spacecp&amp;ac=credit&amp;showcredit=1" class="hint" data-v-5314bca5>积分: <?php echo $_G['member']['credits'];?></a></div>
    </div>
    <div data-v-5314bca5="" class="links1">
      <a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" data-v-5314bca5="" target="_blank" class="link-item">
      <div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_gerenzhongxin"></i> 个人中心 </div>
      </a>
      <a data-v-5314bca5="" href="home.php?mod=spacecp" target="_blank" class="link-item">
      <div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_tougaoguanli"></i> 信息设置 </div>
      </a>
      <?php if(check_diy_perm($topic)) { ?>
      <a href="javascript:openDiy();" onMouseOver="showMenu(this.id)" class="link-item" data-v-5314bca5="">
      <div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_qianbao"></i> 打开DIY </div>
      </a>
      <?php } ?>
      <?php if(($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))) { ?>
      <a data-v-5314bca5="" href="portal.php?mod=portalcp" target="_blank" class="link-item">
      <div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_dingdanzhongxin"></i> <?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?> </div>
      </a>
      <?php } ?> 
      <?php if($_G['uid'] && $_G['group']['radminid'] > 1) { ?>
      <a data-v-5314bca5="" href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank" class="link-item">
      <div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_zhibozhongxin"></i> <?php echo $_G['setting']['navs']['2']['navname'];?>管理 </div>
      </a>
      <?php } ?> 
      <?php if($_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)) { ?>
      <a data-v-5314bca5="" href="admin.php" target="_blank" class="link-item">
      <div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_cheese"></i> 管理中心 </div>
      </a>
      <?php } ?>
      <?php if($_G['uid'] && $_G['adminid'] == 1 && $_G['setting']['cloud_status']) { ?>
              <a data-v-5314bca5="" href="admin.php?frames=yes&amp;action=cloud&amp;operation=applist" target="_blank" class="link-item"><div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_cheese"></i> 云平台 </div></a>
              <?php } ?> 
              <?php if(!empty($_G['setting']['pluginhooks']['global_myitem_extra'])) echo $_G['setting']['pluginhooks']['global_myitem_extra'];?>
    </div>
    <div data-v-5314bca5="" class="logout"><span data-v-5314bca5=""><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_dengchu"></i> <a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a> </span></div>
  </div>
</div>
          </div>

        </div>

      </div>

      <ul class="usernav">

      </ul>

      <?php } elseif(!empty($_G['cookie']['loginuser'])) { ?>

      <div class="elecom_user">

        <div class="elecom_user_info">

          <div class="user-main ">

            <div class="avatar"> <img src="template/elec_20220314_miaoly/style/noLogin.jpg" alt="" height="32" width="32"></div>

            <span class="arrow"></span></div>

          <div class="user_menu">
            <div role="tooltip" id="van-popover-3718" aria-hidden="true" class="van-popover van-popper van-popper-nav van-popper-avatar">
  <div data-v-5314bca5="" class="vp-container">
  <div class="cl" style="padding: 20px 20px 0 20px;"><span style="float: left;">游客您好！</span></div>
    <div data-v-5314bca5="" class="links1">
      <a data-v-5314bca5="" target="_blank" class="link-item">
      <div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_gerenzhongxin"></i> <?php echo dhtmlspecialchars($_G['cookie']['loginuser']); ?> </div>
      </a>
      <a data-v-5314bca5="" href="member.php?mod=logging&amp;action=login" onClick="showWindow('login', this.href)" target="_blank" class="link-item">
      <div data-v-5314bca5="" class="link-title"><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_tougaoguanli"></i> 激活 </div>
      </a>
    </div>
    <div data-v-5314bca5="" class="logout"><span data-v-5314bca5=""><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_dengchu"></i> <a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a> </span></div>
  </div>
</div>
          </div>

        </div>

      </div>

      <?php } elseif(!$_G['connectguest']) { ?>

      <div class="elecom_user lg_box" style="margin: 25px 0 0 20px;">

       <ul>

              <li class="z log"><a href="member.php?mod=logging&amp;action=login" onClick="showWindow('login', this.href)" class="log1" style="padding: 0; background: none;">登录</a></li>

              <li class="z reg"><a href="member.php?mod=<?php echo $_G['setting']['regname'];?>" class="reg1">注册</a></li>

       </ul>

      </div>

      <?php } else { ?>

      <div class="elecom_user">

        <div class="elecom_user_info">

          <div class="user-main ">

            <div class="avatar"> <img src="template/elec_20220314_miaoly/style/noLogin.jpg" alt="" height="32" width="32"></div>

            <span class="arrow"></span></div>

          <div class="user_menu">
            <div role="tooltip" id="van-popover-3718" aria-hidden="true" class="van-popover van-popper van-popper-nav van-popper-avatar">
  <div data-v-5314bca5="" class="vp-container">
  <div class="cl" style="padding: 20px 20px 0 20px;"><span style="float: left;">临时会员：</span> <p data-v-5314bca5="" class="nickname1" style="float: left; text-align: left;"><?php echo $_G['member']['username'];?></p><span style="float: left; padding-left: 10px;">您好！</span></div>
    <div data-v-5314bca5="" class="logout"><span data-v-5314bca5=""><i data-v-5314bca5="" class="link-icon bilifont bili-icon_dingdao_dengchu"></i> <a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a> </span></div>
  </div>
</div>
          </div>

        </div>

      </div>

      <?php } ?>

      

      <div href="javascript:void(0)" target="_blank" class="elecom_searchbox" title="搜索" style="width: auto; margin-right: 10px;"><i class="s_icon" style="margin: 0 5px 0 0;"></i><span style="color: #999999;">搜索</span></div>

      <div style="display: none;" class="elecom_search"> 

       <div class="wp cl" style="width: 570px !important; margin: 0 auto; position: relative; z-index: 1000; background: none;">

          <?php if($_G['setting']['search']) { $slist = array();?><?php if($_G['fid'] && $_G['forum']['status'] != 3 && $mod != 'group') { ?><?php
$slist[forumfid] = <<<EOF
<li><a href="javascript:;" rel="curforum" fid="{$_G['fid']}" >本版</a></li>
EOF;
?><?php } if($_G['setting']['portalstatus'] && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)) { ?><?php
$slist[portal] = <<<EOF
<li><a href="javascript:;" rel="article">文章</a></li>
EOF;
?><?php } if($_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)) { ?><?php
$slist[forum] = <<<EOF
<li><a href="javascript:;" rel="forum" class="curtype">帖子</a></li>
EOF;
?><?php } if(helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1)) { ?><?php
$slist[blog] = <<<EOF
<li><a href="javascript:;" rel="blog">日志</a></li>
EOF;
?><?php } if(helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1)) { ?><?php
$slist[album] = <<<EOF
<li><a href="javascript:;" rel="album">相册</a></li>
EOF;
?><?php } if($_G['setting']['groupstatus'] && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)) { ?><?php
$slist[group] = <<<EOF
<li><a href="javascript:;" rel="group">{$_G['setting']['navs']['3']['navname']}</a></li>
EOF;
?><?php } ?><?php
$slist[user] = <<<EOF
<li><a href="javascript:;" rel="user">用户</a></li>
EOF;
?>


<?php } if($_G['setting']['search'] && $slist) { ?>


<div id="scbar" class="<?php if($_G['setting']['srchhotkeywords'] && count($_G['setting']['srchhotkeywords']) > 5) { ?>scbar_narrow <?php } ?>cl">


<form id="scbar_form" method="<?php if($_G['fid'] && !empty($searchparams['url'])) { ?>get<?php } else { ?>post<?php } ?>" autocomplete="off" onsubmit="searchFocus($('scbar_txt'))" action="<?php if($_G['fid'] && !empty($searchparams['url'])) { ?><?php echo $searchparams['url'];?><?php } else { ?>search.php?searchsubmit=yes<?php } ?>" target="_blank">


<input type="hidden" name="mod" id="scbar_mod" value="search" />


<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />


<input type="hidden" name="srchtype" value="title" />


<input type="hidden" name="srhfid" value="<?php echo $_G['fid'];?>" />


<input type="hidden" name="srhlocality" value="<?php echo $_G['basescript'];?>::<?php echo CURMODULE;?>" />


<?php if(!empty($searchparams['params'])) { if(is_array($searchparams['params'])) foreach($searchparams['params'] as $key => $value) { $srchotquery .= '&' . $key . '=' . rawurlencode($value);?><input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>" />


<?php } ?>


<input type="hidden" name="source" value="discuz" />


<input type="hidden" name="fId" id="srchFId" value="<?php echo $_G['fid'];?>" />


<input type="hidden" name="q" id="cloudsearchquery" value="" />





<style>


#scbar { overflow: visible; position: relative; }


#sg{ background: #FFF; width:456px; border: 1px solid #B2C7DA; }


.scbar_narrow #sg { width: 316px; }


#sg li { padding:0 8px; line-height:30px; font-size:14px; }


#sg li span { color:#999; }


.sml { background:#FFF; cursor:default; }


.smo { background:#E5EDF2; cursor:default; }


            </style>


            <div style="display: none; position: absolute; top:37px; left:44px;" id="sg">


                <div id="st_box" cellpadding="2" cellspacing="0"></div>


            </div>


<?php } ?>

<style type="text/css">
.scbar_type_td { display: none}
.scbar_txt_td, .scbar_txt_td, .scbar_narrow #scbar_txt { width: 500px !important; font-size: 16px !important}
#scbar_txt { font-size: 16px !important}
</style>
<table cellspacing="0" cellpadding="0">


<tr>
                <td class="scbar_type_td"><a href="javascript:;" id="scbar_type" class="xg1" onMouseOver="showMenu(this.id)" hidefocus="true">搜索</a></td>

<td class="scbar_txt_td"><input type="text" name="srchtxt" id="scbar_txt" value="请输入搜索内容" autocomplete="off" x-webkit-speech speech /></td>

                <td class="scbar_btn_td"><button type="submit" name="searchsubmit" id="scbar_btn" sc="1" class="pn pnc" value="true"><strong class="xi2">搜索</strong></button></td>

</tr>


</table>


</form>


</div>


<div class="scbar_hot_td" style="float: left; width: 540px; padding: 35px 0; display: none;">


<div id="scbar_hot" style="height: auto; padding: 0;">


<?php if($_G['setting']['srchhotkeywords']) { ?>


<div class="hot_1 cl" style="font-size: 16px; margin: 0 0 12px 0; color: #BBBBBB; font-weight: 400;">热搜</div>


                            <div class="hot_2 cl"><?php if(is_array($_G['setting']['srchhotkeywords'])) foreach($_G['setting']['srchhotkeywords'] as $val) { if($val=trim($val)) { $valenc=rawurlencode($val);?><?php
$__FORMHASH = FORMHASH;$srchhotkeywords[] = <<<EOF




EOF;
 if(!empty($searchparams['url'])) { 
$srchhotkeywords[] .= <<<EOF



<a href="{$searchparams['url']}?q={$valenc}&source=hotsearch{$srchotquery}" target="_blank" class="xi2" sc="1" style="	display: inline-block;


    color: #FF6651;


    font-weight: 700;


    font-size: 16px;


float: left;


    height: 33px;


    border: 1px solid #f0f0f0;


    margin: 0 20px 20px 0;


    padding: 0 15px;


    cursor: pointer;


    line-height: 33px;">{$val}</a>



EOF;
 } else { 
$srchhotkeywords[] .= <<<EOF



<a href="search.php?mod=forum&amp;srchtxt={$valenc}&amp;formhash={$__FORMHASH}&amp;searchsubmit=true&amp;source=hotsearch" target="_blank" class="xi2" sc="1" style="	display: inline-block;


    color: #FF6651;


    font-weight: 700;


    font-size: 16px;


float: left;


    height: 33px;


    border: 1px solid #f0f0f0;


    margin: 0 20px 20px 0;


    padding: 0 15px;


    cursor: pointer;


    line-height: 33px;">{$val}</a>



EOF;
 } 
$srchhotkeywords[] .= <<<EOF




EOF;
?>


<?php } } ?>


                            </div><?php echo implode('', $srchhotkeywords);; } ?>


</div>


</div>


<ul id="scbar_type_menu" class="p_pop" style="display: none;"><?php echo implode('', $slist);; ?></ul>


<script type="text/javascript">


initSearchmenu('scbar', '<?php echo $searchparams['url'];?>');


</script>


<?php } ?>
          <?php if($_G['setting']['search']) { ?> 

<!-- 搜索筛选 -->

<ul id="scbar_type_menu" class="p_pop" style="display: none;">

  <?php echo implode('', $slist);; ?></ul>

<script type="text/javascript">

initSearchmenu('scbar', '<?php echo $searchparams['url'];?>');

</script> 

<?php } ?>

       </div>

       <i class="close-search headericon-close"></i>

      </div>

      <div class="search_bg" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0px; z-index: 300;"></div>

      <script type="text/javascript">

      jQuery(document).ready(function(jQuery) {

jQuery('.elecom_searchbox').click(function(){

jQuery('.search_bg').fadeIn(200);

jQuery('.elecom_search').fadeIn(300);

})

jQuery('.close-search').click(function(){

jQuery('.search_bg').fadeOut(50);

jQuery('.elecom_search').fadeOut(300);

})



})

    </script>

      

    </div>

  </div>

</div><?php echo adshow("subnavbanner/a_mu");?><div class="mus_box cl">
  <div id="mus" class="wp cl"> 
    
    <?php if($_G['setting']['subnavs']) { ?> 
    
    <?php if(is_array($_G['setting']['subnavs'])) foreach($_G['setting']['subnavs'] as $navid => $subnav) { ?> 
    
    <?php if($_G['setting']['navsubhover'] || $mnid == $navid) { ?>
    
    <ul class="cl <?php if($mnid == $navid) { ?>current<?php } ?>" id="snav_<?php echo $navid;?>" style="display:<?php if($mnid != $navid) { ?>none<?php } ?>">
      <?php echo $subnav;?>
    </ul>
    
    <?php } ?> 
    
    <?php } ?> 
    
    <?php } ?> 
    
  </div>
</div>

<?php if(!IS_ROBOT) { ?> 

<?php if($_G['uid']) { ?>

<ul id="myprompt_menu" class="p_pop" style="display: none;">
  <li><a href="home.php?mod=space&amp;do=pm" id="pm_ntc" style="background-repeat: no-repeat; background-position: 0 50%;"><em class="prompt_news<?php if(empty($_G['member']['newpm'])) { ?>_0<?php } ?>"></em>消息</a></li>
  <li><a href="home.php?mod=follow&amp;do=follower"><em class="prompt_follower<?php if(empty($_G['member']['newprompt_num']['follower'])) { ?>_0<?php } ?>"></em>新听众<?php if($_G['member']['newprompt_num']['follower']) { ?>(<?php echo $_G['member']['newprompt_num']['follower'];?>)<?php } ?></a></li>
  
  <?php if($_G['member']['newprompt'] && $_G['member']['newprompt_num']['follow']) { ?>
  
  <li><a href="home.php?mod=follow"><em class="prompt_concern"></em>我关注的(<?php echo $_G['member']['newprompt_num']['follow'];?>)</a></li>
  
  <?php } ?> 
  
  <?php if($_G['member']['newprompt']) { ?> 
  
  <?php if(is_array($_G['member']['category_num'])) foreach($_G['member']['category_num'] as $key => $val) { ?>  
  <li><a href="home.php?mod=space&amp;do=notice&amp;view=<?php echo $key;?>"><em class="notice_<?php echo $key;?>"></em><?php echo lang('template', 'notice_'.$key); ?>(<span class="rq"><?php echo $val;?></span>)</a></li>
  
  <?php } ?> 
  
  <?php } ?> 
  
  <?php if(empty($_G['cookie']['ignore_notice'])) { ?>
  
  <li class="ignore_noticeli"><a href="javascript:;" onClick="setcookie('ignore_notice', 1);hideMenu('myprompt_menu')" title="暂不提醒"><em class="ignore_notice"></em></a></li>
  
  <?php } ?>
  
</ul>

<?php } ?> 

<?php if($_G['uid'] && !empty($_G['style']['extstyle'])) { ?>

<div id="sslct_menu" class="cl p_pop" style="display: none;"> 
  
  <?php if(!$_G['style']['defaultextstyle']) { ?><span class="sslct_btn" onClick="extstyle('')" title="默认"><i></i></span><?php } ?> 
  
  <?php if(is_array($_G['style']['extstyle'])) foreach($_G['style']['extstyle'] as $extstyle) { ?> 
  
  <span class="sslct_btn" onClick="extstyle('<?php echo $extstyle['0'];?>')" title="<?php echo $extstyle['1'];?>"><i style='background:<?php echo $extstyle['2'];?>'></i></span> 
  
  <?php } ?> 
  
</div>

<?php } ?> <div id="qmenu_menu" class="p_pop <?php if(!$_G['uid']) { ?>blk<?php } ?>" style="display: none;">
<?php if(!empty($_G['setting']['pluginhooks']['global_qmenu_top'])) echo $_G['setting']['pluginhooks']['global_qmenu_top'];?>
<?php if($_G['uid']) { ?>
<ul class="cl nav"><?php if(is_array($_G['setting']['mynavs'])) foreach($_G['setting']['mynavs'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?>
<li><?php echo $nav['code'];?></li>
<?php } } ?>
</ul>
<?php } elseif($_G['connectguest']) { ?>
<div class="ptm pbw hm">
请先<br /><a class="xi2" href="member.php?mod=connect"><strong>完善账号信息</strong></a> 或 <a href="member.php?mod=connect&amp;ac=bind" class="xi2 xw1"><strong>绑定已有账号</strong></a><br />后使用快捷导航
</div>
<?php } else { ?>
<div class="ptm pbw hm">
请 <a href="javascript:;" class="xi2" onclick="lsSubmit()"><strong>登录</strong></a> 后使用快捷导航<br />没有账号？<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>" class="xi2 xw1"><?php echo $_G['setting']['reglinkname'];?></a>
</div>
<?php } if($_G['setting']['showfjump']) { ?><div id="fjump_menu" class="btda"></div><?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_qmenu_bottom'])) echo $_G['setting']['pluginhooks']['global_qmenu_bottom'];?>
</div> 

<?php } ?> 

<?php if(!empty($_G['setting']['plugins']['jsmenu'])) { ?>

<ul class="p_pop h_pop" id="plugin_menu" style="display: none">
  
  <?php if(is_array($_G['setting']['plugins']['jsmenu'])) foreach($_G['setting']['plugins']['jsmenu'] as $module) { ?> 
  
  <?php if(!$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])) { ?>
  
  <li><?php echo $module['url'];?></li>
  
  <?php } ?> 
  
  <?php } ?>
  
</ul>

<?php } ?> 

<!-- 二级导航 -->

<div class="nav_slide"> <?php echo $_G['setting']['menunavs'];?> </div>

<!-- 用户菜单 -->

<ul class="sub_menu" id="m_menu" style="display: none;">
  
  <?php if(check_diy_perm($topic)) { ?>
  
  <li><a href="javascript:openDiy();" title="打开 DIY 面板">打开DIY</a></li>
  
  <?php } ?> 
  
  <?php if(is_array($_G['setting']['mynavs'])) foreach($_G['setting']['mynavs'] as $nav) { ?> 
  
  <?php if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?>
  
  <li style="display: none;"><?php echo $nav['code'];?></li>
  
  <?php } ?> 
  
  <?php } ?>
  
  <li><a href="home.php?mod=spacecp">设置</a></li>
  
  <?php if(($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))) { ?>
  
  <li><a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a></li>
  
  <?php } ?> 
  
  <?php if($_G['uid'] && $_G['group']['radminid'] > 1) { ?>
  
  <li><a href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank"><?php echo $_G['setting']['navs']['2']['navname'];?>管理</a></li>
  
  <?php } ?>
  
  <li><a href="home.php?mod=space&amp;do=favorite&amp;view=me">我的收藏</a></li>
  
  <?php if($_G['uid'] && $_G['adminid'] == 1 && $_G['setting']['cloud_status']) { ?>
  
  <li><a href="admin.php?frames=yes&amp;action=cloud&amp;operation=applist" target="_blank">云平台</a></li>
  
  <?php } ?> 
  
  <?php if($_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)) { ?>
  
  <li><a href="admin.php" target="_blank">管理中心</a></li>
  
  <?php } ?>
  
  <li><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?></li>
  <li><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra2'])) echo $_G['setting']['pluginhooks']['global_usernav_extra2'];?></li>
  <li><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra3'])) echo $_G['setting']['pluginhooks']['global_usernav_extra3'];?></li>
  <li><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra4'])) echo $_G['setting']['pluginhooks']['global_usernav_extra4'];?></li>
  <li><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a></li>
</ul>

<?php if(!empty($_G['setting']['pluginhooks']['global_header'])) echo $_G['setting']['pluginhooks']['global_header'];?> 

<?php } ?>

<div id="wp" class="wp serch_wp">

