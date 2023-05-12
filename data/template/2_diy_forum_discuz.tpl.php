<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('discuz');
block_get('22,28,30,5,6,7,24,25,18');?><?php include template('common/header'); ?><script src="template/elec_20220314_miaoly/style/js/jquery.superslide.js" type="text/javascript" type="text/javascript"></script>
<script src="template/elec_20220314_miaoly/style/js/sticky.js" type="text/javascript" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" id="time_diy" href="template/elec_20220314_miaoly/style/css/font-awesome.min.css" />
<?php if(empty($gid)) { ?> <?php echo adshow("text/wp a_t");?> 
<?php } ?>

<style id="diy_style" type="text/css">#portal_block_18 .dxb_bc {  margin-top:0px !important;margin-right:0px !important;margin-bottom:10px !important;margin-left:55px !important;}</style>
<style type="text/css">
.fl .bm { margin: 0}
.bmw .bm_h h2 a { font-size: 16px; font-weight: 400}
.fl .bm_h, .bmw .bm_h { width: 880px; padding: 0 0 12px 0; background: none; border: 0; font-weight: bold; font-size: 16px}
.fl .bm_h .y, .bmw .bm_h .y, .fl .bm_h .y a, .bmw .bm_h .y a { font-weight: 400; font-size: 12px}
.fl .bm_h h2, .bmw .bm_h h2 { padding: 0}
.fl .bm_h h2 a, .bmw .bm_h h2 a { font-weight: bold !important}
.bm_h .o { display: none}
.bm_c { padding: 0}

