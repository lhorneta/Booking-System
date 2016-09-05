<?php
class Category extends ModelTable{
    
    const PARENT = 0;
    
    public static $table = 'category';
    public $safe = array('id', 'url', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'title', 'id_parent');
    
    public $parent = null;
    public $lastChilds = array();
    public $firstChilds = array();
    public $allChilds = array();
    public $selected = false;
    
    public $lots = array();
    public $staticAttributeGroup = array();
    public $dynamicAttributeGroup = array();
    public $staticAttributeUrls = array();
    public $dynamicAttributeUrls = array();
    
    private static function takeMainParents(){
        return self::modelsWhere('id_parent = ?', array(self::PARENT));
    }
    
    public function takeParents(){
        return self::modelsWhere('id = ?', array($this->id_parent));
    }
    
    public function takeParent(){
        $this->parent = self::modelWhere('id = ?', array($this->id_parent));
    }
    
    public function checkOnParentsAndTakeIt(){
        if($this->id_parent){
            $this->takeParent();
            if($this->parent->id_parent){
                $this->parent->takeParent();
            }
        }
    }
    
    public function takeAttributes(){
        $this->staticAttributeGroup = Attribute::modelsWhere('id_category = ? AND type = ?', array($this->id, Attribute::STATICAL));
        $this->dynamicAttributeGroup = Attribute::modelsWhere('id_category = ? AND type = ?', array($this->id, Attribute::DYNAMICAL));
    }
   public function takeOnlyAttributeUrls(){
       foreach($this->staticAttributeGroup as $static){
           $this->staticAttributeUrls[] = $static->url;
       }
       foreach ($this->dynamicAttributeGroup as $dynamic){
           $this->dynamicAttributeUrls[] = $dynamic->url;
       }
   }
    
    public function haveChilds(){
        return Category::countRowWhere('id_parent = ?', array($this->id)) ? true : false;
    }
    
    
    public function categoryLotsToVariable(){
        return Lot::modelsWhere('id_category = ?', array($this->id));        
    }
    
    public function categoryLotsToVariableWithSql($sql){
        array_unshift($sql['values'], $this->id);
        return Lot::modelsWhere('id_category = ? '.$sql['where'], $sql['values']);
    }
    
    public function categoryLots(){
        $this->lots[$this->title] = Lot::modelsWhere('id_category = ?', array($this->id));        
    }
    
    public function categoryAllChilds(){
        $childes = Category::modelsWhere('id_parent = ?', array($this->id));
        if(count($childes)){
            $this->allChilds = $childes;
            foreach($this->allChilds as $child){
                $child->categoryAllChilds();
            }
        }else{
            return;
        }
    }
    
    public function lastChildsToVariable(){        
        $childes = array();
        $last = array();
        
        $childes = Category::modelsWhere('id_parent = ?', array($this->id));
        if(count($childes)){            
            foreach($childes as $child){
                $last = array_merge($last, $child->lastChildsToVariable());
            }
        }else{
            $parent = array('0'=>$this);
            $last = array_merge($last, $parent);
            unset($parent);
        }
        
        return $last;
    }
    
    public function takeChilds(){
        $this->firstChilds = self::modelsWhere('id_parent = ?', array($this->id));
    }
    public function firstChildsToVariable(){
        return self::modelsWhere('id_parent = ?', array($this->id));
    }
    public function buildCategoriesArraysWithSelectedOne(){
        $categoryCopy = new CategoryCopy();
        if(isset($this->parent->parent)){
            $this->thirdLevel($categoryCopy);
        }elseif(isset($this->parent)){
            $this->secondLevel($categoryCopy);
        }else{
            $this->firstLevel($categoryCopy);
        }
        return $categoryCopy;
    }
    
    private function thirdLevel($categoryCopy){
        $categoryCopy->childs = Category::modelsWhere('id_parent = ? GROUP BY id', array($this->id_parent));
        if(count($categoryCopy->childs)){
            foreach($categoryCopy->childs as $child){
                $child->selected = ($child->url == $this->url) ? true : false;
            }
        }
		//debug($categoryCopy->childs);
        $categoryCopy->parents = $this->takeParents();
        if(count($categoryCopy->parents)){
            foreach($categoryCopy->parents as $parent){
                $parent->selected = ($parent->id == $this->id_parent) ? true : false;
            }
        }
        $categoryCopy->mainParents = self::takeMainParents();
        if(count($categoryCopy->mainParents)){
            foreach($categoryCopy->mainParents as $main){
                $main->selected = ($main->id == $this->parent->id_parent) ? true : false;
            }
        }
    }
    
    private function secondLevel($categoryCopy){
        $categoryCopy->childs = Category::modelsWhere('id_parent = ? GROUP BY id', array($this->id));
        $categoryCopy->parents = Category::modelsWhere('id_parent = ? GROUP BY id', array($this->id_parent));
        if(count($categoryCopy->parents)){
            foreach($categoryCopy->parents as $parent){
                $parent->selected = ($parent->id == $this->id) ? true : false;
            }
        }
        $categoryCopy->mainParents = self::takeMainParents();
        if(count($categoryCopy->mainParents)){
            foreach($categoryCopy->mainParents as $main){
                $main->selected = ($main->id == $this->id_parent) ? true : false;
            }
        }
    }
    
    private function firstLevel($categoryCopy){
        $categoryCopy->parents = Category::modelsWhere('id_parent = ? GROUP BY id', array($this->id));
        $categoryCopy->mainParents = self::takeMainParents();
        if(count($categoryCopy->mainParents)){
            foreach($categoryCopy->mainParents as $main){
                $main->selected = ($main->id == $this->id) ? true : false;
            }
        }
    }
    
    public static function takeAllCategories(){
        $object = self::takeMainParents();
        if(!count($object)){
            return;
        }
        
        foreach($object as $mainParent){
            $mainParent->takeChilds();
            
            if(!count($mainParent->firstChilds)){
                continue;
            }
            
            foreach($mainParent->firstChilds as $parent){
                $parent->takeChilds();
            }
        }
        return $object;
    }

}