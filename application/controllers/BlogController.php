<?php
class BlogController extends Controller {
    static $rules = array(
        'index' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'articlecomment' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'comment' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'article' => array(
                'users' => array('*'),
                'redirect' => '/')
        );
    //Метод вывода всех статей и отдельно популярных
    public function actionIndex($start=0){
//        $week = 3600*24*7;
        $count = 4 + (int)$start;
        $articles = Article::modelsWhere('wait = ? ORDER BY time LIMIT 0,?', array(Article::PUBLISHED, $count));
        if(count($articles)){
            foreach($articles as $art){
                $art->calculateComments();
            }
        }
        
        $start += 4;
        $allArticles = Article::countRowWhere('wait = ?', array(Article::PUBLISHED));
        
        $this->render('index', array('articles'=>$articles, 'start'=>$start, 'all'=>$allArticles));//, 'week'=>$week));
    }
    //Метод отображение конкретной статьи по переходу на нее
    function actionArticle($url) {
        $article = Article::modelWhere('url = ?', array($url));
        if($article){
            $comments = Comment::modelsWhere('id_article = ? ORDER BY time DESC', array($article->id));
            if(count($comments)){
                foreach($comments as $comment){
                    $comment->takeUserInfo();
                    $comment->takeDate();
                    $comment->takeReplies();
                }
            }
            $user = App::gi()->user;
            $this->render('article', array('article'=>$article, 'comments'=>$comments, 'user'=>$user));
        }else{
            $this->redirect('/error/404');
        }
    }
    //Метод добавления комментария к статье
    function actionArticleComment($id=0) {
        $user = App::gi()->user;
        if($user){
            $article = Article::model((int)$id);
            if($article){
                if(isset($_POST['comment'])){
                    $comment = new Comment();
                    $comment->__attributes = $_POST['comment'];
                    $comment->id_article = (int)$id;
                    $comment->id_user = $user->id;
                    $comment->time = time();
                    $comment->save() ? $this->redirect('/blog/article/'.$article->url) : $this->redirect('/error/404');
                }
            }else{
                $this->redirect('/error/404');
            }
        }else{
            $this->redirect('/login');
        }
    }
    
    //Метод добавления комментария  к комментарию
    function actionComment($id=0) {
        $user = App::gi()->user;
        if($user){
            $comment = Comment::model((int)$id);
            if($comment){
                if(isset($_POST['comment'])){
                    $new = new Comment();
                    $new->__attributes = $_POST['comment'];
                    $new->id_reply = (int)$id;
                    $new->id_user = $user->id;
                    $new->time = time();
                    $new->save();                    
                }
            }else{
                $this->redirect('/error/404');
            }
        }else{
            $this->redirect('/login');
        }
    }
   
}
