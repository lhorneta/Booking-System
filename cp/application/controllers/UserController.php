<?php

class UserController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'delete' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'favorite' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'tofavorite' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'addreview' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'addcomment' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'leavemessage' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
//        'reviewtouser' => array(
//            'users' => array('admin'),
//            'redirect' => '/cp/login'
//        ),
        'status' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'lotvote' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'uservote' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'info' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
    );
    //Метод отображения всех пользователей активированых и деактивированных
    public function actionIndex($id = 0){		
        $active = UserFront::modelsWhere('bane = ? ORDER BY register_time', array(UserFront::ACTIVE));
        $deactive = UserFront::modelsWhere('bane = ? ORDER BY register_time', array(UserFront::DEACTIVE));                

        $this->render('index', array('active'=>$active, 'deactive'=>$deactive));
    }
    
    //Метод отображения всей информации о пользователе
    public function actionInfo($id = 0){
        $user = UserFront::model($id);
        if($user){
            $user->userLots();
            $user->toUserReviews();
            $user->userReviews();
            
            $this->render('info', array('user'=>$user));
        }else{
            $this->redirect('/cp/error/404');
        }
        
//        $this->render('info', array('user'=>$user));
    }
    
    //Метод добавления отзыва
    public function actionAddReview(){
        if(isset($_POST['review'])){
            $reviewer = App::gi()->user;
            if($reviewer){
                $review = new Review();
                $review->__attributes = $_POST['review'];
                $review->id_reviewer = $reviewer->id;
                $review->time = time();
                $review->save();
            }
        }else{
            $this->redirect('/cp/error/404');            
        }        
    }
