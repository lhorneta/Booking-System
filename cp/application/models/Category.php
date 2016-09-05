<?php
class Category extends ModelTable{
    
    const PARENT = 0;
    
    public static $table = 'category';
    public $safe = array('id', 'url', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'title', 'id_parent');
    
    public $hadChilds = false;
    public $lots = array();
    public $allChilds = array();
    public $lastChilds = array();
    public $firstChilds = array();
    public $attributes = array();
    
    public function checkChilds(){
        if(Category::countRowWhere('id_parent = ?', array($this->id))){
            $this->hadChilds = true;
        }
    }
    
    public function categoryChilds(){
        $this->firstChilds = Category::modelsWhere('id_parent = ?', array($this->id));
    }
    
    public function categoryLotsToVariable(){
        return Lot::modelsWhere('id_category = ?', array($this->id));        
    }
    
    public function takeAttributes(){
        $this->attributes = Attribute::modelsWhere('id_category = ?', array($this->id));        
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
    
//    public function lastChildsToVariable2($idCat = null){
//        $childes = array();
//        $last = [];
//        $subCats = [];
//        if ($idCat) {
//            $cat = self::modelWhere('id = ?', [(int) $idCat]);
//            if($cat){
//                $subCats = self::modelsWhere('id_parent = ?', [$cat->id]);
//            }
//        } else {
//            $subCats = self::modelsWhere('id_parent = ?', [$this->id]);
//        }
//        
//        if(count($subCats)){
//            foreach ($subCats as $subCat){
//                if(self::countRowWhere('id_parent = ?', [$subCat->id]) > 0){
//                    $last = array_merge($last, $this->lastChildsToVariable2($subCat->id));
//                } else {
//                    $last = array_merge($last, [$subCat]);
//                }
//            }
//        } else {
//           $last = array_merge($last, [$this]);
//        }
//        return $last;
//    }
    
    
    
//    function categoryInfo(){
//        $category = Category::modelWhere('id = ?', array($this->id_category));
//        if($category){
//            $this->category = $category->title;
//        }else{
//            $this->category = 'No category on this lot';    
//        }
//    }
}