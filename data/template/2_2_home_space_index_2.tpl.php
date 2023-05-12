<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include TPLDIR.'/home/function/function.php';?><style type="text/css">
.pg a.nxt, .pg a.prev { float: none}
@media (max-width: 1200px) {
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
.post li { height: 86px !important}
.post .info { height: 86px !important}
.post .cover { width: 120px !important; height: 86px !important}
.post .info .msg { display: none !important}
}
</style>
<div class="cl">
<div class="image_contain">
<div class="cl">
<div class="cl">
<?php if($threadlist) { ?>
<div class="cl">
<ul class="post post-works cl" id="itemContainer">
 <?php if(is_array($threadlist)) foreach($threadlist as $thread) { $pic=get_thread_aid($thread[tid]);?>                <?php $getimage =""?>                <?php $table='forum_attachment_'.substr($thread['tid'], -1);?>                <?php $getimage = DB::fetch_first("SELECT aid,attachment FROM ".DB::table($table)." WHERE tid='$thread[tid]' AND readperm=0 AND price=0 AND isimage!=0 ORDER BY `dateline` ASC LIMIT 0,1");?>    <li>
      <div class="shade"></div>
      <div class="cover pos"> <a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>" target="_blank" title="<?php echo title;?>"><?php if($getimage) { ?><img src="<?php echo(getforumimg($pic[aid],0,220,160))?>" title="<?php echo $thread['subject'];?>" alt="<?php echo $thread['subject'];?>" class="imgloadinglater"><?php } else { ?><img src="template/elec_20220314_miaoly/style/nophoto2.jpg" title="<?php echo $thread['subject'];?>" alt="<?php echo $thread['subject'];?>" class="imgloadinglater" width="220"><?php } ?></a></div>
      <div class="info">
        <h4 class="tits download"><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>" target="_blank" title="<?php echo title;?>"><?php echo $thread['subject'];?></a></h4>
        <div class="cl" style="    margin-top: 10px;
    font-size: 14px;
    color: #838a92;
    line-height: 20px;
    letter-spacing: 0;
    text-align: justify;
    max-height: 40px;
    overflow: hidden;"><?php echo cutstr($thread['message'],180); ?></div>
        <div class="msg mtn cl" style="color: #999999;"><span style="float: left;">时间：<?php echo date("Y-m-d", $thread['dateline']); ?></span>
        <span style="float: left; color: #E8E8E8; padding: 0 10px; margin: 2px 0 0 0; height: 12px; line-height: 12px;"></span>
        <span style="float: left;">阅读：<?php echo $thread['views'];?></span>
        </div>
      </div>
      <div class="line"></div>
    </li>
  <?php } ?>
</ul>
</div>

<?php if($pagenav) { ?>
<div class="pages">
<?php echo $pagenav;?>
</div>
<?php } } else { ?>

<div class="work-null">
<div class="work-null-inner" style="padding-top: 113.25px;">
<span class="null-images"></span>
<div class="work-null-tips">
<p class="subject-title">TA还没有发布过任何创作</p>
</div>
</div>
</div>

<?php } ?>

</div>

</div>

</div>
</div>
