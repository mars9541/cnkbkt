<?php

if (!defined('IN_DISCUZ')) {
    exit('Access denid');
}
/**
 * 通过sql方法直接调用sql类
 * @DateTime 2021-03-09
 * @param    string     $table
 * @return   sql        sql类
 */
function sql($table) {
    return new sql($table);
}
class sql {
    private $table      = [];
    private $where      = [];
    private $field      = '*';
    private $limit      = NULL;
    private $order      = [];
    private $getsql     = false;
    private $duplicate  = false;
    private $replace    = false;
    private $update     = [];
    private static $raw = 'rawdqzhiyu|';
    private $group      = '';
    private $array      = '';
    /**
     * 构造函数
     */
    public function __construct($table) {
        $this->table($table);
    }
    /**
     * whereRaw的重名方法，在所有插件更新完毕后会被废除
     */
    public function whereExp($exp, $link = 'AND') {
        return $this->whereRaw($exp, $link);
    }
    /**
     * 事务开始
     */
    public static function transaction() {
        return DB::query('START TRANSACTION');
    }
    /**
     * 事务提交
     */
    public static function commit() {
        return DB::query('COMMIT');
    }
    /**
     * 事务回滚
     */
    public static function rollback() {
        return DB::query('ROLLBACK');
    }
    /**
     * 字段名处理
     */
    public static function field_quote($field) {
        if (strpos($field, self::$raw) === 0) {
            $field = substr($field, strlen(self::$raw));
        } elseif (strstr($field, '.')) {
            $field = str_replace('.', '.`', $field) . '`';
        } else {
            $field = '`' . $field . '`';
        }
        return $field;
    }
    /**
     * 字段值处理
     */
    public static function quote($val) {
        if (is_array($val)) {
            $val = array_map('DB::quote', $val);

            $val = implode(',', $val);
        } else {
            if (strpos($val, self::$raw) === 0) {
                $val = substr($val, strlen(self::$raw));
            } else {
                $val = DB::quote($val);
            }
        }

        return $val;
    }
    /**
     * 处理写入字段时的语句
     */
    public static function data($datas, $array = '') {
        if ($array) {
            foreach (explode(',', $array) as $key) {
                if (isset($datas[$key])) {
                    $datas[$key] = serialize($datas[$key]);
                }
            }
        }
        $sql = [];
        foreach ($datas as $k => $v) {
            $sql[] = self::field_quote($k) . '=' . self::quote($v);
        }
        return $sql;
    }
    /**
     * 原语句
     */
    public static function raw($text) {
        return self::$raw . $text;
    }
    /**
     * 替换式
     */
    public function replace($flag = true) {
        $this->replace = $flag;
        return $this;
    }
    /**
     * 查询的字段
     */
    public function field($field) {
        $this->field = $field;
        return $this;
    }
    /**
     * 重命名默认表
     */
    public function alias($name) {
        $this->table[0][1] = $name;
        return $this;
    }
    /**
     * 需要serialize和dunserialize的字段
     */
    public function arr($fields) {
        $this->array = $fields;
        return $this;
    }
    /**
     * 增加表
     * 表名=>重命名
     */
    public function table($table) {
        if (is_string($table)) {
            $this->table[] = [$table];
        } else {
            foreach ($table as $key => $value) {
                $value = [$value];
                if (!is_numeric($key)) {
                    $value = [$key, $value[0]];
                }
                $this->table[] = $value;
            }
        }
        return $this;
    }
    /**
     * where查询
     * 当val为空时，$field=$operator
     * @param    string     $field    字段名
     * @param    string     $operator 操作符
     * @param    fixed      $val      值
     * @param    string     $link     连接方式
     */
    public function where($field, $operator = NULL, $val = NULL, $link = 'AND') {
        if (is_array($field)) {
            foreach ($field as $key => $value) {
                if (is_array($value)) {
                    call_user_func_array([$this, 'where'], $value);
                } else {
                    $this->where($key, $value);
                }
            }
        } else {
            if (is_null($val)) {
                $val      = $operator;
                $operator = '=';
            }
            $operator = strtoupper($operator);
            $field    = self::field_quote($field);
            $val      = self::quote($val);
            $txt      = '';

            if ($operator == 'FIND_IN_SET' || $operator == '!FIND_IN_SET') {
                if (!$val) {
                    return $this;
                }
                $txt = $operator . "({$val},{$field})";
            } elseif ($operator == 'IN' || $operator == 'NOT IN') {
                if (!$val) {
                    return $this;
                }
                $txt = "{$field} {$operator} ({$val})";
            } else {
                if ($operator == '=' && strstr($val, '|')) {
                    //val=a|b=> (field=a or field=b)
                    $tempWhere = [];
                    foreach (explode("|", $val) as $v) {
                        $tempWhere[] = $field . "=" . self::quote($v);
                    }
                    $txt = '(' . implode(" OR " . $tempWhere) . ')';
                } else {
                    $txt = "{$field} {$operator} {$val}";
                }
            }
            if ($txt) {
                $this->where[] = [$txt, $link];
            }

        }
        return $this;
    }
    /**
     * or连接符
     */
    public function whereOr($field, $operator = NULL, $val = NULL) {
        return $this->where($field, $operator, $val, 'OR');
    }
    /**
     * in 语句查询，val可传入数组，也可传入字符串列表
     */
    public function whereIn($field, $val, $link = 'AND') {
        return $this->where($field, 'IN', $val, $link);
    }
    /**
     * not in 语句查询，val可传入数组，也可传入字符串列表
     */
    public function whereNotIn($field, $val, $link = 'AND') {
        return $this->where($field, 'NOT IN', $val, $link);
    }
    /**
     * like 语句查询
     */
    public function whereLike($field, $val, $link = 'AND') {
        return $this->where($field, 'LIKE', $val, $link);
    }
    /**
     * not like 语句查询
     */
    public function whereNotLike($field, $val, $link = 'AND') {
        return $this->where($field, 'NOT LIKE', $val, $link);
    }
    /**
     * findInSet 语句查询
     */
    public function whereFindInSet($strlist, $str, $link = 'AND') {
        if (!$strlist || !$str) {
            return $this;
        }

        if ($firstField) {
            $strlist = $this->field_quote($strlist);
            $str     = $this->quote($str);
        } else {
            $str     = $this->field_quote($str);
            $strlist = $this->quote(is_array($strlist) ? implode(',', $strlist) : $strlist);
        }
        return $this->whereRaw('FIND_IN_SET(' . $str . ',' . $strlist . ')', $link);
    }
    /**
     * !findInSet 语句查询
     */
    public function whereNotFindInSet($strlist, $str, $link = 'AND', $firstField = false) {
        if (!$strlist || !$str) {
            return $this;
        }

        if ($firstField) {
            $strlist = $this->field_quote($strlist);
            $str     = $this->quote($str);
        } else {
            $str     = $this->field_quote($str);
            $strlist = $this->quote(is_array($strlist) ? implode(',', $strlist) : $strlist);
        }
        return $this->whereRaw('!FIND_IN_SET(' . $str . ',' . $strlist . ')', $link);
    }
    /**
     * 原生语句查询
     */
    public function whereRaw($exp, $link = 'AND') {
        $this->where[] = [$exp, $link];
        return $this;
    }

