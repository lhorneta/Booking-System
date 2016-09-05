<?php
class CategoryCopy{
    //Поля для построения структуры объекта необходимого для селектов на странице поиска
    public $mainParents = array();
    public $parents = array();
    public $childs = array();
    //----------------------------------------------------------------------------------
//    public $level = 0;
//    public $selected = false;
    //----------------------------------------------------------------------------------
    public $mainParent = null;
    public $parent = null;
    public $child = null;
    public $firstChilds = array();
    public $lastChilds = array();    
}

