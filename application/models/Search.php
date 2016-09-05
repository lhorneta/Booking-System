<?php

class Search {
    private $sql = array(
                        'where'=>'',
                        'values'=>array()
                    );
    
    private $cookieLocation = array();
    private $lotTitle = '';
    private $category = null;
    private $search = null;
    private $allCategoryLots = array();
    
    private $attributeGroup = null;
    private $attributeValues = array();
    private $searchStaticValueUrl = array();
    private $searchDynamicValue = array();
    
    
    private function initialize($category, $search, $lotTitle){
        $this->cookieLocation = getCookieLocation();
        $this->lotTitle = $lotTitle;
        $this->category = $category;
        $this->search = $search;
        
        $allCategoryLastChilds = $category->lastChildsToVariable();
        
        foreach($allCategoryLastChilds as $lastChild){
            $this->allCategoryLots = array_merge($this->allCategoryLots, $lastChild->categoryLotsToVariable());
        }
        foreach($this->allCategoryLots as $lot){
            $lot->takeAllAttributeUrls();
        }
		
		
		 //debug($this->sql);
    }
    
    public static function prepareFilterSql(Category $category, $search, $lotTitle) {
        $object = new self();
        $object->initialize($category, $search, $lotTitle);
       
        if(count($object->search)){   
            $object->takeSqlQueryAttributePart();
        }
        
        if($object->lotTitle != '' or count($object->cookieLocation)){
            $object->takeSqlQueryNoneAttributePart();
        }
        //debug($object->allCategoryLots);
        //echo '------------------------------------FILTER START-------------------------------------------<br>';
        $object->filterAllCategoryLots();
        //echo '-------------------------------------FILTER END-------------------------------------------<br>';
        
        //debug($object->sql);
        //die();
        return $object->sql;
    }
 /***************************************************FILTER ALL CATEGORY LOTS PART*********************************************************/   
    private function filterAllCategoryLots(){
        foreach ($this->allCategoryLots as $lot){
            $staticFlagArray = array_diff_assoc($lot->staticUrls, $this->searchStaticValueUrl);
                    
            if(count($staticFlagArray)){
                unset($lot);
                continue;
            }
            $dynamicFlagArray = array_diff_key($lot->dynamicUrls, $this->searchDynamicValue);
            
            if(count($dynamicFlagArray)){ 
                unset($lot);
                continue;
            }else{
                foreach ($dynamicFlagArray as $key=>$value){
                    if(!$this->arraysEquals()){
                        unset($lot);
                        continue;
                    }
                }
            }
        }
    }
    
    private function arraysEquals(){
        
    }
 /***************************************************END OF FILTER ALL CATEGORY LOTS PART*********************************************************/   
    
    private function takeSqlQueryAttributePart(){
        foreach ($this->search as $searchUrl=>$value){
            $this->attributeGroup = Attribute::modelWhere('url = ?', array($searchUrl));
            if(!$this->attributeGroup){
                continue;
            }
//            $this->takeSqlPrefixIdAttribute();
            
            if(is_object($value)){
                //echo 'dynamic <br>';
                $this->takeDynamicArrayElement($searchUrl, $value);
//                $this->takeSqlDynamic($value);
            }else{
                //echo 'static <br>';
                $this->takeStaticArrayElement($searchUrl, $value);
//                $this->takeSqlStatic($value);
            }
        }
    }
    
 /***************************************************ATTRIBUTE PART*********************************************************/   
    private function takeDynamicArrayElement($searchUrl, $value) {
        if(isset($value->to) and isset($value->from)){
            $this->searchDynamicValue[$searchUrl] = array('to'=>$value->to, 'from'=>$value->from);
        }elseif(isset($value->to)){
            $this->searchDynamicValue[$searchUrl] = array('to'=>$value->to);
        }else{
            $this->searchDynamicValue[$searchUrl] = array('from'=>$value->from);
        }
    }
    
    private function takeStaticArrayElement($searchUrl, $value) {
        $this->searchStaticValueUrl[$searchUrl] = $value;
    }
    
