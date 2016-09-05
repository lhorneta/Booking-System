<?php
class CategoryController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('*')
            ),
        'search' => array(
            'users' => array('*')
            ),
        ); 
    /*
     *@category - содержит в себе текущую выбранную пользователем категорию и ее атрибуты для осуществление процесса фильтрации(если у нее есть фильтры)
     *@categoryCopy - переменная содержит в себе статическую структуру в которой всегда есть mainParent
     *@allCategories - переменная для селектов, содержит в себе все категории 
     */
    public function actionIndex($url = '', $sort=''){
        $categoryUrl = $url;
        $search = array();
        $srch = array();
		$attrs = array();
        if(isset($_REQUEST['search'])){
        	$cat_url = explode('?search=',$url);
            $categoryUrl = reset($cat_url);
			
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
        $category = Category::modelWhere('url = ?', array($categoryUrl));
        
        if(!$category){
            $this->redirect('/error/404');
        }
        
        $lotTitle = '';

        if(isset($_REQUEST['q'])){
            $lotTitle = $_REQUEST['q'];
        }
		if(isset($_GET['q'])&&$_GET['q']){
            $q = $_GET['q'];
			$search['q'] = $q;
        } else {
        	$search['q'] = '';
        }
		
		if(isset($_GET['region'])&&$_GET['region']){
            $region = $_GET['region'];
			$search['region'] = $region;
        } else {
        	$search['region'] = 0;
        }
		if(isset($_GET['city'])&&$_GET['city']){
            $city = $_GET['city'];
			$search['city'] = $city;
        } else {
        	$search['city'] = 0;
        }
		
		if(isset($_GET['title_desc'])&&$_GET['title_desc']!=0){
            $title_desc = $_GET['title_desc'];
			$search['title_desc'] = $title_desc;
        } else {
        	$search['title_desc']=0;
        }
		if(isset($_GET['photo'])&&$_GET['photo']!=0){
            $photo = $_GET['photo'];
			$search['photo'] = $photo;
        } else {
        	$search['photo'] = 0;
        }
		if(isset($_GET['from'])&&$_GET['from']){
            $from = $_GET['from'];
			$search['from'] = $from;
        } else {
        	$search['from'] = 0;
        }
		if(isset($_GET['to'])&&$_GET['to']){
            $to = $_GET['to'];
			$search['to'] = $to;
        } else {
        	$search['to'] = 0;
        }
		if(isset($_GET['type'])&&$_GET['type']){
            $type = $_GET['type'];
			$search['type'] = $type;
        } else {
        	$search['type'] = 0;
        }
		if(isset($_GET['price-period'])){
            $price_period = $_GET['price-period'];
			$search['price-period'] = $price_period;
        } else {
        	$search['price-period'] = 'day';
        }
		if(isset($_GET['route'])){
            $route = $_GET['route'];
			$search['route'] = $route;
        }

		if(isset($_GET['sort'])&&$_GET['sort']){
            $sort = $_GET['sort'];
			$search['sort'] = $sort;
        } else {
        	$search['sort'] = 'new_search';
        }
		
		foreach ($_GET as $k => $v) {
            if (!isset($search[$k])) {
            	$attrs[$k] = $v;
            }
			
        }
		
        $category->checkOnParentsAndTakeIt();
        $categoryCopy = $category->buildCategoriesArraysWithSelectedOne();        
        
        if(!$category->haveChilds()){
            $category->takeAttributes();
            if(count($category->staticAttributeGroup)){
                foreach($category->staticAttributeGroup as $group){
                    $group->takeStaticValues();
                }
            }           
        }
		
        $sql = Search::prepareFilterSql($category, $search, $lotTitle);
		$childs = Category::modelsWhere('id_parent = ?', array($category->id));
		
		$cats = array();
		
		if ($childs) {
			foreach ($childs as $ky => $ch) {
				$cats[] = $ch->id;
				$chlds = Category::modelsWhere('id_parent = ?', array($ch->id));
				if ($chlds) {
					foreach ($chlds as $k => $c) {
						$cats[] = $c->id;
					}
				}
				
			}
		}
		
		$lots = filter($category->id, $search, $attrs, $cats);
		if(count($lots)){
            foreach($lots as $lot){
				$lot->getVotes($lot->id);
            }
        }
		
        $allCategories = Category::takeAllCategories();
        $lastChilds = $category->lastChildsToVariable();
        
		$category->lots[] = $lots;
        $this->render('category', array('category'=>$category, 'categories'=>$allCategories, 'copy'=>$categoryCopy, 'search'=>$search));
    }
    
}