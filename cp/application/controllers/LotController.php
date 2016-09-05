<?php

class LotController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'add' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'selectcategory' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'search' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'delete' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'info' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'edit' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'editsave' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        )
        
    );
    
    public function actionIndex(){
        $lots = Lot::modelsWhere('time > ?', array(time()-3600*24));
        $parents = Category::modelsWhere('id_parent = ?', array(Category::PARENT));
        
        $this->render('index', array('lots'=>$lots, 'parents'=>$parents));
    }
    
    public function actionSelectCategory($url = ''){
        if($url==''){
            $categories = Category::modelsWhere('id_parent = ? ORDER BY title', array(Category::PARENT));            
        }else{
            $selected = Category::modelWhere('url = ?', array($url));
            if($selected){
                $categories = Category::modelsWhere('id_parent = ? ORDER BY title', array($selected->id));                
            }
        }
        
        if(count($categories)){
            foreach($categories as $category){
                $category->checkChilds();
            }
        }
//        debug($categories);
        $this->render('selectcategory', array('categories'=>$categories));
    }
    
    public function actionAdd($url=''){
        $category = Category::modelWhere('url = ?', array($url));
        $attributeGroup = Attribute::modelsWhere('id_category = ?', array($category->id));
        if(isset($_POST['form'])){
//            debug($_POST);
            $user = UserFront::model($_POST['form']['id_user']);
            if($user){
                $user->location = $_POST['user']['location'];
                $lot = new Lot();
                $lot->__attributes = $_POST['form'];
                $lot->user_type = UserFront::model($lot->id_user)->id_role;
                $lot->url = translit($lot->title). uniqid();
                $lot->id_region = $user->id_region;
                $lot->id_city = $user->id_city;
                $lot->state = Lot::REGULAR;
                $lot->time = time();
                if($lot->save()){
                    $static = $_POST['static'];
                    $dynamic = $_POST['dynamic'];
    //                debug($dynamic);
    //                debug($static);
    //                debug($lot);
                    foreach($static as $url=>$id){
                        $staticAttribute = Attribute::modelWhere('url = ? AND id_category = ?', array($url, $lot->id_category));
    //                    debug($staticAttribute);
                        if($staticAttribute){
                            $selectAttributeValue = new SelectedAttributeValue();
                            $selectAttributeValue->id_lot = $lot->id;
                            $selectAttributeValue->id_attribute = $staticAttribute->id;
                            $selectAttributeValue->id_static_attribute_value = $id;
                            $selectAttributeValue->save();
    //                        debug($selectAttributeValue);
                        }
                    }
                    foreach($dynamic as $url=>$value){
                        $dynamicAttribute = Attribute::modelWhere('url = ? AND id_category = ?', array($url, $lot->id_category));
    //                    debug($dynamicAttribute);
                        if($dynamicAttribute){
                            $selectAttributeValue = new SelectedAttributeValue();
                            $selectAttributeValue->id_lot = $lot->id;
                            $selectAttributeValue->id_attribute = $dynamicAttribute->id;
                            $selectAttributeValue->dynamic_attribute_value = $value;
                            $selectAttributeValue->save();
    //                        debug($selectAttributeValue);
                        }
                    }
                }
//                die();
            }
            
        }
        
        $users = UserFront::models();
        
        if(count($attributeGroup)){
            foreach($attributeGroup as $group){
                if($group->type == 'static'){
                    $group->takeStaticValues();                     
                }                
            }
        }
        $this->render('add', array('users'=>$users, 'category'=>$category, 'attributeGroup'=>$attributeGroup));
    }
    
    public function actionSearch(){
        if(isset($_POST['search'])){
            $queryIn = '';
            $valuesIn = '';
            $cat = $_POST['search']['category'];
            $lot = $_POST['search']['lot'];
            $searchQuery = 'Категория: '.($cat ? Category::model((int)$cat)->title : 'все').', Лот: '.($lot ? $lot : 'все');
//            debug($searchQuery);
//            die();
            if($cat !='' and $lot !=''){
                $category = Category::modelWhere('id = ?', array($cat));
                if($category){
                    $lastChilds = $category->lastChildsToVariable();
                    $queryIn .= '(';
                    foreach($lastChilds as $lastChild){
//                        $valuesIn .= $lastChild->id.',';
                        $valuesIn[] = $lastChild->id;
//                        $queryIn .= '(?),';
                        $queryIn .= '?,';
                    }
                    $queryIn = rtrim($queryIn, ',');
                        $queryIn .= ')';
                        $valuesIn[] = '%'.$lot.'%';
                    $result = Lot::modelsWhere("id_category IN $queryIn AND title LIKE ?", $valuesIn);
//                    debug($result);
//                    die();
                }else{
                    $this->redirect('/cp/error/404');
                }
            }elseif($lot !=''){
                $result = Lot::modelsWhere('title LIKE ?', array('%'.$lot.'%'));                
            }else{
                $category = Category::modelWhere('id = ?', array($cat));
                if($category){
                    $lastChilds = $category->lastChildsToVariable();
                        $queryIn .= '(';
                    foreach($lastChilds as $lastChild){
//                        $valuesIn .= $lastChild->id.',';
                        $valuesIn[] = $lastChild->id;
//                        $queryIn .= '(?),';
                        $queryIn .= '?,';
                    }
                    $queryIn = rtrim($queryIn, ',');
                        $queryIn .= ')';
//                    $valuesIn = rtrim($valuesIn, ',');
                    
                    $result = Lot::modelsWhere("id_category IN $queryIn", $valuesIn);
//                    debug($result);
//                    die();
                }else{
                    $this->redirect('/cp/error/404');
                }
            }
            
            $this->render('search', array('result'=>$result, 'query'=>$searchQuery));
        }else{
            $this->redirect('/cp/error/404');
        }
    }
    
    //Удаление пользователя
    public function actionDelete($id = 0) {
        Lot::delete((int) $id) ? $this->redirect('/cp/lot') : $this->redirect('/cp/error/404');;
    }
	
	
	public function actionEdit($url='') {
		$users = UserFront::models();
		$lot = Lot::modelWhere('url = ?', array($url));
		
		if($lot){
			$category = Category::modelWhere('id = ?', array($lot->id_category));
			if($category){
	        	$attributeGroup = Attribute::modelsWhere('id_category = ?', array($category->id));
			}else{$attributeGroup = null;}
			$selattrs = SelectedAttributeValue::modelsWhere('id_lot = ?', array($lot->id));
			if(count($attributeGroup)){
	            foreach($attributeGroup as $group){
	                if($group->type == 'static'){
	                    $group->takeStaticValues();                     
	                } 
	            }
	        }
		}else{
			$this->redirect('/cp/error/404');
		}
		
		$this->render('edit', array('users'=>$users, 'lot'=>$lot, 'category'=>$category, 'attributeGroup'=>$attributeGroup, 'selecteds'=>$selattrs));
	}
	
	public function actionEditSave($id=0) {

		if ($id>0) {
			
			$lot  = Lot::modelWhere('id = ?', array($id));
			$user = App::gi()->user;
			if($lot) {
				//debug($_POST);
				$static = isset($_POST['static'])?$_POST['static']:array();
                $dynamic = isset($_POST['dynamic'])?$_POST['dynamic']:array();
				$lot->__attributes = $_POST['form'];
	            $lot->user_type = UserFront::model($lot->id_user)->id_role;
	            $lot->url = translit($lot->title). uniqid();
	            $lot->id_region = $user->id_region;
	            $lot->id_city = $user->id_city;
	            $lot->state = Lot::REGULAR;
	            $lot->time = time();
				
				if($lot->save()){
                    
    //                debug($dynamic);
    //                debug($static);
    //                debug($lot);
                    foreach($static as $k=>$id){
                        $staticAttribute = Attribute::modelWhere('id = ? AND id_category = ?', array($k, $lot->id_category));
                       //debug($staticAttribute);
                        if($staticAttribute){
                            $selectAttributeValue = new SelectedAttributeValue();
                            $selectAttributeValue->id_lot = $lot->id;
                            $selectAttributeValue->id_attribute = $staticAttribute->id;
                            $selectAttributeValue->id_static_attribute_value = $id;
                            $selectAttributeValue->save();
                           //debug($selectAttributeValue);
                        }
                    }
                    foreach($dynamic as $k=>$value){
                        $dynamicAttribute = Attribute::modelWhere('id = ? AND id_category = ?', array($k, $lot->id_category));
                       //debug($dynamicAttribute);
                        if($dynamicAttribute){
                            $selectAttributeValue = new SelectedAttributeValue();
                            $selectAttributeValue->id_lot = $lot->id;
                            $selectAttributeValue->id_attribute = $dynamicAttribute->id;
                            $selectAttributeValue->dynamic_attribute_value = $value;
                            $selectAttributeValue->save();
                         	//debug($selectAttributeValue);
                        }
                    }
                }
				$this->redirect('/cp/lot/edit/'.$lot->url);
			} else {
				$this->redirect('/cp/error/404');
			}
			
		} else {
			$this->redirect('/cp/error/404');
		}
	}
	
	
	
	
	
    
}