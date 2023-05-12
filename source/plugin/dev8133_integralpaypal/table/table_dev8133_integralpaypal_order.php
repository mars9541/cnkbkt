<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_dev8133_integralpaypal_order extends discuz_table
{
	public function __construct() {

		$this->_table = 'dev8133_integralpaypal_order';
		$this->_pk    = 'orderid';
		parent::__construct();
	}
	
	public function count_all($where='') {
	    return DB::result_first("SELECT count(*) FROM %t %i", array($this->_table,$where));
	}
	
	public function fetch_all_by_limit($startlimit,$ppp,$where='') {
	    return DB::fetch_all("SELECT * FROM %t %i LIMIT %d,%d", array($this->_table,$where,$startlimit,$ppp));
	}
	
	public function fetch_first_field_data($field,$where='') {
	    return DB::fetch_first("SELECT %i FROM %t %i", array($field,$this->_table,$where));
	}
	
	
	public function fetch_all_byall($uid) {
	    return DB::fetch_all("SELECT tcwtype,COUNT(id) AS uidc FROM %t  WHERE uid=%d GROUP BY tcwtype ", array($this->_table,$uid));
	}

	
	public function delete_by_id($id) {
	    return DB::query("DELETE FROM %t WHERE orderid=%s", array($this->_table, $id));
	}
	
	public function update_status($s,$t) {
	    return DB::query("update %t set kstatus=2 WHERE id=%d", array($this->_table, $id));
	}
	
	public function fetch_mybuycard($where,$ppp) {
	    return DB::fetch_all("SELECT * FROM %t %i LIMIT 0,%d", array($this->_table,$where,$ppp));
    }
}
?>