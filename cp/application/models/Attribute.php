<?php
class Attribute extends ModelTable {
    static $table = 'attribute';
    public $safe = array('id', 'id_category', 'title', 'url', 'units', 'type', 'head', 'category');

    public $staticValues = array();
    public $dynamicValues = array();
    
    public function takeStaticValues(){
        $this->staticValues = StaticAttributeValue::modelsWhere('id_attribute = ? ORDER BY value', array($this->id));        
    }
}

