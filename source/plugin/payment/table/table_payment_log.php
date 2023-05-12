<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class table_payment_log extends discuz_table {
    public function __construct() {
        $this->_table = 'payment_log';
        $this->_pk    = 'log_id';

        parent::__construct();
    }
    public function add($uid, $order_id, $type, $type_id = '', $params = []) {

    }
}
?>