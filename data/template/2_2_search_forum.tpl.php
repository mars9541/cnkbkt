<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('forum');
0
|| checktplrefresh('./template/elec_20220314_miaoly/search/forum.htm', './template/elec_20220314_miaoly/search/pubsearch.htm', 1677502412, '2', './data/template/2_2_search_forum.tpl.php', './template/elec_20220314_miaoly', 'search/forum')
|| checktplrefresh('./template/elec_20220314_miaoly/search/forum.htm', './template/elec_20220314_miaoly/search/thread_list.htm', 1677502412, '2', './data/template/2_2_search_forum.tpl.php', './template/elec_20220314_miaoly', 'search/forum')
;?><?php include template('common/header'); ?><div id="ct" class="cl w">
<div class="mw">
<form class="searchform" method="post" autocomplete="off" action="search.php?mod=forum" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" /><link rel="stylesheet" type="text/css" id="time_diy" href="template/elec_20220314_miaoly/style/css/search.css" /><?php $keywordenc = $keyword ? rawurlencode($keyword) : '';?><?php if($searchid || ($_GET['adv'] && CURMODULE == 'forum')) { ?>


<div id="scform" class="mbm" cellspacing="0" cellpadding="0">


<div>


<div>


<div id="scform_tb" class="cl">


<?php if(CURMODULE == 'forum') { ?>


<span class="y">


<a href="javascript:;" id="quick_sch" class="showmenu" onmouseover="delayShow(this);">快速</a>


<?php if(CURMODULE == 'forum') { ?>


<a href="search.php?mod=forum&amp;adv=yes<?php if($keyword) { ?>&amp;srchtxt=<?php echo $keywordenc;?><?php } ?>">高级</a>


<?php } ?>


</span>


<?php } if($_G['setting']['portalstatus'] && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)) { ?><?php
$slist[portal] = <<<EOF
<a href="search.php?mod=portal
EOF;
 if($keyword) { 
$slist[portal] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[portal] .= <<<EOF
"
EOF;
 if(CURMODULE == 'portal') { 
$slist[portal] .= <<<EOF
 class="a"
EOF;
 } 
$slist[portal] .= <<<EOF
>文章</a>
EOF;
?><?php } if($_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)) { ?><?php
$slist[forum] = <<<EOF
<a href="search.php?mod=forum
EOF;
 if($keyword) { 
$slist[forum] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[forum] .= <<<EOF
"
EOF;
 if(CURMODULE == 'forum') { 
$slist[forum] .= <<<EOF
 class="a"
EOF;
 } 
$slist[forum] .= <<<EOF
>帖子</a>
EOF;
?><?php } if(helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1)) { ?><?php
$slist[blog] = <<<EOF
<a href="search.php?mod=blog
EOF;
 if($keyword) { 
$slist[blog] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[blog] .= <<<EOF
"
EOF;
 if(CURMODULE == 'blog') { 
$slist[blog] .= <<<EOF
 class="a"
EOF;
 } 
$slist[blog] .= <<<EOF
>日志</a>
EOF;
?><?php } if(helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1)) { ?><?php
$slist[album] = <<<EOF
<a href="search.php?mod=album
EOF;
 if($keyword) { 
$slist[album] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[album] .= <<<EOF
"
EOF;
 if(CURMODULE == 'album') { 
$slist[album] .= <<<EOF
 class="a"
EOF;
 } 
$slist[album] .= <<<EOF
>相册</a>
EOF;
?><?php } if($_G['setting']['groupstatus'] && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)) { ?><?php
$slist[group] = <<<EOF
<a href="search.php?mod=group
EOF;
 if($keyword) { 
$slist[group] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[group] .= <<<EOF
"
EOF;
 if(CURMODULE == 'group') { 
$slist[group] .= <<<EOF
 class="a"
EOF;
 } 
$slist[group] .= <<<EOF
>{$_G['setting']['navs']['3']['navname']}</a>
EOF;
?><?php } if(helper_access::check_module('collection') && $_G['setting']['search']['collection']['status'] && ($_G['group']['allowsearch'] & 64 || $_G['adminid'] == 1)) { ?><?php
$slist[collection] = <<<EOF
<a href="search.php?mod=collection
EOF;
 if($keyword) { 
$slist[collection] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[collection] .= <<<EOF
"
EOF;
 if(CURMODULE == 'collection') { 
$slist[collection] .= <<<EOF
 class="a"
EOF;
 } 
$slist[collection] .= <<<EOF
>淘帖</a>
EOF;
?><?php } ?><?php
$slist[user] = <<<EOF
<a href="search.php?mod=user
EOF;
 if($keyword) { 
$slist[user] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[user] .= <<<EOF
"
EOF;
 if(CURMODULE == 'user') { 
$slist[user] .= <<<EOF
 class="a"
EOF;
 } 
$slist[user] .= <<<EOF
>用户</a>
EOF;
?><?php echo implode("", $slist);; ?></div>


<div id="scform_form" cellspacing="0" cellpadding="0">


<div>


<div class="td_srchtxt"><input type="text" id="scform_srchtxt" name="srchtxt" size="45" maxlength="40" value="<?php echo $keyword;?>" tabindex="1" x-webkit-speech speech /><script type="text/javascript">initSearchmenu('scform_srchtxt');$('scform_srchtxt').focus();</script></div>


<div class="td_srchbtn"><input type="hidden" name="searchsubmit" value="yes" /><button type="submit" id="scform_submit" class="schbtn"><strong>搜索</strong></button></div>


</div>


</div>


</div>


</div>


</div>


<?php } else { if(!empty($srchtype)) { ?><input type="hidden" name="srchtype" value="<?php echo $srchtype;?>" /><?php } if($srchtype != 'threadsort') { ?>


<div class="hm mtw ptw pbw"><h1 class="mtw ptw"><a href="./" title="<?php echo $_G['setting']['bbname'];?>"><img src="template/elec_20220314_miaoly/style/logo_sc.png" alt="<?php echo $_G['setting']['bbname'];?>" /></a></a></h1></div>


<div id="scform" cellspacing="0" cellpadding="0" style="margin: 0 auto;">


<div>


<div id="scform_tb" class="xs2 cl">


<?php if(CURMODULE == 'forum') { ?>


<span class="y xs1">


<a href="javascript:;" id="quick_sch" class="showmenu" onmouseover="delayShow(this);">快速</a>


<?php if(CURMODULE == 'forum') { ?>


<a href="search.php?mod=forum&amp;adv=yes">高级</a>


<?php } ?>


</span>


<?php } if(helper_access::check_module('portal') && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)) { ?><?php
$slist[portal] = <<<EOF
<a href="search.php?mod=portal
EOF;
 if($keyword) { 
$slist[portal] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[portal] .= <<<EOF
"
EOF;
 if(CURMODULE == 'portal') { 
$slist[portal] .= <<<EOF
 class="a"
EOF;
 } 
$slist[portal] .= <<<EOF
>文章</a>
EOF;
?><?php } if($_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)) { ?><?php
$slist[forum] = <<<EOF
<a href="search.php?mod=forum
EOF;
 if($keyword) { 
$slist[forum] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[forum] .= <<<EOF
"
EOF;
 if(CURMODULE == 'forum') { 
$slist[forum] .= <<<EOF
 class="a"
EOF;
 } 
$slist[forum] .= <<<EOF
>帖子</a>
EOF;
?><?php } if(helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1) && helper_access::check_module('blog')) { ?><?php
$slist[blog] = <<<EOF
<a href="search.php?mod=blog
EOF;
 if($keyword) { 
$slist[blog] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[blog] .= <<<EOF
"
EOF;
 if(CURMODULE == 'blog') { 
$slist[blog] .= <<<EOF
 class="a"
EOF;
 } 
$slist[blog] .= <<<EOF
>日志</a>
EOF;
?><?php } if(helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1) && helper_access::check_module('album')) { ?><?php
$slist[album] = <<<EOF
<a href="search.php?mod=album
EOF;
 if($keyword) { 
$slist[album] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[album] .= <<<EOF
"
EOF;
 if(CURMODULE == 'album') { 
$slist[album] .= <<<EOF
 class="a"
EOF;
 } 
$slist[album] .= <<<EOF
>相册</a>
EOF;
?><?php } if(helper_access::check_module('group') && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)) { ?><?php
$slist[group] = <<<EOF
<a href="search.php?mod=group
EOF;
 if($keyword) { 
$slist[group] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[group] .= <<<EOF
"
EOF;
 if(CURMODULE == 'group') { 
$slist[group] .= <<<EOF
 class="a"
EOF;
 } 
$slist[group] .= <<<EOF
>{$_G['setting']['navs']['3']['navname']}</a>
EOF;
?><?php } if(helper_access::check_module('collection') && $_G['setting']['search']['collection']['status'] && ($_G['group']['allowsearch'] & 64 || $_G['adminid'] == 1)) { ?><?php
$slist[collection] = <<<EOF
<a href="search.php?mod=collection
EOF;
 if($keyword) { 
$slist[collection] .= <<<EOF
&amp;srchtxt={$keywordenc}&amp;searchsubmit=yes
EOF;
 } 
$slist[collection] .= <<<EOF
"
EOF;
 if(CURMODULE == 'collection') { 
$slist[collection] .= <<<EOF
 class="a"
EOF;
 } 
$slist[collection] .= <<<EOF
>淘帖</a>
EOF;
?><?php } echo implode("", $slist);; ?><a href="search.php?mod=user<?php if($keyword) { ?>&amp;srchtxt=<?php echo $keywordenc;?>&amp;searchsubmit=yes<?php } ?>"<?php if(CURMODULE == 'user') { ?> class="a"<?php } ?>>用户</a>


</div>


</div>


<div>


<div>


<div cellspacing="0" cellpadding="0" id="scform_form">


<div>


<div class="td_srchtxt"><input type="text" id="scform_srchtxt" name="srchtxt" size="65" maxlength="40" value="<?php echo $keyword;?>" tabindex="1" /><script type="text/javascript">initSearchmenu('scform_srchtxt');$('scform_srchtxt').focus();</script></div>


<div class="td_srchbtn"><input type="hidden" name="searchsubmit" value="yes" /><button type="submit" id="scform_submit" value="true"><strong>搜索</strong></button></div>


</div>


</div>


</div>


</div>


</div>


<?php } } if(CURMODULE == 'forum') { ?>


<ul id="quick_sch_menu" class="p_pop" style="display: none;">


<li><a href="search.php?mod=forum&amp;srchfrom=3600&amp;searchsubmit=yes">1 小时以内的新帖</a></li>


<li><a href="search.php?mod=forum&amp;srchfrom=14400&amp;searchsubmit=yes">4 小时以内的新帖</a></li>


<li><a href="search.php?mod=forum&amp;srchfrom=28800&amp;searchsubmit=yes">8 小时以内的新帖</a></li>


<li><a href="search.php?mod=forum&amp;srchfrom=86400&amp;searchsubmit=yes">24 小时以内的新帖</a></li>


<li><a href="search.php?mod=forum&amp;srchfrom=604800&amp;searchsubmit=yes">1 周内帖子</a></li>


<li><a href="search.php?mod=forum&amp;srchfrom=2592000&amp;searchsubmit=yes">1 月内帖子</a></li>


<li><a href="search.php?mod=forum&amp;srchfrom=15552000&amp;searchsubmit=yes">6 月内帖子</a></li>


<li><a href="search.php?mod=forum&amp;srchfrom=31536000&amp;searchsubmit=yes">1 年内帖子</a></li>


</ul>


<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['forum_top'])) echo $_G['setting']['pluginhooks']['forum_top'];?><?php $policymsgs = $p = '';?><?php if(is_array($_G['setting']['creditspolicy']['search'])) foreach($_G['setting']['creditspolicy']['search'] as $id => $policy) { ?><?php
$policymsg = <<<EOF

EOF;
 if($_G['setting']['extcredits'][$id]['img']) { 
$policymsg .= <<<EOF
{$_G['setting']['extcredits'][$id]['img']} 
EOF;
 } 
$policymsg .= <<<EOF
{$_G['setting']['extcredits'][$id]['title']} {$policy} {$_G['setting']['extcredits'][$id]['unit']}
EOF;
?><?php $policymsgs .= $p.$policymsg;$p = ', ';?><?php } if($policymsgs) { ?><p>每进行一次搜索将扣除 <?php echo $policymsgs;?></p><?php } ?>
</form>

<?php if(!empty($searchid) && submitcheck('searchsubmit', 1)) { ?><div class="tl">
<div class="sttl mbn">
<h2><?php if($keyword) { ?>结果: <em>找到 “<span class="emfont"><?php echo $keyword;?></span>” 相关内容 <?php echo $index['num'];?> 个</em> <?php if($modfid) { ?><a href="forum.php?mod=modcp&amp;action=thread&amp;fid=<?php echo $modfid;?>&amp;keywords=<?php echo $modkeyword;?>&amp;submit=true&amp;do=search&amp;page=<?php echo $page;?>" target="_blank">进入管理面板</a><?php } } else { ?>结果: <em>找到相关主题 <?php echo $index['num'];?> 个</em><?php } ?></h2>
</div><?php echo adshow("search/y mtw");?><?php if(empty($threadlist)) { ?>
<p class="emp xs2 xg2">对不起，没有找到匹配结果。</p>
<?php } else { ?>
<div class="slst" id="threadlist" <?php if($modfid) { ?> style="position: relative;"<?php } ?>>
<?php if($modfid) { ?>
<form method="post" autocomplete="off" name="moderate" id="moderate" action="forum.php?mod=topicadmin&amp;action=moderate&amp;fid=<?php echo $modfid;?>&amp;infloat=yes&amp;nopost=yes">
<?php } ?>
<ul><?php if(is_array($threadlist)) foreach($threadlist as $thread) { ?><li class="pbw" id="<?php echo $thread['tid'];?>">
<h3 class="xs3">
<?php if($modfid) { if($thread['fid'] == $modfid && ($thread['displayorder'] <= 3 || $_G['adminid'] == 1)) { ?>
<input onclick="tmodclick(this)" type="checkbox" name="moderate[]" value="<?php echo $thread['tid'];?>" />&nbsp;
<?php } else { ?>
<input type="checkbox" disabled="disabled" />&nbsp;
<?php } } ?>
<a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['realtid'];?>&amp;highlight=<?php echo $index['keywords'];?>" target="_blank" <?php echo $thread['highlight'];?>><?php echo $thread['subject'];?></a>
</h3>
<p class="xg1"><?php echo $thread['replies'];?> 个回复 - <?php echo $thread['views'];?> 次查看</p>
<p><?php if(!$thread['price'] && !$thread['readperm']) { ?><?php echo $thread['message'];?><?php } else { ?>内容隐藏需要，请点击进去查看<?php } ?></p>
<p>
<span><?php echo $thread['dateline'];?></span>
 -
<span>
<?php if($thread['authorid'] && $thread['author']) { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $thread['authorid'];?>" target="_blank"><?php echo $thread['author'];?></a>
<?php } else { if($_G['forum']['ismoderator']) { ?><a href="home.php?mod=space&amp;uid=<?php echo $thread['authorid'];?>" target="_blank">匿名</a><?php } else { ?>匿名<?php } } ?>
</span>
 -
<span><a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $thread['fid'];?>" target="_blank" class="xi1"><?php echo $thread['forumname'];?></a></span>
</p>
</li>
<?php } ?>
</ul>
<?php if($modfid) { ?>
</form>
<script src="<?php echo $_G['setting']['jspath'];?>forum_moderate.js?<?php echo VERHASH;?>" type="text/javascript"></script><?php include template('forum/topicadmin_modlayer'); } ?>
</div>
<?php } if(!empty($multipage)) { ?><div class="pgs cl mbm"><?php echo $multipage;?></div><?php } ?>
</div>
<?php } ?>

</div>
</div>
<?php if(!empty($_G['setting']['pluginhooks']['forum_bottom'])) echo $_G['setting']['pluginhooks']['forum_bottom'];?><?php include template('common/footer'); ?>