    /**
     * 原生语句update
     */
    public function exp($exp) {
        $this->update[] = $exp;
        return $this;
    }
    /**
     * 字段自增
     */
    public function increase($field, $val = 1) {
        $field = self::field_quote($field);
        return $this->exp($field . ' = ' . $field+'+' . $val);
    }
    /**
     * 字段自减
     */
    public function decrease($field, $val = 1) {
        $field = self::field_quote($field);
        return $this->exp($field . ' = ' . $field+'-' . $val);
    }
    /**
     * 主键重复更新
     */
    public function duplicate($duplicate = []) {
        $this->duplicate = self::data($duplicate, $this->array);
        return $this;
    }
    /**
     * 查询数量限制
     */
    public function limit($num, $ignore = 0) {
        $this->limit = [$num, $ignore];
        return $this;
    }
    /**
     * 以limit为基础实现分页查询
     */
    public function page($page, $num = 10) {
        $this->limit = [($page - 1) * $num, $num];
        return $this;
    }
    /**
     * 排序方式
     */
    public function order($by, $sc = '') {
        if (is_array($by)) {
            foreach ($by as $key => $value) {
                $this->order($key, $value);
            }
        } else {
            $this->order[] = self::field_quote($by) . $sc;
        }
        return $this;
    }
    /**
     * 分组查询
     */
    public function group($key) {
        $this->group = $key;
        return $this;
    }
    /**
     * 返回sql语句，不查询
     */
    public function sql($flag = true) {
        $this->getsql = $flag;
        return $this;
    }
    /**
     * 生成where语句
     */
    private function makeWhere() {
        $where = '';
        foreach ($this->where as $key => $value) {
            if ($key > 0) {
                $where .= ' ' . $this->where[$key - 1][1] . ' ';
            }
            $where .= $value[0];
        }
        return $where ? ' WHERE ' . $where : '';
    }
    /**
     * 生成order语句
     */
    private function makeOrder() {
        if ($this->order) {
            return ' ORDER BY ' . implode(', ', $this->order);
        } else {
            return '';
        }
    }
    /**
     * 生成limit语句
     */
    private function makeLimit() {
        if (!$this->limit) {
            return '';
        } else {
            return DB::limit($this->limit[0], $this->limit[1]);
        }
    }
    /**
     * 生成table部分
     */
    private function makeTable() {
        $tables = array_map(function ($n) {
            return DB::table($n[0]) . ($n[1] ? ' ' . $n[1] : '');
        }, $this->table);
        return implode(',', $tables);
    }
    /**
     * 生成table->group部分的语句
     */
    private function makeSql() {
        return $this->makeTable($this->table) . $this->makeWhere() . ($this->group ? ' GROUP BY ' . $this->group : '');
    }
    /**
     * 生成select语句
     */
    private function makeSelect($field = '') {
        if (!$field) {
            $field = $this->field;
        }
        return "SELECT {$field} FROM " . $this->makeSql();
    }
    /**
     * 在select语句基础上增加order和limit
     */
    private function makeFetch($field = '') {
        return $this->makeSelect($field) . $this->makeOrder() . $this->makeLimit();
    }
    /**
     * 统计查询
     */
    public function count($where = []) {
        if ($where) {
            $this->where($where);
        }
        $sql = $this->makeSelect('COUNT(*)');
        if ($this->getsql) {
            return $sql;
        } else {
            return DB::result_first($sql);
        }
    }
    /**
     * 删除
     */
    public function delete($where = []) {
        if ($where) {
            $this->where($where);
        }
        $sql = "DELETE FROM " . $this->makeSql();
        if ($this->getsql) {
            return $sql;
        } else {
            return DB::query($sql);
        }
    }

