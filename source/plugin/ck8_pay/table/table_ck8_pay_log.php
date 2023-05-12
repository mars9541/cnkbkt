<?php
if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}
class table_ck8_pay_log extends discuz_table{
    public function __construct() {
        $this->_table = 'ck8_pay_log';
        $this->_pk = 'p_id';
        parent::__construct();
    }

    public function get_pay_log_count($where = null){
        $sql = "SELECT count(*) as count FROM %t WHERE 1";
        $condition[] = $this->_table;
        if($where['p_id']){     
            $sql .=" AND p_id=%d ";
            $condition[] = $where['p_id'];
        }
		if($where['p_number']){
            $sql .=" AND p_number=%s ";
            $condition[] = $where['p_number'];
        }
		if($where['p_type']){
            $sql .=" AND p_type=%d ";
            $condition[] = $where['p_type'];
        }
		if($where['p_uid']){
            $sql .=" AND p_uid=%d ";
            $condition[] = $where['p_uid'];
        }
		if($where['p_state']){
            $sql .=" AND p_state=%d ";
            $condition[] = $where['p_state'];
        }
		if($where['p_dateline']){
            $sql .=" AND p_dateline>%d ";
            $condition[] = $where['p_dateline'];
        }
		if($where['p_dateline2']){
            $sql .=" AND p_dateline<%d ";
            $condition[] = $where['p_dateline2'];
        }
        $count = DB::fetch_first($sql,$condition);
        return $count['count'];
    }

	public function get_pay_log_list($start,$size,$where = null){
		$sql = "SELECT * FROM %t WHERE 1";
		$condition[] = $this->_table;
        if($where['p_id']){     
            $sql .=" AND p_id=%d ";
            $condition[] = $where['p_id'];
        }
		if($where['p_number']){
            $sql .=" AND p_number=%s ";
            $condition[] = $where['p_number'];
        }
		if($where['p_type']){
            $sql .=" AND p_type=%d ";
            $condition[] = $where['p_type'];
        }
		if($where['p_uid']){
            $sql .=" AND p_uid=%d ";
            $condition[] = $where['p_uid'];
        }
		if($where['p_state']){
            $sql .=" AND p_state=%d ";
            $condition[] = $where['p_state'];
        }
		if($where['p_dateline']){
            $sql .=" AND p_dateline>%d ";
            $condition[] = $where['p_dateline'];
        }
		if($where['p_dateline2']){
            $sql .=" AND p_dateline<%d ";
            $condition[] = $where['p_dateline2'];
        }
		$sql .= " ORDER BY p_id desc LIMIT %d,%d ";
		$condition[] = $start;
		$condition[] = $size;
		return DB::fetch_all($sql,$condition);
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
	
	public function get_pay_log_first($where){
		$sql = "SELECT * FROM %t WHERE 1";
		$condition[] = $this->_table;
        if($where['p_id']){     
            $sql .=" AND p_id=%d ";
            $condition[] = $where['p_id'];
        }
		if($where['p_number']){
            $sql .=" AND p_number=%s ";
            $condition[] = $where['p_number'];
        }
		if($where['p_type']){
            $sql .=" AND p_type=%d ";
            $condition[] = $where['p_type'];
        }
		if($where['p_uid']){
            $sql .=" AND p_uid=%d ";
            $condition[] = $where['p_uid'];
        }
		if($where['p_state']){
            $sql .=" AND p_state=%d ";
            $condition[] = $where['p_state'];
        }
		return DB::fetch_first($sql,$condition);
	}
}
?>