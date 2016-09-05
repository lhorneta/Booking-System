<?php

class DB {

    static $count = 0;

    private $pdo = null;
    private $query = null;
    private $result = array();
    private $pfx = '';
    protected static $instance = null;

    final private function __construct() {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE,
        );
        $host = app::gI()->config->db['host'];
        $dbname = app::gI()->config->db['dbname'];
        $charset = app::gI()->config->db['charset'];
        $user = app::gI()->config->db['user'];
        $password = app::gI()->config->db['password'];
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=' . $charset;
        $this->pdo = new PDO($dsn, $user, $password, $opt);
        $this->pfx = app::gI()->config->db['pref'];
    }

    final private function __clone() {
        
    }
    
    private function clear(){
        $this->query = null;
        $this->result = array();
    }

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function _arrayKeysToSet($values) {
        $ret = '';
        if (is_array($values) or is_object($values)) {
            foreach ($values as $key => $value) {
                if (!empty($ret))
                    $ret.=', ';
                if (!is_numeric($key)) {
                    $ret.="`$key` = ?";
                } else {
                    $ret.=$value;
                }
            }
        } else {
            $ret = $values;
        }
        return $ret;
    }

    public function query($sql, $values = array(), $fetch_all = true) {
        //debug($sql); 
        self::$count++;
        $this->clear();
        $query_type = explode(' ', $sql);
        $query_type = $query_type[0];

        if ($this->query = $this->pdo->prepare($sql)) {
            $x = 1;
            foreach ($values as $value) {
                $this->query->bindValue($x, $value);
                $x++;
            }
            if ($this->query->execute()) {
                if (strtolower($query_type) == 'select') {
                    $this->result = $fetch_all ? $this->query->fetchAll() : $this->query->fetch();
                    return $this;
                }
                return true;
            }
        }
        throw new Except('DB Query error');
    }

    public function insert($table, $values = array()) {
        $sql = "INSERT INTO `" . $this->pfx . $table . "` SET " . $this->_arrayKeysToSet($values);
        return $this->query($sql, $values);
    }

    public function select($table, $fields = '*') {
        $sql = "SELECT " . $this->pfx . $fields . " FROM `" . $table . "` ";
        return $this->query($sql);
    }
    
    public function selectWhere($table, $fields = '*', $where='', $values = array()){
        $sql = "SELECT " . $fields . " FROM `" . $this->pfx . $table . "` WHERE " . $where;
        return $this->query($sql, $values);
    }

    public function update($table, $values, $where) {
        $sql = "UPDATE `" . $this->pfx . $table . "` SET " . $this->_arrayKeysToSet($values) . " WHERE " . $where;
        return $this->query($sql, $values);
    }

    public function delete($table, $values = array(), $where) {
        $sql = "DELETE FROM `" . $this->pfx . $table . "` WHERE " . $where;
        return $this->query($sql, $values);
    }

    public function result() {
        return $this->result;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public static function locationSqlPart(){
        $result = array();
        $region = array();
        $values = array();
        if(getCookieLocation()){
            extract(getCookieLocation());
            if($id_city > 0){
                $region[] = 'id_city = ?';
                $values[] = $id_city;
            } elseif($id_region > 0){
                $region[] = 'id_region = ?';
                $values[] = $id_region;
            } elseif($id_country > 0){
                $region[] = 'id_country = ?';
                $values[] = $id_country;
            }
        }
        $query = '';
        foreach ($region as $r){
            $query .= ' AND ' . $r;
        }
        $query = substr($query, 4, strlen($query));
        return array('query' => $query, 'values' => $values);
    }
}