    /**
     * 判断数据是否存在
     */
    public function exist($where = []) {
        if ($where) {
            $this->where($where);
        }
        $sql = $this->makeSelect('1') . " LIMIT 1";
        if ($this->getsql) {
            return $sql;
        } else {
            return DB::result_first($sql);
        }
    }

    /**
     * 获取单条数据
     */
    public function find($where = []) {
        if ($where) {
            $this->where($where);
        }

        $sql = $this->makeFetch();
        if ($this->getsql) {
            return $sql;
        } else {
            $res = DB::fetch_first($sql);
            if ($this->array) {
                foreach (explode(',', $this->array) as $key) {
                    if (isset($res[$key])) {
                        $res[$key] = dunserialize($res[$key]);
                    }

                }
            }
            return $res;
        }
    }

    /**
     * 获取单条数据的某个值
     */
    public function value($keyfield) {
        $sql = $this->makeFetch($keyfield);
        if ($this->getsql) {
            return $sql;
        } else {
            return DB::result_first($sql);
        }
    }
    /**
     * 统计
     */
    public function sum($field) {
        $sql = $this->makeFetch('sum(' . self::field_quote($field) . ')');
        if ($this->getsql) {
            return $sql;
        } else {
            return DB::result_first($sql);
        }
    }

    /**
     * 获取多条数据
     */
    public function select($where = []) {
        $keyfield = '';
        if ($where) {
            if (is_array($where)) {
                $this->where($where);
            } else {
                $keyfield = $where;
            }
        }

        $sql = $this->makeFetch();

        if ($this->getsql) {
            return $sql;
        } else {
            $res = DB::fetch_all($sql, [], $keyfield);
            if ($this->array) {
                $arrayfields = explode(',', $this->array);

                $res = array_map(function ($n) use ($arrayfields) {
                    foreach ($arrayfields as $key) {
                        if (isset($n[$key])) {
                            $n[$key] = dunserialize($n[$key]);
                        }

                    }
                    return $n;
                }, $res);
            }
            return $res;
        }
    }
    /**
     * 获取列
     * @DateTime 2021-02-19
     * @param    [type]     $key   只有key时为获取此列
     * @param    string     $field
     */
    public function column($key, $field = '') {
        $keyfield = '';
        if (!$field) {
            $sql   = $this->makeFetch($key);
            $field = $key;
        } else {
            $sql      = $this->makeFetch($key . ',' . $field);
            $keyfield = $key;
        }
        if ($this->getsql) {
            return $sql;
        } else {
            $res = DB::fetch_all($sql, [], $keyfield);
            if ($this->array) {
                $arrayfields = explode(',', $this->array);

                $res = array_map(function ($n) use ($arrayfields) {
                    foreach ($arrayfields as $key) {
                        if (isset($n[$key])) {
                            $n[$key] = dunserialize($n[$key]);
                        }

                    }
                    return $n;
                }, $res);
            }
            if (strpos($field, ',') === false) {
                foreach ($res as $key => $value) {
                    $res[$key] = $value[$field];
                }
            }
            return $res;
        }
    }

    /**
     * 更新数据
     */
    public function update($data = []) {
        $sql = array_merge(self::data($data, $this->array), $this->update);
        if (empty($sql)) {
            return false;
        }

        $sql = "UPDATE " . $this->makeTable() . " SET " . (implode(',', $sql)) . ' ' . $this->makeWhere() . $this->makeOrder() . $this->makeLimit();
        if ($this->getsql) {
            return $sql;
        } else {
            return DB::query($sql);
        }
    }

    /**
     * 插入数据
     */
    public function insert($data, $return_insert_id = true) {
        $cmd = $this->replace ? 'REPLACE INTO' : 'INSERT INTO';

        $sql = "$cmd " . $this->makeTable() . " SET " . implode(',', self::data($data, $this->array));

        if ($this->duplicate) {
            $sql .= " ON DUPLICATE KEY UPDATE " . implode(',', $this->duplicate);
        }

        if ($this->getsql) {
            return $sql;
        } else {
            return DB::query($sql, null, null, !$return_insert_id);
        }
    }
    /**
     * 清空表
     */
    public function truncate() {
        $sql = "TRUNCATE TABLE " . $this->makeTable();
        if ($this->getsql) {
            return $sql;
        } else {
            return DB::query($sql);
        }
    }

}
?>