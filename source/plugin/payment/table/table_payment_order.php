<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class table_payment_order extends discuz_table {
    public function __construct() {
        $this->_table = 'payment_order';
        $this->_pk    = 'order_id';
        parent::__construct();
        //DB::query('UPDATE %t SET status=3 WHERE expire_time<%d AND status=1', [$this->_table, TIMESTAMP]);
    }
    public function fetch($order_id) {
        $item = parent::fetch($order_id);
        if ($item) {
            $item['params']         = dunserialize($item['params']);
            $item['method_extends'] = dunserialize($item['method_extends']);
        }
        return $item;
    }

}
?>