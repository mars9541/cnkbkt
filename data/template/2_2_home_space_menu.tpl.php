<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if($space['uid']) { $member_count = get_member_count($space[uid]);?><?php $member_profile = get_member_profile($space[uid]);?><?php loaducenter(); $uc_avatarflash = uc_avatar($_G['uid'], 'virtual', 0);?><link rel="stylesheet" type="text/css" href="template/elec_20220314_miaoly/style/css/menhu.css" />
<link rel="stylesheet" type="text/css" id="time_diy" href="template/elec_20220314_miaoly/portal/containers-Home-f69b2f80.css" />
<script src="template/elec_20220314_miaoly/style/js/jquery.superslide.js" type="text/javascript" type="text/javascript"></script>
<script src="template/elec_20220314_miaoly/home/js/sticky.js" type="text/javascript" type="text/javascript"></script>
<style id="diy_style"><?php echo $space['spacecss'];?></style>
<style type="text/css">
@media (max-width: 1200px) {
.section .wp { width: 100% !important}
.index_right { display: none}
.b_left { float: none !important; width: 100% !important; height: 220px !important; margin: 0 !important}
.b_right { display: none}
.banner {
position: relative;
width: 100%;
height: 220px;
border-radius: 0;
overflow: hidden;
}
.banner .pic a { display: block; height: 220px !important; overflow: hidden}
.banner .pic li { height: 220px !important; overflow: hidden}
.banner .pic img { width: 100% !important; height: auto !important}
.boxx1 { width: 100% !important}
.banner_r { width: 100% !important}
.tabBar .hd { width: 100% !important; padding: 12px 0 0 0 !important; margin-bottom: 0 !important}
.tabBar .hd ul { float: left !important; margin: 10px 0 0 0 !important}
.tabBar .hd li { margin: 0 5.5% 0 0 !important; border: 0 !important}
.tabBar .hd li:last-child { margin: 0 !important}
.tabBar .hd li.on { height: 24px !important}
.get-mod-more a, .more_box a { width: 100% !important; box-sizing: border-box}
.left_sides { width: 100% !important}
.right_sides { float: left !important; width: 100% !important; margin: 0 !important; min-height: 50px !important}
.right-ad-oneself, .sticky-wrapper, .right-tags { display: none !important}
.post .info .tits { display: block; width: auto; height: 31px; line-height: 31px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis}
.post li img { width: 100% !important; height: auto !important}
.post-works .cover a { width: 100% !important}
.pf_l li { width: 50% !important}
}
</style>
</div>
<div class="section cl">
<div class="wp cl" style="margin: 20px auto 0 auto;">
<a href="#"><img src="template/elec_20220314_miaoly/style/ad/广告位招租.png" width="100%"></a>
</div>
<div class="wp no_re cl" style="position: relative; padding-top: 20px;">
<div class="right_sides y cl" style="width: 360px; min-height: 500px;">
<div class="cl" s style="margin-bottom: 20px;">
    <div class="cl">
    <div class="cl" style="width: 100%; height: 2px; background: #FF6651;"></div>
    <div class="cl" style="padding: 20px; border-radius: 0; border: 1px solid #EEEEEE; border-top: 0;">
     <div class="mem_user1">
       <div class="member_box cl">
<div class="h-avatar cl">
<img src="<?php echo avatar($space['uid'],'middle',1);; ?>" id="h-avatar">
            <?php if($_G['uid'] == $space['uid']) { ?>
<a href="home.php?mod=spacecp&amp;ac=avatar" title="更换头像" class="avatar-cover">
更换头像
</a>
<?php } ?>
</div>
        <div class="z cl" style="padding: 5px 0 0 0;">
         <div class="h-basic cl">
          <span id="h-name" class="z"><?php echo $space['username'];?></span>
               <?php if($_G['uid'] == $space['uid']) { ?>
 <?php } else { ?>
     <div class="h-action z">
        <span class="h-f-btn h-follow">
           <?php if(!ckfollow($space['uid'])) { ?>
<a id="followmod" onclick="showWindow(this.id, this.href, 'get', 0);" href="home.php?mod=spacecp&amp;ac=follow&amp;op=add&amp;hash=<?php echo FORMHASH;?>&amp;fuid=<?php echo $space['uid'];?>" title="关注TA">
关注
</a>
<?php } else { ?>
<a id="followmod" onclick="showWindow(this.id, this.href, 'get', 0);" href="home.php?mod=spacecp&amp;ac=follow&amp;op=del&amp;fuid=<?php echo $space['uid'];?>" title="已关注">
已关注
</a>
<?php } ?></span>
                <a href="home.php?mod=spacecp&amp;ac=pm&amp;op=showmsg&amp;handlekey=showmsg_<?php echo $space['uid'];?>&amp;touid=<?php echo $space['uid'];?>&amp;pmid=0&amp;daterange=2" id="a_sendpm_<?php echo $space['uid'];?>" onclick="showWindow('showMsgBox', this.href, 'get', 0)" title="私信" class="h-f-btn1 h-message" style="display: none;">
发消息
</a>
     </div>
     <?php } ?>
         </div>
              <div class="cl" style="margin: 18px 0 0 0; font-size: 14px; color: #666666;">
            <a target="_blank" class="fans" style="color: #666666; margin: 0 28px 0 0;">粉丝：
                <span>
                    <?php echo $member_count['follower'];?></span></a>
            <em></em>
            <a href="home.php?mod=follow&amp;uid=<?php echo $space['uid'];?>&amp;do=view&amp;from=space" style="color: #666666;">主题：<span>
                    <?php echo $member_count['threads'];?></span></a>
            <em></em>
        </div>
         </div>
       </div>
       <div class="h-basic-spacing cl">
          <span style="float: left;">
          <?php if($member_profile['bio']) { ?><?php echo $member_profile['bio'];?><?php } else { ?>这个人很懒什么都没写<?php } ?>
          </span>
          <?php if($_G['uid'] == $space['uid']) { ?>
<a href="home.php?mod=spacecp&amp;ac=profile&amp;op=info" title="修改资料" class="change">
</a>
  <?php } ?>
         </div>
     </div>
     </div>
    </div>
</div>
<div class="right-ad-oneself" style="display:block">
  <div class="right-ad-oneself-container">
    <div class="right-ad-oneself-list clearfix" rel="nofollow"><a href="https://www.cnkbtk.com/forum.php?mod=forumdisplay&amp;fid=36" class="right-ad-oneself-icon" target="_blank"><img src="template/elec_20220314_miaoly/style/video.png" title="原创视频" alt="原创视频"></a>
      <div class="right-ad-oneself-text" title="原创视频">
        <div class="right-ad-oneself-text-sp"><a href="https://www.cnkbtk.com/forum.php?mod=forumdisplay&amp;fid=36" target="_blank">
          <h5>原创视频</h5>
          </a><a class="right-ad-oneself-app-btn right-ad-oneself-text-sp-off" href="https://www.cnkbtk.com/forum.php?mod=forumdisplay&amp;fid=36" target="_blank">0
          <div class="right-ad-oneself-app-btn-img"></div>
          </a></div>
        <a href="https://www.cnkbtk.com/forum.php?mod=forumdisplay&amp;fid=36" target="_blank">
        <p>入驻制作组的原创作品</p>
        </a></div>
    </div>
    <div class="right-ad-oneself-list clearfix" rel="nofollow"><a href="https://www.cnkbtk.com/forum.php?mod=forumdisplay&amp;fid=73" class="right-ad-oneself-icon" target="_blank"><img src="template/elec_20220314_miaoly/style/用户交流中心.png" title="用户交流中心" alt="用户交流中心"></a>
      <div class="right-ad-oneself-text" title="用户交流中心">
        <div class="right-ad-oneself-text-sp"><a href="https://www.cnkbtk.com/forum.php?mod=forumdisplay&amp;fid=73" target="_blank">
          <h5>用户交流中心</h5>
          </a><a class="right-ad-oneself-app-btn right-ad-oneself-text-sp-off" href="https://www.cnkbtk.com/forum.php?mod=forumdisplay&amp;fid=73" target="_blank">0
          <div class="right-ad-oneself-app-btn-img"></div>
          </a></div>
        <a href="#" target="_blank">
        <p>在此交流资源，约现，约拍题材……</p>
        </a></div>
    </div>
  </div>
</div>
<div class="right-tags" style="display: block;"><a class="right-tags-title">热门标签</a>
  <div class="right-tags-cont">
  <a style="display:flex" href="https://www.cnkbtk.com/misc.php?mod=tag&amp;id=11" target="_blank" title="KB">KB</a>
  <a style="display:flex" href="https://www.cnkbtk.com/misc.php?mod=tag&amp;id=1" target="_blank" title="TK">TK</a>
 </div>
</div>
</div>
<script type="text/javascript">
      jQuery(".right-tags").sticky({ topSpacing: 20,bottomSpacing: 580});
</script>
<div class="wp left_sides no_re cl" style="position: relative; float: left; width: 800px; padding: 0; margin: 0 auto; border: 0; border-radius: 4px;">

<?php if(helper_access::check_module('follow')) { ?>
<script type="text/javascript">
function succeedhandle_followmod(url, msg, values) {
var fObj = $('followmod');
if(values['type'] == 'add') {
fObj.innerHTML = '取消收听';
fObj.href = 'home.php?mod=spacecp&ac=follow&op=del&fuid='+values['fuid'];
} else if(values['type'] == 'del') {
fObj.innerHTML = '收听TA';
fObj.href = 'home.php?mod=spacecp&ac=follow&op=add&hash=<?php echo FORMHASH;?>&fuid='+values['fuid'];
}
}
</script>
<?php } } ?>
