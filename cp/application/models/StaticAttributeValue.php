<?php
class StaticAttributeValue extends ModelTable {
    static $table = 'static_attribute_value';
    public $safe = array('id', 'id_attribute', 'value', 'url');
    
}

