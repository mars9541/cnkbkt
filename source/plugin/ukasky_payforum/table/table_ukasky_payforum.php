<?php
/**
 *
 * Ukasky BBS [http://bbs.ukasky.com]
 * @author Mr. Chen
 * My Blog: http://chen.disyo.com
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 *
 * 数据表
 * @author CHEN
 *
 */

class table_ukasky_payforum extends discuz_table{
	
	public function __construct() {

		$this->_table = 'ukasky_payforum';
		$this->_pk    = 'id';

		parent::__construct();
	}
}