<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('index');?><?php include template('common/header'); ?><link rel="stylesheet" type="text/css" href='template/elec_20220314_miaoly/group/group.css' />


<div id="pt" class="bm cl">


<div class="z">


<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a><em>&raquo;</em><a href="group.php"><?php echo $_G['setting']['navs']['3']['navname'];?></a><?php echo $navigation;?>


</div>


</div><?php echo adshow("text/wp a_t");?><style id="diy_style" type="text/css"></style>


<div class="wp">


<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->


</div>


<div id="ct" class="ct2 wp cl">


<div class="mn">


<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->


<!--[diy=diycommendtop]--><div id="diycommendtop" class="area"></div><!--[/diy]-->


<?php if(!empty($_G['setting']['pluginhooks']['index_header'])) echo $_G['setting']['pluginhooks']['index_header'];?>





<!--[diy=diycategorytop]--><div id="diycategorytop" class="area"></div><!--[/diy]-->


<?php if(!empty($_G['setting']['pluginhooks']['index_top'])) echo $_G['setting']['pluginhooks']['index_top'];?>


<div class="bm">


<div class="bm_h cl">


<h3><?php echo $_G['setting']['navs']['3']['navname'];?>分类</h3>


</div>


<div class="bm_c" style="padding: 10px 3px;"><?php if(is_array($first)) foreach($first as $groupid => $group) { ?><dl class="mbm pbm bbda">


<dt class="pbn">


<span class="y xi2"><?php if(is_array($group['secondlist'])) foreach($group['secondlist'] as $fid) { ?><a href="group.php?sgid=<?php echo $fid;?>"><?php echo $second[$fid]['name'];?></a> <?php } ?><a href="group.php?gid=<?php echo $groupid;?>">更多 &rsaquo;</a></span>


<strong class="xs2"><a href="group.php?gid=<?php echo $groupid;?>"><?php echo $group['name'];?></a></strong><?php if($group['groupnum']) { ?><span class="xg1">(<?php echo $group['groupnum'];?>)</span><?php } ?>


</dt>


<dd><?php if(is_array($lastupdategroup[$groupid])) foreach($lastupdategroup[$groupid] as $val) { ?><a href="forum.php?mod=group&amp;fid=<?php echo $val['fid'];?>"><?php echo $val['name'];?></a> &nbsp;&nbsp;


<?php } ?>


</dd>


</dl>


<?php } ?>


</div>


</div>


<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->


<?php if(!empty($_G['setting']['pluginhooks']['index_bottom'])) echo $_G['setting']['pluginhooks']['index_bottom'];?>


</div>





<div class="sd">


<div class="drag">


<!--[diy=diysidetop]--><div id="diysidetop" class="area"></div><!--[/diy]-->


</div>


            				<?php if(helper_access::check_module('group')) { ?>


                            <div class="cl" style="padding: 15px; box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.02); background: #FFFFFF;">


                             <div class="thread_post cl">


                              <a href="forum.php?mod=group&amp;action=create" id="create_group_btn">创建新的群组</a>


                             </div>


                            </div>


                            <?php } ?>


<?php if(!empty($_G['setting']['pluginhooks']['index_side_top'])) echo $_G['setting']['pluginhooks']['index_side_top'];?>


<?php if(helper_access::check_module('group')) { if(empty($gid) && empty($sgid)) { ?>


<div class="bm" style="padding-top: 0;">


<div class="bm_h cl">


<h2 style="padding-left: 8px;">创建<?php echo $_G['setting']['navs']['3']['navname'];?>步骤</h2>


</div>


<div class="bm_c">


<ul id="g_guide" class="mbm">


<li><label><strong class="xi1">创建<?php echo $_G['setting']['navs']['3']['navname'];?></strong><span class="xg1">创建自己的地盘</span></label></li>


<li><label><strong class="xi1">个性设置</strong><span class="xg1">精心打造<?php echo $_G['setting']['navs']['3']['navname'];?>空间</span></label></li>


<li><label><strong class="xi1">邀请好友</strong><span class="xg1">邀请好友加入我的<?php echo $_G['setting']['navs']['3']['navname'];?></span></label></li>


<li><label><strong class="xi1"><?php echo $_G['setting']['navs']['3']['navname'];?>升级</strong><span class="xg1"><?php echo $_G['setting']['navs']['3']['navname'];?>积分升级赢得社区推荐</span></label></li>


</ul>


</div>


</div>


<?php } else { ?>


<div class="bm bw0">


<div class="bm_c">


<a href="forum.php?mod=group&amp;action=create&amp;fupid=<?php echo $fup;?>&amp;groupid=<?php echo $sgid;?>" id="create_group_btn"><img src="<?php echo IMGDIR;?>/create_group.png" alt="创建<?php echo $_G['setting']['navs']['3']['navname'];?>" /></a>


</div>


</div>


<?php } } ?>


<div class="bm">


               <div class="bm_h cl">


      <h2 style="padding-left: 8px;">推荐群组</h2>


   </div>


   <!--[diy=diysidemiddle]--><div id="diysidemiddle" class="area"></div><!--[/diy]-->


</div>


<div class="drag">


<!--[diy=diysidebottom]--><div id="diysidebottom" class="area"></div><!--[/diy]-->


</div>


<?php if(!empty($_G['setting']['pluginhooks']['index_side_bottom'])) echo $_G['setting']['pluginhooks']['index_side_bottom'];?>


</div>


</div>





<div class="wp mtn">


<!--[diy=diy4]--><div id="diy4" class="area"></div><!--[/diy]-->


</div><?php include template('common/footer'); ?>