    private function takeSqlPrefixIdAttribute() {
        if($this->sql['where'] != ''){
            $this->sql['where'] .= ' AND ';
        }
        $this->sql['where'] .= '(id_attribute = ?';
        $this->sql['values'][] = $this->attributeGroup->id;
    }
        
    private function takeSqlDynamic($value){
        $this->sql['where'] .= ' AND dynamic_attribute_value ';
        if(isset($value->to) and isset($value->from)){
            $this->sql['where'] .= 'BETWEEN ? AND ?)';
            $this->sql['values'][] = $value->to;
            $this->sql['values'][] = $value->from;            
        }elseif(isset($value->to)){
            $this->sql['where'] .= '< ?)';
            $this->sql['values'][] = $value->to;
        }else{
            $this->sql['where'] .= '> ?)';            
            $this->sql['values'][] = $value->from;
        }
    }
    
    private function takeSqlStatic($value){
        $this->attributeValues = StaticAttributeValue::modelsWhere('id_attribute = ?', array($this->attributeGroup->id));
        if(!count($this->attributeValues)){
            return;
        }
        
        foreach($this->attributeValues as $atrVal){
            if($atrVal->url != $value){
                continue;
            }
            
            $this->sql['where'] .= ' AND id_static_attribute_value = ?)';
            $this->sql['values'][] = $atrVal->id;
        }
    }
 /***************************************************END OF ATTRIBUTE PART*********************************************************/   
    
 /***************************************************NONE ATTRIBUTE PART*********************************************************/   
    
    private function takeSqlQueryNoneAttributePart(){
        if($this->cookieLocation){
            $this->takeSqlCookiePart();
        }
        
        if($this->lotTitle){
            $this->takeSqlLotTitlePart();
        }
        
        return count($this->sql) ? $this->sql : false;
    }
    
    private function takeSqlCookiePart(){
        if($this->cookieLocation['id_city'] == 0 and $this->cookieLocation['id_region'] != 0){
            $this->sql['where'] .= 'id_region = ?';
            $this->sql['values'][] = $this->cookieLocation['id_region'];
        }elseif($this->cookieLocation['id_city'] != 0){
            $this->sql['where'] .= 'id_city = ?';
            $this->sql['values'][] = $this->cookieLocation['id_city'];                    
        }
    }
    
    private function takeSqlLotTitlePart(){
        if(count($this->sql)){
            $this->sql['where'] .= ' AND title LIKE ?';
        }else{
            $this->sql['where'] .= 'title LIKE ?';                
        }
        $this->sql['values'][] = "%$this->lotTitle%";
		
		if ($this->search) {
			if (isset($this->search['region'])) {
				$this->sql['where'] .= ' AND id_region = ?';
                $this->sql['values'][] = $this->search['region'];
			}
			if (isset($this->search['city'])) {
				$this->sql['where'] .= ' AND id_city = ?';
                $this->sql['values'][] = $this->search['city'];
			}
			
			if ($this->search['from']||$this->search['to']) {
				
				if ($this->search['from']&&$this->search['to']) {
					$this->sql['where'] .= ' AND day_payment BETWEEN ? AND ?';
					$this->sql['values'][] = $this->search['from'];
					$this->sql['values'][] = $this->search['to'];
				} else {
					
					if ($this->search['from']) {
						$this->sql['where'] .= ' AND day_payment >= ?';
						$this->sql['values'][] = $this->search['from'];
					}
					
					if ($this->search['to']) {
						$this->sql['where'] .= ' AND day_payment <= ?';
						$this->sql['values'][] = $this->search['to'];
					}
					
				}
				
			}
			
			if ($this->search['type']) {
				$this->sql['where'] .= ' AND type = ?';
                $this->sql['values'][] = $this->search['type'];
			}
			
			
		}
		
    }
 /***************************************************END OF NONE ATTRIBUTE PART*********************************************************/   

    private function lotsWithSql() {
        return Lot::modelsWhere($this->sql['where'], $this->sql['values']);
    }

    private function allLots() {
        return Lot::modelsWhere('id ORDER BY time DESC LIMIT ?', array(Constants::INDEX_PAGE_COUNT_LOTS));
    }    
}
