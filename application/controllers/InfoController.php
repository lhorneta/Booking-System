<?php
class InfoController extends Controller
{
    static $rules = array(
        'index' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'article' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'rubric' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'sendcallback' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'addreview' => array(
            'users' => array('*'),
            'redirect' => '/login'
        )

    );
    
    public function actionIndex() {
    	
		$rubrics = Rubrics::models();
		$popular = Blog::models();
		$all = Blog::models();
		$interesting = Blog::modelsWhere('interesting=?', array(1));
		$best = Blog::modelsWhere('best=?', array(1));
		
        $this->render('index', array('rubrics'=>$rubrics, 'all'=>$all, 'interesting'=>$interesting, 'best'=>$best,'popular'=>$popular));
		//$this->render('index');
    }
    
    //Страница открытой статьи в блоге
    public function actionArticle($url=''){
    	$article = Blog::modelWhere('url=?', array($url));
    	if ($article) {
    		$rubrics = Rubrics::models();
			$all = Blog::models();
			
			$popular = Blog::models();
			
			$interesting = Blog::modelsWhere('interesting=?', array(1));
			$best = Blog::modelsWhere('best=?', array(1));
			$reviews = Comment::modelsWhere('id_blog=? AND parent=? AND status=1', array($article->id, 0));
			$article->views = $article->views+1;
			$article->save();
        	$this->render('article', array('rubrics'=>$rubrics, 'all'=>$all, 'interesting'=>$interesting, 'best'=>$best, 'article'=>$article, 'reviews'=>$reviews, 'popular'=>$popular));
		} else{
            $this->redirect('/error/404');
        }
    }
	
	//AlexBlacker
	public function actionRubric($url='') {
		$rubric = Rubrics::modelWhere('url=?', array($url));
		if ($rubric) {
			$rubrics = Rubrics::models();
			$popular = Blog::models();
			$all = Blog::modelsWhere('rubric=?', array($rubric->id));
			$interesting = Blog::modelsWhere('interesting=?', array(1));
			$best = Blog::modelsWhere('best=?', array(1));
			
	        $this->render('index', array('rubrics'=>$rubrics, 'all'=>$all, 'interesting'=>$interesting, 'best'=>$best, 'popular'=>$popular));
		} else{
            $this->redirect('/error/404');
        }
		
	}
	
	public function actionAddreview() {
		$this->layout = 'clear';
        $this->mainTemplate = 'clear'; 
		$res = false;
		if ($_POST['review']) {
			$user = App::gi()->user;
			$comment = new Comment();
			//$comment->__attributes = $_POST['review'];
			$comment->id_blog = $_POST['review']['id_blog'];
			$comment->text = $_POST['review']['text'];
			$comment->parent = $_POST['review']['parent'];
			$comment->id_user = $user->id;
			$comment->dateadd = date("Y-m-d H:i:s");
			$comment->status = 0;
			$comment->save();
			$res = true;
		}
		echo json_encode($res);
	}
	
	public function actionSendCallback(){
		$this->layout = 'clear';
        $this->mainTemplate = 'clear'; 
		$res = false;
		if(isset($_POST['callback'])){
			$thm = $_POST['callback']['subject'];
			$msg = "Сообщение с сайта Stufex:\r\n".$_POST['callback']['message']."\r\n";
			$msg .= "№ объявления: ".$_POST['callback']['number']."\r\n";
			$msg .= "E-mail: ".$_POST['callback']['email']."\r\n";
			//$number = $_POST['callback']['number'];
			//$email = $_POST['callback']['email'];
			$mail_to = 'stuffexua@gmail.com'; //Constans::ADMIN_EMAIL; //
			$res = mail($mail_to, $thm, $msg);
		}
		echo json_encode($res);
	}
	
}


