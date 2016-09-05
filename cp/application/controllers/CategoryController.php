<?php

class CategoryController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'add' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'addchild' => array(
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
        'children' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'grandchildren' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'delete' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        )
		
        
		
		
    );
    
    public function actionIndex(){
        $categories = Category::modelsWhere('id_parent = ?', array(Category::PARENT));
        
        $this->render('index', array('categories'=>$categories));
    }
	public function actionChildren($id=0) {
		$category = Category::modelWhere('id = ?', array($id));
		$categories = Category::modelsWhere('id_parent = ?', array($id));
		$this->render('children', array('categories'=>$categories, 'cat'=>$category));
	}

	public function actionGrandchildren($id=0) {
		$category = Category::modelWhere('id = ?', array($id));
		$categories = Category::modelsWhere('id_parent = ?', array($id));
		$this->render('grandchildren', array('categories'=>$categories, 'cat'=>$category));
	}

	public function actionDelete($id=0) {
		Category::delete((int) $id);
		$this->redirect($_SERVER['HTTP_REFERER']);
		
	}
    
    public function actionAdd($id = 0){
        $category = Category::model((int)$id);
		$template = 'edit';
        if(!$category){
        	$template = 'add';
            $category = new Category();
        }
        $saved = false;
        if(isset($_POST['form'])){
            $category->__attributes = $_POST['form'];
            $category->url = translit($category->title);
//            debug($category);
//            die();
            $category->save();
			$saved = true;
        }
        
        $this->render($template, array('category'=>$category, 'saved'=>$saved));        
    }
	
    public function actionAddChild($id = 0){
        $category = Category::model((int)$id);
        if(isset($_POST['form'])){
            if($category){
                $child = new Category();
                
                $child->__attributes = $_POST['form'];
                $child->id_parent = $category->id;
                $child->url = translit($child->title);
//                debug($child);
//                die();
                $child->save();
                
//                $this->actionIndex();
            }else{
                $this->redirect('/cp/error/404');
            }
        }
        
        $this->render('addchild', array('parent'=>$category));        
    }
    
    public function actionView($id = 0){
        $category = Category::model((int)$id);
        if($category){
            $category->categoryChilds();
//            debug($category);
//            die();
            $this->render('view', array('parent'=>$category));
        }else{
            $this->redirect('/cp/error/404');
        }        
    }
    
    public function actionInfo($id = 0){
        $category = Category::model((int)$id);
        if($category){
//            $start = microtime(true);
//            $lastChilds = $category->lastChildsToVariable2();
//            echo (microtime(true) - $start);
//            echo '<hr>';
//            $start = microtime(true);
            $lastChilds = $category->lastChildsToVariable();
//            echo (microtime(true) - $start);
//            die();
            if(count($lastChilds)>0){
                foreach($lastChilds as $lastChild){
                    $category->lots[$lastChild->title] = $lastChild->categoryLotsToVariable();
                }
            }else{
                $category->categoryLots();
            }
//            debug($category);
//            die();
            $this->render('info', array('category'=>$category));
        }else{
            $this->redirect('/cp/error/404');
        }        
    }
}