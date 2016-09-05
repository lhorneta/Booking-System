<?php
 
class IndexController extends Controller {
	
	// static $rules = array(
        // 'dbcorrect' => array(
            // 'users' => array('*'),
            // 'redirect' => '/login'
        // )
	// );
	
    //Главная страница сайта
    public function actionIndex() {

        $lots = Lot::modelsWhere('post_type = 0 ORDER BY time DESC LIMIT ?', array(Constants::INDEX_PAGE_COUNT_LOTS));
		//debug($lots);
        if(count($lots)){
            foreach($lots as $lot){
                $lot->takeImages();
				$lot->getVotes($lot->id);
            }
        }
		
        $all = Lot::countRowWhere('post_type = 0', array());
        $this->render('index', array('lots'=>$lots, 'all'=>$all));
    }

}
