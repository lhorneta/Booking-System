<?php

class ReviewsController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'users' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'lots' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'aprove' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'block' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'delete' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'edit' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        )
        
    );
    
    public function actionIndex(){
        $lots = Lot::modelsWhere('time > ?', array(time()-3600*24));
        $parents = Category::modelsWhere('id_parent = ?', array(Category::PARENT));
        
        $this->render('index', array('lots'=>$lots, 'parents'=>$parents));
    }
	
	public function actionUsers() {
		$reviews = Review::modelsWhere('id_user>0 AND reposted=0', array());
		$this->render('users', array('reviews'=>$reviews));
	}
	
	public function actionLots() {
		$reviews = Review::modelsWhere('id_lot>0 AND reposted=0', array());
		$this->render('lots', array('reviews'=>$reviews));
	}
	
	public function actionBlock($id=0) {
		$this->layout = 'clear';
        $this->mainTemplate = 'clear';
		$res = array('res'=>false, 'item'=>0, 'act'=>'');
		$review = Review::modelWhere('id=?', array($id));
		if ($review&&$review->status) {
			$review->status = 0;
			$review->save();
			$res = array('res'=>true, 'item'=>$id, 'act'=>'blocked');
		} else {
			$review->status = 1;
			$review->save();
			$res = array('res'=>true, 'item'=>$id, 'act'=>'unblocked');
		}
		echo json_encode($res);
	}
	
	public function actionDelete($id=0) {
		$this->layout = 'clear';
        $this->mainTemplate = 'clear';
		$res = array('res'=>false, 'item'=>0, 'act'=>'');
		$review = Review::modelWhere('id=?', array($id));
		if ($review) {
			Review::delete((int) $id);
			$res = array('res'=>true, 'item'=>$id, 'act'=>'deleted');
		}
		echo json_encode($res);
	}
	
	public function actionEdit($id=0) {
		$res = array('res'=>false);
		$review = Review::modelWhere('id=?', array($id));
		if ($review) {
			$review->text = $_POST['text'];
			$review->save();
			$res = array('res'=>true);
		}
		echo json_encode($res);
	}
	
}