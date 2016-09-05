<?php
class SelectedAttributeValue extends ModelTable {
    static $table = 'selected_attribute_value';
    public $safe = array('id', 'id_attribute', 'dynamic_attribute_value', 'id_lot', 'id_static_attribute_value');
    
}