.fl_tb h2 a, .fl_g dt a { font-size: 16px}
.banner { position: relative; width:800px; height:330px; margin-bottom: 16px !important; overflow: hidden}
.banner .pic img { width:800px; height:330px; display: block}
.fl_g { float: left; width: 238px; height: auto; padding: 20px; margin: 0 20px 20px 0; border-radius: 4px; border: 1px solid #EEEEEE; background: #fff; cursor: pointer; transition: all 0.5s ease 0s; overflow: hidden}
.fl_g:hover { box-shadow: 0 6px 16px rgba(0,0,0,0.06)}
.fl_g .fl_icn_g { float: left; width: 36px !important; height: 36; overflow: hidden}
.fl_g .fl_icn_g img { width: 36px !important; height: 36px !important; border-radius: 50%; border: 0}
.fl_right { float: left; width: 192px; height: 28px; line-height: 28px; margin: 0 0 0 10px !important}
.fl_g:hover .tit_f a, .tit_f a:hover { color: #fc5531 !important}

.tabBar .hd { margin: 0 0 12px 0}
.tabBar .hd li { float: left; width: 90px; height: 30px; line-height: 30px; margin: 0 10px 0 0; font-size: 14px; color: #333333; background: #F3F3F3; text-align: center; cursor: pointer}
.tabBar .hd li.on { color: #FFFFFF; background: #FF6651}

.tabBar2 { margin: 0 0 20px 0; border-radius: 4px; background: #F6F6F6}
.tabBar2 .hd { height: 50px;
    line-height: 50px;
    font-size: 16px;
    color: #333333;
    font-weight: bold;
    padding: 0 20px;
    border-bottom: 1px solid #EEEEEE;
    margin-bottom: 0
}
.tabBar2 .hd h3 {
    float: left;
    height: 49px;
line-height: 50px;
    border-bottom: 2px solid #FF6651;
    font-weight: bold;
}
.tabBar2 .hd ul { float: right; width: auto; margin: 0; z-index: 5; zoom: 1}
.tabBar2 .hd li {
width: 38px;
height: 18px;
line-height: 18px;
padding: 0;
margin: 0 0 0 5px;
border-radius: 4px;
    font-size: 12px;
    color: #888888;
    font-weight: 400;
text-align: center;
border: 1px solid #E8E8E8;
    cursor: pointer;
    position: relative;
display: inline-block;
background: #FFFFFF
}
.tabBar2 .hd li.on { color: #FFFFFF; border-color: #FF6651; background: #FF6651}

.tabBar2 .bd { border: 0; padding: 10px 0; clear:both; position:relative; height: auto; min-height: 100px; overflow: hidden}
.tabBar2 .bd .conWrap2 { width: 100%}

.ranks1 { padding: 0 20px}
.ranks1 li { float: left; width: 100%; display: block; line-height: 30px; font-size: 14px}
.ranks1 li em { float: left; width: 22px; height: 15px; line-height: 15px; margin: 7px 10px 0 0; font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #FFFFFF; border-radius: 2px; text-align: center; background: #BEBEBE}
.ranks1 li:nth-child(1) em { background: #DF272B}
.ranks1 li:nth-child(2) em { background: #EFA300}
.ranks1 li:nth-child(3) em { background: #5BB44D}
.ranks1 li a { float: left; display: block; width: 228px; height: 30px; color: #555555; white-space: nowrap; overflow: hidden; text-overflow: ellipsis}
.ranks1 li a:hover { color: #FF6651}

.elec_tab_cont dl dd {
    display: block;
    clear: both;
    font-size: 14px;
    color: #666;
    height: 32px;
    line-height: 32px;
    margin-bottom: 1px;
}
.elec_tab_cont dl dd em {
    width: 20px;
    height: 20px;
    display: block;
    float: left;
    text-align: center;
    line-height: 20px;
    color: #fff;
    font-size: 12px;
    margin-top: 5px;
    margin-right: 10px;
    background: #ddd;
    border-radius: 20px 0 20px 20px;
}
.elec_tab_cont dl dd a {
    float: left;
    font-size: 14px;
    width: 420px;
    color: #333;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.elec_tab_cont dl dd a:hover { color: #FF6651}
.elec_tab_cont dl dd span {
    color: #aaa;
}
.elec_tab_cont dl dd i {
    padding-right: 4px;
    margin-left: 10px;
    font-size: 12px;
    color: #ccc;
}
.elec_tab_cont dl dd:nth-child(1) em {
    background: #DF272B;
}
.elec_tab_cont dl dd:nth-child(2) em {
    background: #EFA300;
}
.elec_tab_cont dl dd:nth-child(3) em {
    background: #5BB44D;
}

.bbs_banner { position: relative; width:500px; height:340px; overflow: hidden; border-radius: 4px}
.bbs_banner .pic img { width:500px; height:340px; display: block; }
.bbs_banner .pic li { position: relative}
.bbs_banner .pic li h3 { display: block; position: absolute; bottom: 0; left: 0; width: 460px; font-size: 16px; font-weight: 400; padding: 10px 20px 20px 20px; color: #FFFFFF; background: rgba(0,0,0,0.5)}
.bbs_banner .hd { overflow:hidden; zoom:1; position:absolute; bottom: 10px; right: 20px; z-index:3}
.bbs_banner .hd li{float:left; line-height: 10px; text-align:center; font-size:12px; width:10px; height:10px; border-radius: 50%; cursor:pointer; overflow:hidden; background: rgba(255,255,255,0.8); margin-left: 10px}
.bbs_banner .hd .on{ background: #FF6651}

#online .bm_h, #online .bm_h a { font-size: 14px !important; color: #333333 !important; font-weight: 400 !important}
.elec_tab_right { float: right}
@media (max-width: 1200px) {
.elec_tab_right { display: none}
.sd { display: none}
.detailName { height: 100px}
.left1x { width: 100% !important}
.left1x .mn { width: 100% !important; padding: 0 !important; border: 0 !important}
.t_box1 { margin: 0 !important}
.mod_art_list { height: 85px !important; padding: 15px 0 !important; margin: 0 !important}
.mod_art_list_pic { width: 32% !important; height: 85px !important; margin: 0 !important}
.mod_art_list_pic img { width: 100% !important; height: auto !important; min-height: 85px !important}
.mod_art_list_content { float: right !important; width: 65% !important; height: 85px !important; margin: 0 !important}
.mod_art_list h3 { height: 40px !important}
.mod_art_list h3 a { font-size: 15px !important}
.mod_art_list_simple, .display_none { display: none !important}
.t_box1x .z, .t_box1x .y { float: none !important; width: 100% !important; height: auto !important; padding: 0 !important; border: 0 !important}
.bbs_banner .pic li { height: 200px}
.bbs_banner .pic img { width: 100% !important; height: auto !important}
.bbs_banner { width: 100% !important; height: 200px !important}
.bbs_banner .pic li h3 { width: 95% !important; padding: 10px 5% !important}
.tabBar .hd { width: 100% !important; padding: 0 !important; margin: 20px 0 10px 0 !important}
.tabBar .hd li { width: 22% !important; margin: 0 4% 0 0 !important}
.tabBar .hd li:last-child { margin: 0 !important}
#main_sidebar { display: none}
.mn { float: none !important; width: 100% !important}
.elec_tab_cont dl dd a { float: none !important; width: auto !important}
#chart { height: auto !important; padding: 10px 5% !important}
#chart .z span { width: 50% !important; margin: 0 0 20px 0 !important}
#chart .y { float: left !important}
#chart .y span { padding: 0 !important}
.Framebox { width: 100% !important}
.fl_g { width: 100% !important; padding: 5% !important; margin-bottom: 10px !important; box-sizing: border-box}
#online { width: 100% !important; padding: 5% !important; box-sizing: border-box}
.fl .bm_h, .bmw .bm_h { width: 100% !important; height: auto !important}
.display_none { display: none}
}
</style>
<div class="section">
<div class="t_box1x cl" style="margin: 20px 0;">
 <div class="z" style="width: 600px; height: 400px; overflow: hidden;">
    <!--[diy=diy_z]--><div id="diy_z" class="area"><div id="frameqEVpdo" class="frame move-span cl frame-1"><div id="frameqEVpdo_left" class="column frame-1-c"><div id="frameqEVpdo_left_temp" class="move-span temp"></div><?php block_display('22');?></div></div></div><!--[/diy]-->
 </div>
 <div class="y" style="width: 500px; padding: 20px; height: 310px; border-radius: 4px; border: 1px solid #EEEEEE; overflow: hidden;">
            <div class="tabBar cl">
          <div class="hd cl"> 
            
            <ul>

</ul> 
          </div>
          <div class="bd cl">
            <div class="conWrap">
              <div class="con"> 
                
                <!--[diy=diy_con1]--><div id="diy_con1" class="area"><div id="frame1h48pZ" class="frame move-span cl frame-1"><div id="frame1h48pZ_left" class="column frame-1-c"><div id="frame1h48pZ_left_temp" class="move-span temp"></div><?php block_display('28');?><?php block_display('30');?></div></div></div><!--[/diy]--> 
                
              </div>
              <div class="con"> 
                
                <!--[diy=diy_con2]--><div id="diy_con2" class="area"><div id="frameW2xDkp" class="frame move-span cl frame-1"><div class="title frame-title"><span class="titletext">1框架</span></div><div id="frameW2xDkp_left" class="column frame-1-c"><div id="frameW2xDkp_left_temp" class="move-span temp"></div></div></div><div id="frametr2B8x" class="frame move-span cl frame-1-1"><div class="title frame-title"><span class="titletext">1-1框架</span></div><div id="frametr2B8x_left" class="column frame-1-1-l"><div id="frametr2B8x_left_temp" class="move-span temp"></div></div><div id="frametr2B8x_center" class="column frame-1-1-r"><div id="frametr2B8x_center_temp" class="move-span temp"></div></div></div><div id="frameBJ5TI6" class="frame move-span cl frame-1"><div class="title frame-title"><span class="titletext">1框架</span></div><div id="frameBJ5TI6_left" class="column frame-1-c"><div id="frameBJ5TI6_left_temp" class="move-span temp"></div></div></div><div id="framep71o9z" class="frame move-span cl frame-1"><div id="framep71o9z_left" class="column frame-1-c"><div id="framep71o9z_left_temp" class="move-span temp"></div><?php block_display('5');?></div></div></div><!--[/diy]--> 
                
              </div>
              <div class="con"> 
                
                <!--[diy=diy_con3]--><div id="diy_con3" class="area"><div id="frameizYbJM" class="frame move-span cl frame-1"><div id="frameizYbJM_left" class="column frame-1-c"><div id="frameizYbJM_left_temp" class="move-span temp"></div><?php block_display('6');?></div></div></div><!--[/diy]--> 
                
              </div>
              <div class="con"> 
                
                <!--[diy=diy_con4]--><div id="diy_con4" class="area"><div id="frameE1022J" class="frame move-span cl frame-1"><div id="frameE1022J_left" class="column frame-1-c"><div id="frameE1022J_left_temp" class="move-span temp"></div><?php block_display('7');?></div></div></div><!--[/diy]--> 
                
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
jQuery(".tabBar").slide({ mainCell:".conWrap", effect:"fold", trigger:"click", pnLoop:false });
</script> 
 </div>
</div>
<div class="wp cl" style="margin: 0;"> 
  <?php if(empty($gid)) { ?>
    <div id="chart" class="bm bw0 mb10 cl" style="height: 28px; line-height: 28px; padding: 25px 20px; margin: 0 0 10px 0; border-radius: 4px; border: 1px solid #EEEEEE !important; background: #FFFFFF; box-shadow: none; font-size: 15px; color: #888888;">
    <p class="z">
    <span style="float: left; margin: 0 40px 0 0; display: block; height: 28px; line-height: 28px; overflow: hidden;"><img src="template/elec_20220314_miaoly/style/bbs1.png" style="float: left; margin: 0 10px 0 0;">今日: <em><?php echo $todayposts;?></em></span>
    <span style="float: left; margin: 0 40px 0 0; display: block; height: 28px; line-height: 28px; overflow: hidden;""><img src="template/elec_20220314_miaoly/style/bbs2.png" style="float: left; margin: 0 10px 0 0;">昨日: <em><?php echo $postdata['0'];?></em></span>
    <span style="float: left; margin: 0 40px 0 0; display: block; height: 28px; line-height: 28px; overflow: hidden;""><img src="template/elec_20220314_miaoly/style/bbs3.png" style="float: left; margin: 0 10px 0 0;">帖子: <em><?php echo $posts;?></em></span>
    <span style="float: left; margin: 0 40px 0 0; display: block; height: 28px; line-height: 28px; overflow: hidden;""><img src="template/elec_20220314_miaoly/style/bbs4.png" style="float: left; margin: 0 10px 0 0;">会员: <em><?php echo $_G['cache']['userstats']['totalmembers'];?></em></span>
    </p>
    <div class="z"><?php if(!empty($_G['setting']['pluginhooks']['index_status_extra'])) echo $_G['setting']['pluginhooks']['index_status_extra'];?></div>
    <div class="y"> 
      <?php if(!empty($_G['setting']['pluginhooks']['index_nav_extra'])) echo $_G['setting']['pluginhooks']['index_nav_extra'];?> 
      <?php if($_G['cache']['userstats']['newsetuser']) { ?>
    <span style="padding: 0 0 0 20px;">欢迎新会员: <em><a href="home.php?mod=space&amp;username=<?php echo rawurlencode($_G['cache']['userstats']['newsetuser']); ?>" target="_blank" class="xi2"><?php echo $_G['cache']['userstats']['newsetuser'];?></a></em></span><?php } ?>
      <?php if($_G['uid']) { ?><a href="forum.php?mod=guide&amp;view=my" title="我的帖子" class="xi2 z" style="color: #888888;">我的帖子</a><?php } if(!empty($_G['setting']['search']['forum']['status'])) { } ?>
    </div>
  </div>
  <?php } ?>
  <!--[diy=diy_chart]--><div id="diy_chart" class="area"></div><!--[/diy]-->
  <div class="mn cl" style="float: left; width: 880px;">
    <div class="cl" style="height: auto; margin-bottom: 0; overflow: visible;">
       <!--[diy=diy_center]--><div id="diy_center" class="area"></div><!--[/diy]-->
    </div>
    <!--[diy=diy_centerdown]--><div id="diy_centerdown" class="area"></div><!--[/diy]-->
    <div class="cl" style="box-shadow: none;">
    <div class="Framebox cl" style="width: 900px; padding: 0; border-radius: 0; background: none; box-shadow: none;">
    <?php if(!empty($_G['setting']['grid']['showgrid'])) { ?> 
    <!-- index four grid -->
    <div class="fl bm" style="border: 0; margin-bottom: 0;">
      <div class="bm bmw cl">
        <div id="category_grid" class="bm_c" >
          <div cellspacing="0" cellpadding="0">
              <?php if(!$_G['setting']['grid']['gridtype']) { ?>
              <div valign="top" class="category_l1"><div class="newimgbox">
                  <h4><span class="tit_newimg"></span>最新图片</h4>
                  <div class="module cl slidebox_grid" style="width:218px"> 
                    <script type="text/javascript">
var slideSpeed = 5000;
var slideImgsize = [218,200];
var slideBorderColor = '<?php echo $_G['style']['specialborder'];?>';
var slideBgColor = '<?php echo $_G['style']['commonbg'];?>';
var slideImgs = new Array();
var slideImgLinks = new Array();
var slideImgTexts = new Array();
var slideSwitchColor = '<?php echo $_G['style']['tabletext'];?>';
var slideSwitchbgColor = '<?php echo $_G['style']['commonbg'];?>';
var slideSwitchHiColor = '<?php echo $_G['style']['specialborder'];?>';<?php $k = 1;?><?php if(is_array($grids['slide'])) foreach($grids['slide'] as $stid => $svalue) { ?>slideImgs[<?php echo $k; ?>] = '<?php echo $svalue['image'];?>';
slideImgLinks[<?php echo $k; ?>] = '<?php echo $svalue['url'];?>';
slideImgTexts[<?php echo $k; ?>] = '<?php echo $svalue['subject'];?>';<?php $k++;?><?php } ?>
</script> 
                    <script src="<?php echo $_G['setting']['jspath'];?>forum_slide.js?<?php echo VERHASH;?>" type="text/javascript"></script> 
                  </div>
                </div></div>
              <?php } ?>
              <div valign="top" class="category_l2"><div class="subjectbox">
                  <h4><span class="tit_subject"></span>最新主题</h4>
                  <ul class="category_newlist">
                    <?php if(is_array($grids['newthread'])) foreach($grids['newthread'] as $thread) { ?> 
                    <?php if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { ?> 
                    <?php $thread[tid]=$thread[closed];?> 
                    <?php } ?>
                    <li><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>"<?php if($thread['highlight']) { ?> <?php echo $thread['highlight'];?><?php } if($_G['setting']['grid']['showtips']) { ?> tip="标题: <strong><?php echo $thread['oldsubject'];?></strong><br/>作者: <?php echo $thread['author'];?> (<?php echo $thread['dateline'];?>)<br/>查看/回复: <?php echo $thread['views'];?>/<?php echo $thread['replies'];?>" onmouseover="showTip(this)"<?php } else { ?> title="<?php echo $thread['oldsubject'];?>"<?php } if($_G['setting']['grid']['targetblank']) { ?> target="_blank"<?php } ?>><?php echo $thread['subject'];?></a></li>
                    <?php } ?>
                  </ul>
                </div></div>
              <div valign="top" class="category_l3"><div class="replaybox">
                  <h4><span class="tit_replay"></span>最新回复</h4>
                  <ul class="category_newlist">
                    <?php if(is_array($grids['newreply'])) foreach($grids['newreply'] as $thread) { ?> 
                    <?php if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { ?> 
                    <?php $thread[tid]=$thread[closed];?> 
                    <?php } ?>
                    <li><a href="forum.php?mod=redirect&amp;tid=<?php echo $thread['tid'];?>&amp;goto=lastpost#lastpost"<?php if($thread['highlight']) { ?> <?php echo $thread['highlight'];?><?php } if($_G['setting']['grid']['showtips']) { ?>tip="标题: <strong><?php echo $thread['oldsubject'];?></strong><br/>作者: <?php echo $thread['author'];?> (<?php echo $thread['dateline'];?>)<br/>查看/回复: <?php echo $thread['views'];?>/<?php echo $thread['replies'];?>" onmouseover="showTip(this)"<?php } else { ?> title="<?php echo $thread['oldsubject'];?>"<?php } if($_G['setting']['grid']['targetblank']) { ?> target="_blank"<?php } ?>><?php echo $thread['subject'];?></a></li>
                    <?php } ?>
                  </ul>
                </div></div>
              <div valign="top" class="category_l3"><div class="hottiebox">
                  <h4><span class="tit_hottie"></span>热帖</h4>
                  <ul class="category_newlist">
                    <?php if(is_array($grids['hot'])) foreach($grids['hot'] as $thread) { ?> 
                    <?php if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { ?> 
                    <?php $thread[tid]=$thread[closed];?> 
                    <?php } ?>
                    <li><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>"<?php if($thread['highlight']) { ?> <?php echo $thread['highlight'];?><?php } if($_G['setting']['grid']['showtips']) { ?> tip="标题: <strong><?php echo $thread['oldsubject'];?></strong><br/>作者: <?php echo $thread['author'];?> (<?php echo $thread['dateline'];?>)<br/>查看/回复: <?php echo $thread['views'];?>/<?php echo $thread['replies'];?>" onmouseover="showTip(this)"<?php } else { ?> title="<?php echo $thread['oldsubject'];?>"<?php } if($_G['setting']['grid']['targetblank']) { ?> target="_blank"<?php } ?>><?php echo $thread['subject'];?></a></li>
                    <?php } ?>
                  </ul>
                </div></div>
              <?php if($_G['setting']['grid']['gridtype']) { ?>
              <div valign="top" class="category_l4"><div class="goodtiebox">
                  <h4><span class="tit_goodtie"></span>精华帖子</h4>
                  <ul class="category_newlist">
                    <?php if(is_array($grids['digest'])) foreach($grids['digest'] as $thread) { ?> 
                    <?php if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { ?> 
                    <?php $thread[tid]=$thread[closed];?> 
                    <?php } ?>
                    <li><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>"<?php if($thread['highlight']) { ?> <?php echo $thread['highlight'];?><?php } if($_G['setting']['grid']['showtips']) { ?> tip="标题: <strong><?php echo $thread['oldsubject'];?></strong><br/>作者: <?php echo $thread['author'];?> (<?php echo $thread['dateline'];?>)<br/>查看/回复: <?php echo $thread['views'];?>/<?php echo $thread['replies'];?>" onmouseover="showTip(this)"<?php } else { ?> title="<?php echo $thread['oldsubject'];?>"<?php } if($_G['setting']['grid']['targetblank']) { ?> target="_blank"<?php } ?>><?php echo $thread['subject'];?></a></li>
                    <?php } ?>
                  </ul>
                </div></div>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <!-- index four grid end --> 
    <?php } ?> 
    <?php if(!empty($_G['setting']['pluginhooks']['index_top'])) echo $_G['setting']['pluginhooks']['index_top'];?> 
    <?php if(!empty($_G['cache']['heats']['message'])) { ?>
    <div class="bm">
      <div class="bm_h cl">
        <h2><?php echo $_G['setting']['navs']['2']['navname'];?>热点</h2>
      </div>
      <div class="bm_c cl">
        <div class="heat z"> 
          <?php if(is_array($_G['cache']['heats']['message'])) foreach($_G['cache']['heats']['message'] as $data) { ?>          <div class="xld">
            <div><?php if($_G['adminid'] == 1) { ?><a class="d" href="forum.php?mod=misc&amp;action=removeindexheats&amp;tid=<?php echo $data['tid'];?>" onclick="return removeindexheats()">delete</a><?php } ?> 
              <a href="forum.php?mod=viewthread&amp;tid=<?php echo $data['tid'];?>" target="_blank" class="xi2"><?php echo $data['subject'];?></a></div>
            <div><?php echo $data['message'];?></div>
          </div>
          <?php } ?> 
        </div>
        <ul class="xl xl1 heatl">
          <?php if(is_array($_G['cache']['heats']['subject'])) foreach($_G['cache']['heats']['subject'] as $data) { ?>          <li><?php if($_G['adminid'] == 1) { ?><a class="d" href="forum.php?mod=misc&amp;action=removeindexheats&amp;tid=<?php echo $data['tid'];?>" onclick="return removeindexheats()">delete</a><?php } ?>&middot; <a href="forum.php?mod=viewthread&amp;tid=<?php echo $data['tid'];?>" target="_blank" class="xi2"><?php echo $data['subject'];?></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <?php } ?> 
    
    <?php if(!empty($_G['setting']['pluginhooks']['index_catlist_top'])) echo $_G['setting']['pluginhooks']['index_catlist_top'];?>
    <div class="fl bm" style="border: 0; margin-bottom: 0;"> 
      <?php if(!empty($collectiondata['follows'])) { ?> 
      
      <?php $forumscount = count($collectiondata['follows']);?> 
      <?php $forumcolumns = 4;?> 
      
      <?php $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';?>      
      <div class="bm bmw <?php if($forumcolumns) { ?> flg<?php } ?> cl">
        <div class="bm_h cl"> <span class="o cl"> <img id="category_-1_img" src="<?php echo IMGDIR;?>/<?php echo $collapse['collapseimg_-1'];?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_-1');" /> </span>
          <h2><a href="forum.php?mod=collection&amp;op=my">我订阅的专辑</a></h2>
        </div>
        <div id="category_-1" class="bm_c" style="<?php echo $collapse['category_-1']; ?>">
          <div cellspacing="0" cellpadding="0" class="fl_tb">
              <?php $ctorderid = 0;?> 
              <?php if(is_array($collectiondata['follows'])) foreach($collectiondata['follows'] as $key => $colletion) { ?> 
              <?php if($ctorderid && ($ctorderid % $forumcolumns == 0)) { ?> 
            <?php if($ctorderid < $forumscount) { ?>
              <?php } ?> 
              <?php } ?>
              <div class="fl_g">
                <div class="fl_icn_g"> <a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $colletion['ctid'];?>" target="_blank"><img src="template/elec_20220314_miaoly/style/forum<?php if($followcollections[$key]['lastvisit'] < $colletion['lastupdate']) { ?>_new<?php } ?>.gif" alt="<?php echo $colletion['name'];?>" /></a> </div>
                <div>
                  <div><a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $colletion['ctid'];?>"><?php echo $colletion['name'];?></a></div>
                  <div><em>主题: <?php echo dnumber($colletion['threadnum']); ?></em>, <em>评论: <?php echo dnumber($colletion['commentnum']); ?></em></div>
                  <div> 
                    <?php if($colletion['lastpost']) { ?> 
                    <?php if($forumcolumns < 3) { ?> 
                    <a href="forum.php?mod=redirect&amp;tid=<?php echo $colletion['lastpost'];?>&amp;goto=lastpost#lastpost" class="xi2" style="display: block; width: 100%; color: #2783DF; margin-bottom: 5px;"><?php echo cutstr($colletion['lastsubject'], 30); ?></a> <cite><?php echo dgmdate($colletion[lastposttime]);?> / <?php if($colletion['lastposter']) { ?><?php echo $colletion['lastposter'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite> 
                    <?php } else { ?> 
                    <a href="forum.php?mod=redirect&amp;tid=<?php echo $colletion['lastpost'];?>&amp;goto=lastpost#lastpost">最后发表: <?php echo dgmdate($colletion[lastposttime]);?></a> 
                    <?php } ?> 
                    <?php } else { ?> 
                    从未 
                    <?php } ?> 
                  </div>
                  <?php if(!empty($_G['setting']['pluginhooks']['index_followcollection_extra'][$colletion[ctid]])) echo $_G['setting']['pluginhooks']['index_followcollection_extra'][$colletion[ctid]];?>
                </div></div>
              <?php $ctorderid++;?> 
              
              <?php } ?> 
              <?php if(($columnspad = $ctorderid % $forumcolumns) > 0) { echo str_repeat('<div class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></div>', $forumcolumns - $columnspad);; } ?> 
          </div>
        </div>
      </div>
      
      <?php } ?> 
      <?php if(empty($gid) && !empty($forum_favlist)) { ?> 
      <?php $forumscount = count($forum_favlist);?> 
      <?php $forumcolumns = $forumscount > 3 ? ($forumscount == 4 ? 4 : 5) : 1;?>      
      <?php $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';?>      
      <div class="bm bmw <?php if($forumcolumns) { ?> flg<?php } ?> cl" style="display: none;">
        <div class="bm_h cl"> <span class="o cl"> <img id="category_0_img" src="<?php echo IMGDIR;?>/<?php echo $collapse['collapseimg_0'];?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_0');" /> </span>
          <h2><a href="home.php?mod=space&amp;do=favorite&amp;type=forum">我收藏的版块</a></h2>
        </div>
        <div id="category_0" class="bm_c myfav_img" style="<?php echo $collapse['category_0']; ?>">
          <div cellspacing="0" cellpadding="0" class="fl_tb">
              <?php $favorderid = 0;?> 
              <?php if(is_array($forum_favlist)) foreach($forum_favlist as $key => $favorite) { ?> 
              <?php if($favforumlist[$favorite['id']]) { ?> 
              <?php $forum=$favforumlist[$favorite[id]];?> 
              <?php $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];?> 
              <?php if($forumcolumns>1) { ?> 
              <?php if($favorderid && ($favorderid % $forumcolumns == 0)) { ?> 
            <?php if($favorderid < $forumscount) { ?>
              <?php } ?> 
              <?php } ?>
              <div class="fl_g"><div class="fl_icn_g"> 
                  <?php if($forum['icon']) { ?> 
                  <?php echo $forum['icon'];?> 
                  <?php } else { ?> 
                  <a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } ?>><img src="template/elec_20220314_miaoly/style/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" /></a> 
                  <?php } ?> 
                </div>
                <div>
                <div style="margin-bottom: 0;"><a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } if($forum['extra']['namecolor']) { ?> style="color: <?php echo $forum['extra']['namecolor'];?>;"<?php } ?>><?php echo $forum['name'];?></a><?php if($forum['todayposts'] && !$forum['redirect']) { ?><em class="xw0 xi1" title="今日"> (<?php echo $forum['todayposts'];?>)</em><?php } ?></div>
                
                <?php if(empty($forum['redirect'])) { ?>
                <div><em>主题: <?php echo dnumber($forum['threads']); ?></em>, <em>帖数: <?php echo dnumber($forum['posts']); ?></em></div>
                <?php } ?>
                
                <div style="display: none;"> 
                  <?php if($forum['permission'] == 1) { ?> 
                  私密版块 
                  <?php } else { ?> 
                  <?php if($forum['redirect']) { ?> 
                  <a href="<?php echo $forumurl;?>" class="xi2">链接到外部地址</a> 
                  <?php } elseif(is_array($forum['lastpost'])) { ?> 
                  <?php if($forumcolumns < 3) { ?> 
                  <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost" class="xi2" style="display: block; width: 100%; color: #2783DF; margin-bottom: 5px;"><?php echo cutstr($forum['lastpost']['subject'], 30); ?></a> <cite><?php echo $forum['lastpost']['dateline'];?> <?php if($forum['lastpost']['author']) { ?> / <?php echo $forum['lastpost']['author'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite> 
                  <?php } else { ?> 
                  <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost">最后发表: <?php echo $forum['lastpost']['dateline'];?></a> 
                  <?php } ?> 
                  <?php } else { ?> 
                  从未 
                  <?php } ?> 
                  <?php } ?> 
                </div>
                
                <?php if(!empty($_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]];?>
                
                </div></div>
              <?php $favorderid++;?> 
              <?php } else { ?>
              <div class="fl_icn"><?php if($forum['icon']) { ?> 
                <?php echo $forum['icon'];?> 
                <?php } else { ?> 
                <a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } ?>><img src="template/elec_20220314_miaoly/style/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" /></a> 
                <?php } ?></div>
              <div><h2><a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } if($forum['extra']['namecolor']) { ?> style="color: <?php echo $forum['extra']['namecolor'];?>;"<?php } ?>><?php echo $forum['name'];?></a><?php if($forum['todayposts'] && !$forum['redirect']) { ?><em class="xw0 xi1" title="今日"> (<?php echo $forum['todayposts'];?>)</em><?php } ?></h2>
                <?php if($forum['subforums']) { ?>
                <p>子版块: <?php echo $forum['subforums'];?></p>
                <?php } ?> 
                <?php if($forum['moderators']) { ?>
                <p>版主: <span class="xi2"><?php echo $forum['moderators'];?></span></p>
                <?php } ?> 
                <?php if(!empty($_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]];?></div>
              <div class="fl_i"><div> 
                  <?php if(empty($forum['redirect'])) { ?><span class="f_threads"><?php echo dnumber($forum['threads']); ?></span>
                  <div class="line"> / </div>
                  <span class="f_posts"><?php echo dnumber($forum['posts']); ?></span><?php } ?></div></div>
              <div class="fl_by"><div> 
                  <?php if($forum['permission'] == 1) { ?> 
                  私密版块 
                  <?php } else { ?> 
                  <?php if($forum['redirect']) { ?> 
                  <a href="<?php echo $forumurl;?>" class="xi2">链接到外部地址</a> 
                  <?php } elseif(is_array($forum['lastpost'])) { ?> 
                  <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost"><?php echo cutstr($forum['lastpost']['subject'], 30); ?></a> <?php if($forum['lastpost']['author']) { ?>
                  <p>by <?php echo $forum['lastpost']['author'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?></p>
                  <?php } ?><cite><?php echo $forum['lastpost']['dateline'];?></cite> 
                  <?php } else { ?> 
                  从未 
                  <?php } ?> 
                  <?php } ?> 
                </div></div>
              
              <?php } ?> 
              <?php } ?> 
              <?php } ?> 
              <?php if(($columnspad = $favorderid % $forumcolumns) > 0) { echo str_repeat('<div class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></div>', $forumcolumns - $columnspad);; } ?> 
          </div>
        </div>
      </div>
      <?php echo adshow("intercat/bm a_c/-1");?> 
      <?php } ?> 
      <?php if(is_array($catlist)) foreach($catlist as $key => $cat) { ?> 
      <?php if(!empty($_G['setting']['pluginhooks']['index_catlist'][$cat[fid]])) echo $_G['setting']['pluginhooks']['index_catlist'][$cat[fid]];?>
      <div class="bm bmw <?php if($cat['forumcolumns']) { ?> flg<?php } ?> cl">
        <div class="bm_h cl"> <span class="o cl"> <img id="category_<?php echo $cat['fid'];?>_img" src="<?php echo IMGDIR;?>/<?php echo $cat['collapseimg'];?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_<?php echo $cat['fid'];?>');" /> </span> 
          <?php if($cat['moderators']) { ?><span class="y">分区版主: <?php echo $cat['moderators'];?></span><?php } ?> 
          <?php $caturl = !empty($cat['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$cat['domain'].'.'.$_G['setting']['domain']['root']['forum'] : '';?>          <h2><a href="<?php if(!empty($caturl)) { ?><?php echo $caturl;?><?php } else { ?>forum.php?gid=<?php echo $cat['fid'];?><?php } ?>" style="<?php if($cat['extra']['namecolor']) { ?>color: <?php echo $cat['extra']['namecolor'];?>;<?php } ?>"><?php echo $cat['name'];?></a></h2>
        </div>
        <div id="category_<?php echo $cat['fid'];?>" class="bm_c" style="<?php echo $collapse['category_'.$cat['fid']]; ?>">
          <div cellspacing="0" cellpadding="0" class="fl_tb">
              <?php if(is_array($cat['forums'])) foreach($cat['forums'] as $forumid) { ?> 
              <?php $forum=$forumlist[$forumid];?> 
              <?php $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];?> 
              <?php if($cat['forumcolumns']) { ?> 
              <?php if($forum['orderid'] && ($forum['orderid'] % $cat['forumcolumns'] == 0)) { ?> 
            <?php if($forum['orderid'] < $cat['forumscount']) { ?>
              <?php } ?> 
              <?php } ?>
              <div class="fl_g" width="<?php echo $cat['forumcolwidth'];?>">
               <div class="cl" style="padding-bottom: 20px; margin-bottom: 10px; border-bottom: 1px dashed #EEEEEE;">
                <div class="fl_icn_g">
                  <?php if($forum['icon']) { ?> 
                  <?php echo $forum['icon'];?> 
                  <?php } else { ?> 
                  <a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } ?>><img src="template/elec_20220314_miaoly/style/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" /></a> 
                  <?php } ?> 
                </div>
                <div class="fl_right">
                <div style="width: 110px; height: 15px; line-height: 15px; margin: 0; overflow: hidden;" class="tit_f cl"><a href="<?php echo $forumurl;?>" style="color: #222226; font-size: 14px; font-weight: bold;" title="<?php echo $forum['name'];?>"><?php echo $forum['name'];?></a></div>
                
                <?php if(empty($forum['redirect'])) { ?>
                <div style="margin: 0; color: #999999;" class="cl">
                <div class="add-community clearTpaErr" data-v-77fc6ba8="">
                <span class="desc" data-v-77fc6ba8=""><i class="el-icon-plus" data-v-77fc6ba8=""></i><span data-v-77fc6ba8="" style="padding: 0 3px 0 0;">主题: <?php echo dnumber($forum['threads']); ?></span></span>
                <span title="帖子数" class="num textEllipsis" data-v-77fc6ba8="">帖数: <?php echo dnumber($forum['posts']); ?></span></div>
                </div>
                <?php } ?>
                
                <?php if(!empty($_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]];?>
                
                </div>
                </div>
                <div class="cl"> 
                  <?php if($forum['permission'] == 1) { ?> 
                  私密版块 
                  <?php } else { ?> 
                  <?php if($forum['redirect']) { ?> 
                  <a href="<?php echo $forumurl;?>" class="xi2">链接到外部地址</a> 
                  <?php } elseif(is_array($forum['lastpost'])) { ?> 
                  <?php if($cat['forumcolumns'] < 3) { ?> 
                  <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost" class="xi2" style="float: left; display: block; width: 60%; height: 18px; line-height: 18px; overflow: hidden; color: #2783DF; white-space: nowrap; text-overflow: ellipsis;"><?php echo cutstr($forum['lastpost']['subject'], 30); ?></a> <cite style="float: right; max-width: 62px; height: 18px; line-height: 18px; color: #666666; overflow: hidden;"><?php echo $forum['lastpost']['dateline'];?></cite> 
                  <?php } else { ?> 
                  <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost">最后发表: <?php echo $forum['lastpost']['dateline'];?></a> 
                  <?php } ?> 
                  <?php } else { ?> 
                  从未 
                  <?php } ?> 
                  <?php } ?> 
                </div>
                </div>
              <?php } else { ?>
              <div class="fl_g" width="<?php echo $cat['forumcolwidth'];?>">
                 <div class="cl" style="padding-bottom: 20px; margin-bottom: 10px; border-bottom: 1px dashed #EEEEEE;">
                <div class="fl_icn_g">
                  <?php if($forum['icon']) { ?> 
                  <?php echo $forum['icon'];?> 
                  <?php } else { ?> 
                  <a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } ?>><img src="template/elec_20220314_miaoly/style/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" /></a> 
                  <?php } ?> 
                </div>
                <div class="fl_right">
                <div style="width: 110px; height: 15px; line-height: 15px; margin: 0; overflow: hidden;" class="tit_f cl"><a href="<?php echo $forumurl;?>" style="color: #222226; font-size: 14px; font-weight: bold;" title="<?php echo $forum['name'];?>"><?php echo $forum['name'];?></a></div>
                
                <?php if(empty($forum['redirect'])) { ?>
                <div style="margin: 0; color: #999999;" class="cl">
                <div class="add-community clearTpaErr" data-v-77fc6ba8="">
                <span class="desc" data-v-77fc6ba8=""><i class="el-icon-plus" data-v-77fc6ba8=""></i><span data-v-77fc6ba8="" style="padding: 0 3px 0 0;">主题: <?php echo dnumber($forum['threads']); ?></span></span>
                <span title="帖子数" class="num textEllipsis" data-v-77fc6ba8="">帖数: <?php echo dnumber($forum['posts']); ?></span></div>
                </div>
                <?php } ?>
                
                <?php if(!empty($_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]];?>
                
                </div>
                </div>
                <div class="cl"> 
                  <?php if($forum['permission'] == 1) { ?> 
                  私密版块 
                  <?php } else { ?> 
                  <?php if($forum['redirect']) { ?> 
                  <a href="<?php echo $forumurl;?>" class="xi2">链接到外部地址</a> 
                  <?php } elseif(is_array($forum['lastpost'])) { ?> 
                  <?php if($cat['forumcolumns'] < 3) { ?> 
                  <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost" class="xi2" style="float: left; display: block; width: 60%; height: 18px; line-height: 18px; overflow: hidden; color: #2783DF; white-space: nowrap; text-overflow: ellipsis;"><?php echo cutstr($forum['lastpost']['subject'], 30); ?></a> <cite style="float: right; max-width: 62px; height: 18px; line-height: 18px; color: #666666; overflow: hidden;"><?php echo $forum['lastpost']['dateline'];?></cite> 
                  <?php } else { ?> 
                  <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost">最后发表: <?php echo $forum['lastpost']['dateline'];?></a> 
                  <?php } ?> 
                  <?php } else { ?> 
                  从未 
                  <?php } ?> 
                  <?php } ?> 
                </div>
              </div>
              <?php } ?> 
              <?php } ?> 
              <?php echo $cat['endrows'];?>
          </div>
        </div>
      </div>
      <?php echo adshow("intercat/bm a_c/$cat[fid]");?> 
      <?php } ?> 
      <?php if(!empty($collectiondata['data'])) { ?> 
      
      <?php $forumscount = count($collectiondata['data']);?> 
      <?php $forumcolumns = 4;?> 
      
      <?php $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';?>      
      <div class="bm bmw <?php if($forumcolumns) { ?> flg<?php } ?> cl">
        <div class="bm_h cl"> <span class="o cl"> <img id="category_-2_img" src="<?php echo IMGDIR;?>/<?php echo $collapse['collapseimg_-2'];?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_-2');" /> </span>
          <h2><a href="forum.php?mod=collection">淘专辑推荐</a></h2>
        </div>
        <div id="category_-2" class="bm_c" style="<?php echo $collapse['category_-2']; ?>">
          <div cellspacing="0" cellpadding="0" class="fl_tb">
              <?php $ctorderid = 0;?> 
              <?php if(is_array($collectiondata['data'])) foreach($collectiondata['data'] as $key => $colletion) { ?> 
              <?php if($ctorderid && ($ctorderid % $forumcolumns == 0)) { ?> 
            <?php if($ctorderid < $forumscount) { ?>
              <?php } ?> 
              <?php } ?>
              <div class="fl_g"><div class="fl_icn_g"> <a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $colletion['ctid'];?>" target="_blank"><img src="template/elec_20220314_miaoly/style/forum.gif" alt="<?php echo $colletion['name'];?>" /></a> </div>
                <div>
                  <div><a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $colletion['ctid'];?>"><?php echo $colletion['name'];?></a></div>
                  <div><em>主题: <?php echo dnumber($colletion['threadnum']); ?></em>, <em>评论: <?php echo dnumber($colletion['commentnum']); ?></em></div>
                  <div> 
                    <?php if($colletion['lastpost']) { ?> 
                    <?php if($forumcolumns < 3) { ?> 
                    <a href="forum.php?mod=redirect&amp;tid=<?php echo $colletion['lastpost'];?>&amp;goto=lastpost#lastpost" class="xi2" style="display: block; width: 100%; color: #2783DF; margin-bottom: 5px;"><?php echo cutstr($colletion['lastsubject'], 30); ?></a> <cite><?php echo dgmdate($colletion[lastposttime]);?>  / <?php if($colletion['lastposter']) { ?><?php echo $colletion['lastposter'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite> 
                    <?php } else { ?> 
                    <a href="forum.php?mod=redirect&amp;tid=<?php echo $colletion['lastpost'];?>&amp;goto=lastpost#lastpost">最后发表: <?php echo dgmdate($colletion[lastposttime]);?></a> 
                    <?php } ?> 
                    <?php } else { ?> 
                    从未 
                    <?php } ?> 
                  </div>
                  <?php if(!empty($_G['setting']['pluginhooks']['index_datacollection_extra'][$colletion[ctid]])) echo $_G['setting']['pluginhooks']['index_datacollection_extra'][$colletion[ctid]];?>
                </div></div>
              <?php $ctorderid++;?> 
              
              <?php } ?> 
              <?php if(($columnspad = $ctorderid % $forumcolumns) > 0) { echo str_repeat('<div class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></div>', $forumcolumns - $columnspad);; } ?> 
          </div>
        </div>
      </div>
      
      <?php } ?> 
      
    </div>
    
    <?php if(!empty($_G['setting']['pluginhooks']['index_middle'])) echo $_G['setting']['pluginhooks']['index_middle'];?>
    <div class="wp"> 
      <!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]--> 
    </div>
    
    <?php if(empty($gid) && $_G['setting']['whosonlinestatus']) { ?>
    <div id="online" class="bm bmw oll" style="width: 838px; margin-bottom: 0; border: 0; padding: 10px 20px 5px 20px; border: 1px solid #EEEEEE; border-radius: 4px;">
      <div class="bm_h" style="border-bottom: 1px dashed #EEEEEE;">
        <?php if($detailstatus) { ?> 
        <span class="o cl"><a href="forum.php?showoldetails=no#online" title="收起/展开"><img src="<?php echo IMGDIR;?>/collapsed_no.gif" alt="收起/展开" /></a></span>
        <h2 style="float: left;"><a href="home.php?mod=space&amp;do=friend&amp;view=online&amp;type=member" style="color: #BBBBBB; font-size: 12px; font-weight: 400;" class="display_none">在线会员 - </a></h2><span><?php echo $onlinenum;?> 人在线
          - <?php echo $membercount;?> 会员( <?php echo $invisiblecount;?> 隐身), <?php echo $guestcount;?> 位游客
          <em class="display_none">- 最高记录是 <?php echo $onlineinfo['0'];?> 于 <?php echo $onlineinfo['1'];?></em> </span>
        <?php } else { ?> 
        <?php if(empty($_G['setting']['sessionclose'])) { ?> 
        <span class="o cl"><a href="forum.php?showoldetails=yes#online" title="收起/展开"><img src="<?php echo IMGDIR;?>/collapsed_yes.gif" alt="收起/展开" /></a></span> 
        <?php } ?>
        <h3> <strong> 
          <?php if(!empty($_G['setting']['whosonlinestatus'])) { ?> 
          在线会员 
          <?php } else { ?> 
          <a href="home.php?mod=space&amp;do=friend&amp;view=online&amp;type=member">在线会员</a> 
          <?php } ?> 
          </strong> <span class="xs1">- 总计 <strong><?php echo $onlinenum;?></strong> 人在线 
          <?php if($membercount) { ?>- <strong><?php echo $membercount;?></strong> 会员,<strong><?php echo $guestcount;?></strong> 位游客<?php } ?> 
          - 最高记录是 <strong><?php echo $onlineinfo['0'];?></strong> 于 <strong><?php echo $onlineinfo['1'];?></strong>.</span> </h3>
        <?php } ?> 
      </div>
          <?php if(empty($gid) && ($_G['cache']['forumlinks']['0'] || $_G['cache']['forumlinks']['1'] || $_G['cache']['forumlinks']['2'])) { ?>
    <div class="cl">
      <div id="category_lk" class="bm_c ptm"> 
        <?php if($_G['cache']['forumlinks']['0']) { ?>
        <ul class="m mbn cl" style="display: none;">
          <?php echo $_G['cache']['forumlinks']['0'];?>
        </ul>
        <?php } ?> 
        <?php if($_G['cache']['forumlinks']['1']) { ?>
        <div class="mbn cl"> <?php echo $_G['cache']['forumlinks']['1'];?> </div>
        <?php } ?> 
        <?php if($_G['cache']['forumlinks']['2']) { ?>
        <ul class="x mbm cl">
          <?php echo $_G['cache']['forumlinks']['2'];?>
        </ul>
        <?php } ?> 
      </div>
    </div>
    <?php } ?> 
      <?php if($_G['setting']['whosonlinestatus'] && $detailstatus) { ?>
      <div id="onlinelist" class="bm_c" style="padding: 0; display: none;">
        <div class="ptm pbm bbda"><?php echo $_G['cache']['onlinelist']['legend'];?></div>
        <?php if($detailstatus) { ?>
        <div class="ptm pbm">
          <ul class="cl">
            <?php if($whosonline) { ?> 
            <?php if(is_array($whosonline)) foreach($whosonline as $key => $online) { ?>            <li title="时间: <?php echo $online['lastactivity'];?>"> <img src="<?php echo STATICURL;?>image/common/<?php echo $online['icon'];?>" alt="icon" /> 
              <?php if($online['uid']) { ?> 
              <a href="home.php?mod=space&amp;uid=<?php echo $online['uid'];?>"><?php echo $online['username'];?></a> 
              <?php } else { ?> 
              <?php echo $online['username'];?> 
              <?php } ?> 
            </li>
            <?php } ?> 
            <?php } else { ?>
            <li style="width: auto">当前只有游客或隐身会员在线</li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
      </div>
      <?php } ?> 
    </div>
    <?php } ?> 
    
    
    <?php if(!empty($_G['setting']['pluginhooks']['index_bottom'])) echo $_G['setting']['pluginhooks']['index_bottom'];?> 
  </div>
    </div>
  </div>
  
  <div id="main_sidebar" style="float: right; width: 300px; min-height: 200px; margin: 43px 0 0 0;">
        <?php if(!empty($_G['setting']['pluginhooks']['index_side_top'])) echo $_G['setting']['pluginhooks']['index_side_top'];?>
                      <div class="tabBar2 cl">
          <div class="hd cl">
          <h3>帖子排行</h3>
            <ul>
  <li><em></em>每周</li>
  <li><em></em>每月</li>
</ul> 
          </div>
          <div class="bd cl">
            <div class="conWrap">
              <div class="con"> 
                
                <!--[diy=diy_con1x]--><div id="diy_con1x" class="area"><div id="framecHHDD7" class="frame move-span cl frame-1"><div id="framecHHDD7_left" class="column frame-1-c"><div id="framecHHDD7_left_temp" class="move-span temp"></div><?php block_display('24');?></div></div></div><!--[/diy]--> 
                
              </div>
              <div class="con"> 
                
                <!--[diy=diy_con2x]--><div id="diy_con2x" class="area"><div id="frameyW1809" class="frame move-span cl frame-1"><div id="frameyW1809_left" class="column frame-1-c"><div id="frameyW1809_left_temp" class="move-span temp"></div><?php block_display('25');?></div></div></div><!--[/diy]--> 
                
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
jQuery(".tabBar2").slide({ mainCell:".conWrap", effect:"fold", trigger:"click", pnLoop:false });
</script>
        <div class="flowx cl" style="width: 300px; height: auto; margin: 0; box-shadow: none; overflow: hidden;">
        <!--[diy=diy6]--><div id="diy6" class="area"></div><!--[/diy]-->
        </div>
        <div id="recommendArticle">
           <!--[diy=diy7]--><div id="diy7" class="area"></div><!--[/diy]-->
        </div>
        <div id="jiang108">
           <!--[diy=diy8]--><div id="diy8" class="area"><div id="frameQ8E1B3" class="frame move-span cl frame-1"><div class="title frame-title"><span class="titletext">*请务必备注您的用户名，否则不予充值*</span></div><div id="frameQ8E1B3_left" class="column frame-1-c"><div id="frameQ8E1B3_left_temp" class="move-span temp"></div></div></div></div><!--[/diy]-->
        </div>
        <!--[diy=diy11]--><div id="diy11" class="area"><div id="frame71Dg4w" class="frame move-span cl frame-1"><div class="frame-title title"><span class="titletext" style="margin-left:90px;">PayPal扫码充值</span></div><div id="frame71Dg4w_left" class="column frame-1-c"><div id="frame71Dg4w_left_temp" class="move-span temp"></div><?php block_display('18');?></div></div><div id="frame3c1kuk" class="frame move-span cl frame-1"><div class="title frame-title"><span class="titletext" style="margin-left:50px;">其他支付方式请查看公告</span></div><div id="frame3c1kuk_left" class="column frame-1-c"><div id="frame3c1kuk_left_temp" class="move-span temp"></div></div></div></div><!--[/diy]-->
<?php if(!empty($_G['setting']['pluginhooks']['index_side_bottom'])) echo $_G['setting']['pluginhooks']['index_side_bottom'];?>
  </div>
</div>
</div>
</div>
<script type="text/javascript">
      jQuery(".flowx").sticky({ topSpacing: 20,bottomSpacing: 580});
</script>
<?php if($_G['group']['radminid'] == 1) { ?> <?php helper_manyou::checkupdate();?> 
<?php } ?> 
<?php if(empty($_G['setting']['disfixednv_forumindex']) ) { ?><script>fixed_top_nv();</script><?php } ?> 
<script type="text/javascript">jQuery(".slideBox").slide( { mainCell:".bd ul",effect:"left",easing:"easeOutQuart",delayTime:500,autoPlay:true} );jQuery(".hbody").slide({ titCell:".hd li", mainCell:".bd",delayTime:0 });</script> <?php include template('common/footer'); ?> 

