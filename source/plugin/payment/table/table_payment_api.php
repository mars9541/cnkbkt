<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_payment_api extends discuz_table {
	public function __construct() {
		$this->_table = 'payment_api';
		$this->_pk = 'api_id';
		parent::__construct();
	}
}
?>