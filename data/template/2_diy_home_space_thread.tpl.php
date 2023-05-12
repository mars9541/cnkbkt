<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); $filter = array( 'common' => '已发表', 'save' => '草稿箱', 'close' => '已关闭', 'aduit' => '待审核', 'ignored' => '已忽略', 'recyclebin' => '回收站');
$_G[home_tpl_spacemenus][] = "<a href=\"home.php?mod=space&amp;uid=$space[uid]&amp;do=thread&amp;view=me\">TA 的所有帖子</a>";?><?php if($diymode) { include template('home/space_header_cont_2'); include template('home/space_menu'); ?><div class="image_contain">
<div class="space_boxs">
<div class="centerbox1">

<?php } else { include template('home/space_header_cont_2'); ?><style id="diy_style" type="text/css"></style>
<div class="wp">
<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>

<div class="cl">

<div class="container-area-left"><!-- home/space_my_nav --></div>

<div class="container-area-right cl">
<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->



<div class="bg-box-radius">
<div class="middle-title-wrap border-bottom">
<h2 class="middle-title">我的帖子</h2>
</div>
<div class="tab-menu-info">
<ul class="sort-show-wrap">
<li>
<span>分类</span>
<div class="sort-list-box">
<a href="home.php?mod=space&amp;do=thread&amp;view=we" <?php echo $actives['we'];?>>好友的帖子</a>
<a href="home.php?mod=space&amp;do=thread&amp;view=me" <?php echo $actives['me'];?>>我的帖子</a>						
</div>
</li>
</ul>
</div>
</div>
<br/>
<div class="bg-box-radius">

<div class="centerbox1 border-bottom">

<?php } ?>
<style>
.tl .num {width: 80px;}
.tl .by, .tl .num {line-height: 22px;}
.tl .th {background: transparent;}
.tl tr:hover th, .tl tr:hover td {background-color: #FFF;}
.tl table {border-collapse: collapse;}
.tl th, .tl td {padding: 12px 0;}
</style>
<?php if(!$diymode && $space['self']) { if($_GET['view'] == 'me') { ?>
<p class="tbmu bw0">
<?php if($viewtype != 'postcomment') { ?>
<span class="y">
<a href="home.php?mod=space&amp;uid=<?php echo $space['uid'];?>&amp;do=thread&amp;view=me&amp;type=<?php echo $viewtype;?>&amp;from=<?php echo $_GET['from'];?>&amp;filter=" <?php if(!$_GET['filter']) { ?>class="a"<?php } ?>>全部</a><?php if(is_array($filter)) foreach($filter as $key => $name) { ?><span class="pipe">|</span><a href="home.php?mod=space&amp;do=thread&amp;view=me&amp;type=<?php echo $viewtype;?>&amp;from=<?php echo $_GET['from'];?>&amp;filter=<?php echo $key;?>" <?php if($key == $_GET['filter']) { ?>class="a"<?php } ?>><?php echo $name;?></a><?php } ?> &nbsp;
<select name="forumlist" id="forumlist" class="ps vm" onchange="viewforumthread(this.value);" style="width: 120px; word-wrap: normal;">
<option value="0">选择版块</option>
<?php echo $forumlist;?>
</select>
</span>
<?php } ?>
<a href="home.php?mod=space&amp;do=thread&amp;view=me&amp;type=thread" <?php echo $orderactives['thread'];?>>主题</a><span class="pipe">|</span>
<a href="home.php?mod=space&amp;do=thread&amp;view=me&amp;type=reply" <?php echo $orderactives['reply'];?>>回复</a><span class="pipe">|</span>
<a href="home.php?mod=space&amp;do=thread&amp;view=me&amp;type=postcomment" <?php echo $orderactives['postcomment'];?>>点评</a>
<?php if($viewtype != 'reply' && $viewtype != 'postcomment') { ?>&nbsp; <input type="text" id="searchmypost" class="px vm" size="15" /> <button class="pn vm" onclick="searchpostbyusername($('searchmypost').value, '<?php echo $_G['username'];?>');"><em>搜索</em></button><?php } ?>
</p>
<?php } elseif($_GET['view'] == 'all') { ?>
<p class="tbmu bw0">
<a href="home.php?mod=space&amp;do=thread&amp;view=all&amp;order=dateline" <?php echo $orderactives['dateline'];?>>最新帖子</a><span class="pipe">|</span>
<a href="home.php?mod=space&amp;do=thread&amp;view=all&amp;order=hot" <?php echo $orderactives['hot'];?>>热门帖子</a>
</p>
<?php } } if($diymode && !$_G['setting']['homepagestyle'] ) { ?>
<p class="tbmu" style="display: none;">
<a href="home.php?mod=space&amp;uid=<?php echo $space['uid'];?>&amp;do=thread&amp;view=me&amp;from=space&amp;type=thread" <?php echo $orderactives['thread'];?>>主题</a>
<span class="pipe">|</span>
<a href="home.php?mod=space&amp;uid=<?php echo $space['uid'];?>&amp;do=thread&amp;view=me&amp;from=space&amp;type=reply" <?php echo $orderactives['reply'];?>>回复</a>
</p>
<?php } if($userlist) { ?>
<p class="tbmu bw0">
按好友查看
<select name="fuidsel" onchange="fuidgoto(this.value);" class="ps">
<option value="">全部好友</option><?php if(is_array($userlist)) foreach($userlist as $value) { ?><option value="<?php echo $value['fuid'];?>"<?php echo $fuid_actives[$value['fuid']];?>><?php echo $value['fusername'];?></option>
<?php } ?>
</select>
</p>
<?php } ?>
<div class="tl">
<form method="post" autocomplete="off" name="delform" id="delform" action="home.php?mod=space&amp;do=thread&amp;view=all&amp;order=dateline" onsubmit="showDialog('确定要删除选中的主题吗？', 'confirm', '', '$(\'delform\').submit();'); return false;">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="delthread" value="true" />

<table cellspacing="0" cellpadding="0">
<tr class="th" style="display: none;">
<td class="icn">&nbsp;</td>
<?php if($_GET['view'] == 'all' && $pruneperm && !$_GET['archiveid']) { ?>
<td class="o">&nbsp;</td>
<?php } ?>
<th><?php if($viewtype == 'reply' || $viewtype == 'postcomment') { ?>帖子<?php } else { ?>主题<?php } ?></th>
<td class="frm">版块<?php if($actives['me'] && $space['uid'] == $_G['uid']) { ?>/群组<?php } ?></td>
<?php if($viewtype != 'postcomment') { if(!$actives['me']) { ?>
<td class="by">作者</td>
<?php } ?>
<td class="num">回复/查看</td>
<?php if($actives['me']) { ?>
<td class="by"><cite>最后发帖</cite></td>
<?php } } ?>
</tr>

<?php if($list) { ?>
                    <ul class="post post-works cl" id="itemContainer"><?php if(is_array($list)) foreach($list as $stid => $thread) { $quater_get_id = substr($thread[tid], -1); $cover = DB::result(DB::query("SELECT count(*) FROM ".DB::table('forum_attachment_'.$quater_get_id.'')." WHERE tid = '$thread[tid]' and isimage = '1'"));?><li>
      <div class="shade"></div>
      <div class="cover pos">
      <?php if($cover >= 1) { ?>		  
  
  <?php $quater_get_id = substr($thread[tid], -1); $tupian = DB::fetch_all("SELECT * FROM ".DB::table('forum_attachment_'.$quater_get_id.'')." WHERE tid = '$thread[tid]' AND isimage = '1' ORDER BY 'aid' DESC LIMIT 1");?>      <?php if(is_array($tupian)) foreach($tupian as $tp) { $imagelistkey = getforumimg($tp[aid], 0, 280, 172);?><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;<?php if($_GET['archiveid']) { ?>archiveid=<?php echo $_GET['archiveid'];?>&amp;<?php } ?>extra=<?php echo $extra;?>"<?php echo $thread['highlight'];?><?php echo $thread['highlight'];?><?php if($thread['isgroup'] == 1 || $thread['forumstick']) { ?> target="_blank"<?php } else { ?> onclick="atarget(this)"<?php } ?> style="color: #333333;"><?php if($thread['displayorder'] == -1) { ?><img class="imgloadinglater" src="template/elec_20220314_miaoly/style/nophoto2.jpg" width="280" height="172" style="width: 280px; height: auto;"><em>已删除</em><?php } else { ?><img class="imgloadinglater" src="<?php echo $imagelistkey;?>"><?php } ?></a>
<?php } } else { ?>
<a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;<?php if($_GET['archiveid']) { ?>archiveid=<?php echo $_GET['archiveid'];?>&amp;<?php } ?>extra=<?php echo $extra;?>"<?php echo $thread['highlight'];?><?php echo $thread['highlight'];?><?php if($thread['isgroup'] == 1 || $thread['forumstick']) { ?> target="_blank"<?php } else { ?> onclick="atarget(this)"<?php } ?> style="color: #333333;"><?php if($thread['displayorder'] == -1) { ?><img class="imgloadinglater" src="template/elec_20220314_miaoly/style/nophoto2.jpg" width="280" height="172" style="width: 280px; height: auto;"><em>已删除</em><?php } else { ?><img class="imgloadinglater" src="template/elec_20220314_miaoly/style/nophoto2.jpg" width="280" height="172" style="width: 280px; height: auto;"><?php } ?></a>
<?php } ?>
      </div>
      <div class="info">
        <h4 class="tits ellipsis download"><?php echo $thread['subject'];?></h4>
        <div class="msg mtn cl"><span style="color: rgba(0,0,0,.5); font-family: PingFang SC,Hiragino Sans GB,Microsoft YaHei,STHeiti,WenQuanYi Micro Hei,Helvetica,Arial,sans-serif;"><?php echo $thread['views'];?> 浏览</span> <span></div>
      </div>
      <div class="line"></div>
    </li>
<?php } ?>
                        </ul>
<?php } else { ?>
<tr>
<td colspan="<?php if($viewtype != 'postcomment') { if(($_GET['view'] == 'all' && $pruneperm && !$_GET['archiveid'])) { ?>6<?php } else { ?>5<?php } } else { ?>3<?php } ?>"><p class="emp">还没有相关的帖子</p></td>
</tr>
<?php } ?>
</table>

<?php if($_GET['view'] == 'all' && $pruneperm && !$_GET['archiveid'] && $list) { ?>
<p class="mtm pns">
<label for="chkall" onclick="checkall(this.form, 'moderate')"><input type="checkbox" name="chkall" id="chkall" class="pc vm" />全选</label>
<button type="submit" name="delsubmit" value="true" class="pn vm"><em>删除选中主题</em></button>
</p>
<?php } ?>
</form>

<?php if($hiddennum) { ?>
<p class="mtm" style="display: none;">本页有 <?php echo $hiddennum;?> 篇帖子因隐私问题而隐藏</p>
<?php } ?>
</div>
<?php if($multi) { ?><div class="pgs cl mtm"><?php echo $multi;?></div><?php } ?>		

<script type="text/javascript">
function fuidgoto(fuid) {
window.location.href = 'home.php?mod=space&do=thread&view=we&fuid='+fuid;
}
function viewforumthread(fid) {
window.location.href = '<?php echo $forumurl;?>&fid='+fid;
}
</script>

<?php if(!$_G['setting']['homepagestyle']) { ?><!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]--><?php } if($diymode) { ?>

</div>
</div>
</div>
<?php } else { ?>

</div>
</div>

</div>
</div>
<?php } if(!$_G['setting']['homepagestyle']) { ?>
<div class="wp mtn">
<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>
<?php } include template('home/space_footer_cont_2'); ?>