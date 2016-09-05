<?php

class CommentController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'),
        'blog' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'),
        'delete' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'),
        'status' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login')
    );

    //Отбражение всех статей с не подтвержденными комментариями
    public function actionIndex() {
        $comments = Comment::modelsWhere('id ORDER BY dateadd DESC', array(''));
		
        $blogs = array();
        $allreadySearch = array();
        if(count($comments)){
            foreach($comments as $comment){
                if(!in_array($comment->id_blog, $allreadySearch)){
                	$comment->takeReplies();
                    $blog[] = Blog::model($comment->id_blog);
                    $allreadySearch[] = $comment->id_blog;
                }
            }
        }
        $this->render('index', array('blog'=>$blog));
    }

    //Выборка и отображение не подтвержденных комментариев к конкретной статье
    public function actionBlog($id = 0) {

		$allComments = array();
		$childs = array();
		$comment_id = Comment::modelsWhere('id_blog=?', array($id));

		if(count($comment_id)){
			
			foreach($comment_id as $key => $item){
				$allComments[$key] = $item;
				$parents = Comment::modelsWhere('parent=?', array($item->id));
				//debug($parents);
  				if(count($parents)){
  					
  					foreach($parents as $child){
  						$childs[] = $child;
						$allComments[$key]->parent = $childs;
					}
  				}           
            }
		}

 
		$blog = (object)$allComments;

        if ($allComments){                
            $this->render('blog', array('blog'=>$blog));
        } else {
            $this->redirect('/cp/error/404');
        }
    }
    
    //Смена статуса комментария, отображать на сайте или нет
    public function actionStatus($id = 0) {

        $comment = Comment::model((int) $id);
        if ($comment) {
            if ($comment->status == Comment::STATUS) {
                $comment->status = 1;
            } else {
                $comment->status = 0;
            }
            $comment->save();

            $this->redirect('/cp/blog');
        } else {
            $this->redirect('/cp/error/404');
        }
    }

    //Удаление "ожидающего" комментария
    public function actionDelete($id = 0) {
        $comment = Comment::model((int) $id);
        if($comment){
            Comment::delete((int) $id);
            $this->redirect('/cp/comment/blog/'.$comment->id_blog);
        }else{
            $this->redirect('/cp/error/404');
        }
    }

}
