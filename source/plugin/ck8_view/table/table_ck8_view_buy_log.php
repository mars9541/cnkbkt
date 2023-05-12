<?php
if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}
class table_ck8_view_buy_log extends discuz_table{
    public function __construct() {
        $this->_table = 'ck8_view_buy_log';
        $this->_pk = 'log_id';
        parent::__construct();
    }

    public function get_view_buy_log_count($where=null){
        $sql = "SELECT count(*) as count FROM %t WHERE 1";
        $condition[] = $this->_table;
        if($where['log_id']){     
            $sql .=" AND log_id=%d ";
            $condition[] = $where['log_id'];
        }
		if($where['log_tid']){     
            $sql .=" AND log_tid=%d ";
            $condition[] = $where['log_tid'];
        }
		if($where['log_pid']){     
            $sql .=" AND log_pid=%d ";
            $condition[] = $where['log_pid'];
        }
		if($where['log_token']){     
            $sql .=" AND log_token=%d ";
            $condition[] = $where['log_token'];
        }
		if($where['log_authorid']){     
            $sql .=" AND log_authorid=%d ";
            $condition[] = $where['log_authorid'];
        }
		if($where['log_uid']){     
            $sql .=" AND log_uid=%d ";
            $condition[] = $where['log_uid'];
        }
		if($where['log_money']){     
            $sql .=" AND log_money=%d ";
            $condition[] = $where['log_money'];
        }
		if($where['log_pay_type']){     
            $sql .=" AND log_pay_type=%d ";
            $condition[] = $where['log_pay_type'];
        }
		if($where['log_pay_state']){     
            $sql .=" AND log_pay_state=%d ";
            $condition[] = $where['log_pay_state'];
        }
		if($where['log_date']){
            $sql .=" AND log_date>%d ";
            $condition[] = $where['log_date'];
        }
		if($where['log_date2']){
            $sql .=" AND log_date<%d ";
            $condition[] = $where['log_date2'];
        }
        $count = DB::fetch_first($sql,$condition);
        return $count['count'];
    }

	public function get_view_buy_log_list($start,$size,$where=null){
		$sql = "SELECT * FROM %t WHERE 1";
		$condition[] = $this->_table;
        if($where['log_id']){     
            $sql .=" AND log_id=%d ";
            $condition[] = $where['log_id'];
        }
		if($where['log_tid']){     
            $sql .=" AND log_tid=%d ";
            $condition[] = $where['log_tid'];
        }
		if($where['log_pid']){     
            $sql .=" AND log_pid=%d ";
            $condition[] = $where['log_pid'];
        }
		if($where['log_token']){     
            $sql .=" AND log_token=%d ";
            $condition[] = $where['log_token'];
        }
		if($where['log_authorid']){     
            $sql .=" AND log_authorid=%d ";
            $condition[] = $where['log_authorid'];
        }
		if($where['log_uid']){     
            $sql .=" AND log_uid=%d ";
            $condition[] = $where['log_uid'];
        }
		if($where['log_money']){     
            $sql .=" AND log_money=%d ";
            $condition[] = $where['log_money'];
        }
		if($where['log_pay_type']){     
            $sql .=" AND log_pay_type=%d ";
            $condition[] = $where['log_pay_type'];
        }
		if($where['log_pay_state']){     
            $sql .=" AND log_pay_state=%d ";
            $condition[] = $where['log_pay_state'];
        }
		if($where['log_date']){
            $sql .=" AND log_date>%d ";
            $condition[] = $where['log_date'];
        }
		if($where['log_date2']){
            $sql .=" AND log_date<%d ";
            $condition[] = $where['log_date2'];
        }
		$sql .= " ORDER BY log_id desc LIMIT %d,%d ";
		$condition[] = $start;
		$condition[] = $size;
		return DB::fetch_all($sql,$condition);
	}
	
	public function get_view_buy_log_first($where){
		$sql = "SELECT * FROM %t WHERE 1";
		$condition[] = $this->_table;
        if($where['log_id']){     
            $sql .=" AND log_id=%d ";
            $condition[] = $where['log_id'];
        }
		if($where['log_tid']){     
            $sql .=" AND log_tid=%d ";
            $condition[] = $where['log_tid'];
        }
		if($where['log_pid']){     
            $sql .=" AND log_pid=%d ";
            $condition[] = $where['log_pid'];
        }
		if($where['log_token']){     
            $sql .=" AND log_token=%d ";
            $condition[] = $where['log_token'];
        }
		if($where['log_authorid']){     
            $sql .=" AND log_authorid=%d ";
            $condition[] = $where['log_authorid'];
        }
		if($where['log_uid']){     
            $sql .=" AND log_uid=%d ";
            $condition[] = $where['log_uid'];
        }
		if($where['log_money']){     
            $sql .=" AND log_money=%d ";
            $condition[] = $where['log_money'];
        }
		if($where['log_pay_type']){     
            $sql .=" AND log_pay_type=%d ";
            $condition[] = $where['log_pay_type'];
        }
		if($where['log_pay_state']){     
            $sql .=" AND log_pay_state=%d ";
            $condition[] = $where['log_pay_state'];
        }
		if($where['log_date']){     
            $sql .=" AND log_date=%d ";
            $condition[] = $where['log_date'];
        }
		return DB::fetch_first($sql,$condition);
	}
	
    public function insert($data){
        return DB::insert($this->_table,$data,true);
    }
	
    public function update($data,$condition){
        return DB::update($this->_table,$data,$condition,true);
    }
	
    public function delete($condition){
        return DB::delete($this->_table, $condition);
    }
}
?>