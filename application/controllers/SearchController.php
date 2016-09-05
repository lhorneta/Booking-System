<?php

class SearchController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('*')
            )
        ); 

    function actionIndex() {
    	
		
		$owner = App::gi()->user;
		
        $this->setLocation();
//        if (!isset($_SERVER['HTTP_REFERER'])) {
//            $this->redirect('/error/404');
//        }
//        header('Location: ' . $_SERVER['HTTP_REFERER']);
        
        $search = array();
        $srch = array();
        if(isset($_REQUEST['search'])){
        	// $cat_url = explode('?search=',$url);
            // $categoryUrl = reset($cat_url);
            //$search = json_decode($_REQUEST['search']);
			
			$search = explode(";", $_REQUEST['search']);
			$search = array_diff($search, array(''));
			
			foreach ($search as $key => $se) {
				$se = explode(":", $se);

				$k = reset($se);
				$s = explode("-", end($se));
				if (count($s)>1) {
					$s = explode("-", end($se));
					$srch[$k] = array('from'=>reset($s), 'to'=>end($s));
					
				} else {
					$srch[$k] = end($se);
				}
			}
        }
		$search = $srch;
        $search['from']=0;
		$search['to']=0;
		$search['type']=0;
        $cookieCategory = getCookieCategory();
        $result = array();
        $lotTitle = null;

        if(isset($_REQUEST['q'])){
            $lotTitle = $_REQUEST['q'];
			$search['q'] = $lotTitle;
        }
		if(isset($_GET['region'])){
            $region = $_GET['region'];
			$search['region'] = $region;
        }
		if(isset($_GET['city'])){
            $city = $_GET['city'];
			$search['city'] = $city;
        }
		if(isset($_GET['title_desc'])&&$_GET['title_desc']!=0){
            $title_desc = $_GET['title_desc'];
			$search['title_desc'] = $title_desc;
        } else {
        	$search['title_desc']=0;
        }
		if(isset($_GET['photo'])&&$_GET['photo']!=0){
            $title_desc = $_GET['photo'];
			$search['photo'] = $title_desc;
        } else {
        	$search['photo'] = 0;
        }
		// if(isset($_GET['location'])){
            // $location = $_GET['location'];
			// $search['location'] = $location;
        // }
		
		if(isset($_GET['title_desc'])){
            $title_desc = $_GET['title_desc'];
			$search['title_desc'] = $title_desc;	
        }
		if(isset($_GET['photo'])){
            $title_desc = $_GET['photo'];
			$search['photo'] = $title_desc;
        }
		if(isset($_GET['from'])){
            $from = $_GET['from'];
			$search['from'] = $from;
        }
		if(isset($_GET['to'])){
            $to = $_GET['to'];
			$search['to'] = $to;
        }
		if(isset($_GET['price-period'])){
            $price_period = $_GET['price-period'];
			$search['price-period'] = $price_period;
        } else {
        	$search['price-period'] = 'day';
        }
		if(isset($_GET['type'])){
            $type = $_GET['type'];
			$search['type'] = $type;
        }
		
		
        //debug($search);
        $sql = $this->getSqlQueryForSearch($lotTitle, $search);
 // debug($sql);
        if($cookieCategory){
//            debug($cookieCategory);
            $category = Category::model((int)$cookieCategory['id_category']);
//            debug($category);
//            die();
            if(!$category){
                $this->redirect('/error/404');
            }
			$categoryCopy = $category->buildCategoriesArraysWithSelectedOne();     
            $sql = Search::prepareFilterSql($category, $search, $lotTitle);
			//debug($sql);
            $category->checkChilds();
            $lastChilds = $category->hadChilds ? $category->lastChildsToVariable() : array();

            if(count($lastChilds)){
                foreach($lastChilds as $lastChild){
                    $result[$lastChild->title] = $sql ? $lastChild->categoryLotsToVariableWithSql($sql) : $lastChild->categoryLotsToVariable();
                }
            }else{
                $result[$category->title] = $sql ? $category->categoryLotsToVariableWithSql($sql) : $category->categoryLotsToVariable();
            }
        }else{
        	//debug($sql);
            $result['Все категории'] = $sql ? $this->lotsWithSql($sql) : $this->allLots();//$_SERVER['HTTP_REFERER']);
        }
        //debug($result);
        
        $result['Все категории'] = filter(0, $search);
		
        //debug($result);
        $this->render('index', array('result'=>$result, 'owner'=>$owner));
    }
    
    private function getSqlQueryForSearch($title, $search=array()){
        $cookieLocation = getCookieLocation();
        $sql = array(); //array('where'=>'', 'values'=>array());
        // if($cookieLocation){
            // if($cookieLocation['id_city'] == 0 and $cookieLocation['id_region'] != 0){
                // $sql['where'] = 'id_region = ?';
                // $sql['values'][] = $cookieLocation['id_region'];
            // }elseif($cookieLocation['id_city'] != 0){
                // $sql['where'] = 'id_city = ?';
                // $sql['values'][] = $cookieLocation['id_city'];                    
            // }
        // }
        
        if($title){
            if(count($sql)){
                $sql['where'] .= ' AND title LIKE ?';
            }else{
                $sql['where'] = 'title LIKE ?';                
            }
            $sql['values'][] = "%$title%";
			
			if ($search) {
				if (isset($search['title_desc'])) {
					$sql['where'] .= ' OR description LIKE ?';
	                $sql['values'][] = "%$title%";
				}
			}
        }
		
		if ($search) {
			
			if (isset($search['region'])&&$search['region']) {
				
				if(count($sql)){
	                $sql['where'] .= ' AND id_region = ?';
	            }else{
	                $sql['where'] = ' id_region = ?';                
	            }
				
                $sql['values'][] = $search['region'];
			}
			if (isset($search['city'])&&$search['city']) {
				
				if(count($sql)){
	               $sql['where'] .= ' AND id_city = ?';
	            }else{
	                $sql['where'] = ' id_city = ?';               
	            }
                $sql['values'][] = $search['city'];
			}
			
			if (isset($search['location'])&&$search['location']&&$search['location']!="") {
				if(count($sql)){
	                $sql['where'] .= ' AND address LIKE ?';
	            }else{
	                $sql['where'] = ' address LIKE ?';                
	            }
				$value = trim(str_replace('+', ' ', $search['location']));
                $sql['values'][] = "%$value%";
			}
			
			
			if ($search['from']||$search['to']) {
				
				if ($search['from']&&$search['to']) {
					
					if(count($sql)){
		               $sql['where'] .= ' AND day_payment BETWEEN ? AND ?';
		            }else{
		                $sql['where'] = ' day_payment BETWEEN ? AND ?';       
		            }
					
					$sql['values'][] = $search['from'];
					$sql['values'][] = $search['to'];
				} else {
					
					if ($search['from']) {
						if(count($sql)){
			               $sql['where'] .= ' AND day_payment >= ?';
			            }else{
			                $sql['where'] = ' day_payment >= ?';
			            }
						
						$sql['values'][] = $search['from'];
					}
					
					if ($search['to']) {
						
						if(count($sql)){
			               $sql['where'] .= ' AND day_payment <= ?';
			            }else{
			               $sql['where'] = ' day_payment <= ?';
			            }
						$sql['values'][] = $search['to'];
					}
					
				}
				
			}
			
			if ($search['type']) {
				if(count($sql)){
	               $sql['where'] .= ' AND type = ?';
	            }else{
	                $sql['where'] = ' type = ?';               
	            }
				
                $sql['values'][] = $search['type'];
			}
			
			
		}
		if(count($sql)){
            $sql['where'] .= ' AND post_type = ? ORDER BY time DESC';
        }else{
            $sql['where'] = 'post_type = ? ORDER BY time DESC';                
        }
        $sql['values'][] = "0";
		
        return count($sql) ? $sql : false;
    }
    
    private function lotsWithSql($sql){
       //debug($sql);
        $lots = Lot::modelsWhere($sql['where'], $sql['values']);
		
		if(count($lots)){
            foreach($lots as $lot){
				$lot->getVotes($lot->id);
            }
        }
		
        return $lots;
    }
    
    private function allLots(){
//        debug($sql);
        $lots = Lot::modelsWhere('id ORDER BY time DESC ', array());
    	
		if(count($lots)){
            foreach($lots as $lot){
				$lot->getVotes($lot->id);
            }
        }
		
        return $lots;
	}
    
    public function setLocation(){
        $id_city = isset($_REQUEST['city']) ? (int) $_REQUEST['city'] : 0;
        $id_region = isset($_REQUEST['region']) ? (int) $_REQUEST['region'] : 0;

        setCookieLocation($id_city, $id_region);
    }

}
