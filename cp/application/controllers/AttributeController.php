<?php

class AttributeController extends Controller {

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
        'addstaticvalue' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'view' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'info' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'delete' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'deletevalue' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        )
    );
    public function actionIndex(){
        
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
    
    public function actionAdd($id_category = 0){
        $category = Category::model((int)$id_category);
        if($category){
            if(isset($_POST['attribute'])){
                $group = new Attribute();
                $group->__attributes = $_POST['attribute'];
                $group->id_category = $category->id;
                if(isset($_POST['attribute']['head'])){ 
                    $group->head = 1;
                }
                if(isset($_POST['attribute']['category'])){
                    $group->category = 1;
                }
//                debug($_POST);
//                debug($group); die();
                if($group->head != $group->category){
                    $group->save();
                }
            }
            $category->takeAttributes();
            $this->render('add', array('category'=>$category));
        }
    }
    public function actionAddStaticValue($id_attribute = 0){
        $attribute = Attribute::model((int)$id_attribute);
        if($attribute){
            if(isset($_POST['value'])){
                $value = new StaticAttributeValue();
                $value->__attributes = $_POST['value'];
                $value->id_attribute = $attribute->id;
                $value->save();
            }
            $attribute->takeStaticValues();
            $this->render('addvalue', array('group'=>$attribute));
        }
    }
	
	
	public function actionDelete($id=0) {
		$this->layout = 'clear';
        $this->mainTemplate = 'clear';
		$res = false;
		if ($id>0) {
			$values = StaticAttributeValue::modelsWhere('id_attribute = ?', array($id));
			foreach ($values as $key => $value) {
				SelectedAttributeValue::delete($value->id);
				StaticAttributeValue::delete($value->id);
			}
			Attribute::delete($id);
			$res = $id;
		}
		echo json_encode($res);
	}
	
	public function actionDeleteValue($id=0) {
		$this->layout = 'clear';
        $this->mainTemplate = 'clear';
		$res = false;
		if ($id>0) {
			SelectedAttributeValue::delete($id);
			StaticAttributeValue::delete($id);
			$res = $id;
		}
		echo json_encode($res);
	}
	
	
	
	
	
	
	
}