//    
//    public function actionReviewToUser(){
//        if(isset($_POST['review'])){
//            $reviewer = App::gi()->user;
//            if($reviewer){
//                $review = new Review();
//                $review->__attributes = $_POST['review'];
//                $review->time = time();
//                $review->id_reviewer = $reviewer->id;
//                $review->save();
//            }
//        }else{
//            $this->redirect('/cp/error/404');            
//        }        
//        
//    }
    
    //Метод вывода всех избранных товаров у данного пользователя
    public function actionFavorite($id = 0){
//        $user = UserFront::model((int)$id);
        $user = User::model((int)$id);
        if($user){
            $user->favorites();
            
            $this->render('favorites', array('user'=>$user));
        }else{
            $this->redirect('/cp/error/404');
        }        
    }
    //Метод добавления лота в избранное
    public function actionToFavorite($url = ''){
        $lot = Lot::modelWhere('url = ?', array($url));
        if($lot){
            $user = App::gi()->user;
            if($user){
                $favo = new Favorite();
                $favo->id_user = $user->id;
                $favo->id_lot = $lot->id;
                $favo->id_owner = $lot->id_user;
                $favo->save();
            }else{
                $this->redirect('/cp/error/404');
            }
        }else{
            $this->redirect('/cp/error/404');
        }
        
//        $this->render('info', array('user'=>$user));
    }
        
    public function actionStatus($id = 0){
        $user = UserFront::model((int) $id);
        if($user){
            if($user->bane == UserFront::DEACTIVE){
               $user->bane = UserFront::ACTIVE;
            } else{
               $user->bane = UserFront::DEACTIVE;
            }
            $user->save();
            $this->redirect('/cp/user');
        }else{
            $this->redirect('/cp/error/404');
        }
    }
    
    //Удаление пользователя
    public function actionDelete($id = 0) {
        $user = UserFront::model((int)$id);
        if($user){
        	DB::instance()->delete('settings', array($id), 'id_user=?');
			DB::instance()->delete('booking', array($id), 'id_from=?');
			DB::instance()->delete('booking', array($id), 'id_to=?');
			DB::instance()->delete('message', array($id), 'id_from=?');
			DB::instance()->delete('message', array($id), 'id_to=?');
			DB::instance()->delete('review', array($id), 'id_user=?');
			DB::instance()->delete('review', array($id), 'id_reviewer=?');
			DB::instance()->delete('vote', array($id), 'id_user=?');
			DB::instance()->delete('lot', array($id), 'id_user=?');
			DB::instance()->delete('comment', array($id), 'id_user=?');
            UserFront::delete((int) $id);            
            $this->redirect('/cp/user');
        }else{
            $this->redirect('/cp/error/404');
        }
    }
    
    public function actionAddComment(){
        if(isset($_POST['comment'])){
            $from = App::gi()->user;
            if($from){
                $comment = new Comment();
                $comment->__attributes = $_POST['comment'];
                $comment->id_user = $from->id;
                $comment->time = time();
                $comment->save();
            }
        }else{
            $this->redirect('/cp/error/404');
        }
    }
    
    public function actionLeaveMessage(){
        if(isset($_POST['message'])){
            $from = App::gi()->user;
            if($from){
                $message = new Message();
                $message->__attributes = $_POST['message'];
                $message->id_from = $from->id;
                if($message->save()){
                    $history = new History();
                    $history->id_message = $message->id;
                    $history->id_to = $message->id_to;
                    $history->id_from = $message->id_from;
                    $history->time = time();
                    $history->id_previous = $history->previousId();
                    $history->save();
                }
            }
        }else{
            $this->redirect('/cp/error/404');
        }
    }
    
    public function actionLotVote() {
        if ($_POST['score'] != '') {
            $lot = Lot::modelWhere('url = ?', array($_POST['vote-id']) );
            $voter = App::gi()->user;
            if (!Vote::modelWhere('id_lot = ? AND id_voter = ?', array($lot->id, $voter->id))) {
                if ($lot) {
                    if ($lot->vote_count === 0) {
                        $lot->mark = (float) $_POST['score'];
                        $lot->vote_count = 1;
                    } else {
                        $lot->mark = ($lot->mark * $lot->vote_count + (float) $_POST['score']) / ($lot->vote_count + 1);
                        $lot->vote_count +=1;
                    }
                    if ($lot->save()) {
                        $vote = new Vote();
                        $vote->id_lot = $lot->id;
                        $vote->id_voter = $voter->id;
                        $vote->save();

                        $data['msg'] = 'Спасибо. Ваш голос учтен';
                        $data['status'] = 'OK';
                    }
                } else {
                    $data['msg'] = 'Произошла ошибка при голосовании';
                    $data['status'] = 'ERR';
                }
            } else {
                $data['msg'] = 'Вы уже голосовали за эту статью';
                $data['status'] = 'ERR';
            }
        } else {
            $data['msg'] = 'Вы не передали необходимые данные';
            $data['status'] = 'ERR';
        }
        echo json_encode($data);
    }
    
    public function actionUserVote() {
        if ($_POST['score'] != '') {
            $user = Review::modelWhere('url = ?', array($_POST['vote-id']) );
            $voter = App::gi()->user;
            if (!Vote::modelWhere('id_user = ? AND id_voter = ?', array($user->id, $voter->id))) {
                if ($user) {
                    if ($user->vote_count === 0) {
                        $user->mark = (float) $_POST['score'];
                        $user->vote_count = 1;
                    } else {
                        $user->mark = ($user->mark * $user->vote_count + (float) $_POST['score']) / ($user->vote_count + 1);
                        $user->vote_count +=1;
                    }
                    if ($user->save()) {
                        $vote = new Vote();
                        $vote->id_user = $user->id;
                        $vote->id_voter = $voter->id;
                        $vote->save();

                        $data['msg'] = 'Спасибо. Ваш голос учтен';
                        $data['status'] = 'OK';
                    }
                } else {
                    $data['msg'] = 'Произошла ошибка при голосовании';
                    $data['status'] = 'ERR';
                }
            } else {
                $data['msg'] = 'Вы уже голосовали за эту статью';
                $data['status'] = 'ERR';
            }
        } else {
            $data['msg'] = 'Вы не передали необходимые данные';
            $data['status'] = 'ERR';
        }
        echo json_encode($data);
    }

}
