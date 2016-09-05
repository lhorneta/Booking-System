<?php

abstract class ModelTable extends Model {

    public $errors = array();
    static public $table = '{table}';
    static public $primary = 'id';

    function beforeSave() {
        return !count($this->errors);
    }

    function save() {
        $modelname = get_called_class();
        if ($this->beforeSave()) {
            if (!$this->__get(self::$primary)) {
                $res = DB::instance()->insert($modelname::$table, $this->_data);
                $this->__set($modelname::$primary, DB::instance()->lastInsertId());
                return $res;
            } else {
                return DB::instance()->update($modelname::$table, $this->_data, $modelname::$primary . '=' . $this->__get(self::$primary));
            }
        }
    }

    static function delete($id) {
        $modelname = get_called_class();
        $id = (int) $id;
        return DB::instance()->delete($modelname::$table, array($id), 'id=?');
    }

    static function deleteWhere($where = '', $values = array()){
        $modelname = get_called_class();
        return DB::instance()->delete($modelname::$table, $values, $where);
    }

    static function getQuery() {
        $modelname = get_called_class();
        return 'SELECT * FROM ' . app::gi()->config->db['pref'] . $modelname::$table;
    }

    static function models() {
        $items = DB::instance()->query(self::getQuery())->result();
        $results = array();
        $modelname = get_called_class();
        foreach ($items as $item) {
            $model = new $modelname();
            $model->__attributes = $item;
            $results[] = $model;
        }
        return $results;
    }
    
    static function isUnique($column, $value){
        $modelname = get_called_class();
        $sql = 'SELECT * FROM `' . app::gi()->config->db['pref'] . $modelname::$table . '` WHERE '. $column . ' = ?';
        $result =  DB::instance()->query($sql, array($value), false)->result();        
        return !$result;
    }

    static function modelsWhere($where = '', $values = array()) {

        $modelname = get_called_class();

        $results = array();
        $sql = 'SELECT * FROM `' . app::gi()->config->db['pref'] . $modelname::$table . '` WHERE ' . $where;
        
        $items = DB::instance()->query($sql, $values)->result();
        
//        debug($sql);
        if ($items) {
            foreach ($items as $item) {
                $model = new $modelname();
                $model->__attributes = $item;
                $results[] = $model;
            }
        }

//        debug($results);
        return $results;
    }

    static function modelWhere($where = '', $values = array()) {
        $modelname = get_called_class();
        $item = DB::instance()->query('SELECT * FROM `' . app::gi()->config->db['pref'] . $modelname::$table . '` WHERE ' . $where, $values, false)->result();  
        if ($item) {
            $model = new $modelname();
            $model->__attributes = $item;
            return $model;
        }
        return false;
    }

    static function model($id) {
        $modelname = get_called_class();
        $item = DB::instance()->query('SELECT * FROM `' . app::gi()->config->db['pref'] . $modelname::$table . '` where ' . $modelname::$primary . '= ?', array($id), false)->result();
        if($item){
            $model = new $modelname();
            $model->__attributes = $item;
            return $model;
        }
        return false;
    }

    static function countRow(){
        $modelname = get_called_class();
        $sql = "SELECT COUNT(*) FROM ". app::gi()->config->db['pref'] . $modelname::$table;
        $item = DB::instance()->query($sql)->result();
        return $item[0]['COUNT(*)'];
    }

    static function countRowWhere($where = '', $values = array()){
        $modelname = get_called_class();
        $sql = "SELECT COUNT(*) FROM ". app::gi()->config->db['pref'] . $modelname::$table . " WHERE " . $where;
        $item = DB::instance()->query($sql, $values)->result();
        return $item[0]['COUNT(*)'];
    }

}

