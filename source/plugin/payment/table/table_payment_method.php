<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class table_payment_method extends discuz_table {
    public function __construct() {
        $this->_table = 'payment_method';
        $this->_pk    = 'method_id';
        parent::__construct();
    }

    public function fetch($method_id) {
        $item = parent::fetch($method_id);
        if ($item) {
            $item['setting'] = unserialize($item['setting']);
        }
        return $item;
    }
}
?>