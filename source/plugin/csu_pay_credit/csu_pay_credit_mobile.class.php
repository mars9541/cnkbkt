<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class mobileplugin_csu_pay_credit {

	public function global_footer_mobile() {
		global $_G;
		return $_G['cache']['plugin']['csu_pay_credit']['wap_content'];
	}
}
?>