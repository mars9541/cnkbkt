<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_csu_pay_credit {
	public function csu_pay_credit($method) {
		global $_G;
		if ($_G['cache']['plugin']['csu_pay_credit']['pc'] == $method) {
			return $_G['cache']['plugin']['csu_pay_credit']['pc_content'];
		}
	}
	public function global_cpnav_extra1() {
		return $this->csu_pay_credit(__FUNCTION__);
	}
	public function global_cpnav_extra2() {
		return $this->csu_pay_credit(__FUNCTION__);
	}
	public function global_usernav_extra1() {
		return $this->csu_pay_credit(__FUNCTION__);
	}
	public function global_usernav_extra2() {
		return $this->csu_pay_credit(__FUNCTION__);
	}
	public function global_usernav_extra3() {
		return $this->csu_pay_credit(__FUNCTION__);
	}
	public function global_usernav_extra4() {
		return $this->csu_pay_credit(__FUNCTION__);
	}
}
?>