<?php

class BlogController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'),
        'add' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'),
        'delete' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'),
        'edit' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'),
        'status' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login')
    );

    //Отбражение уже добавленых статей, и тех которые в ожидании
    public function actionIndex() {
        $status = Blog::modelsWhere('status = 0 ORDER BY date_add DESC', array(''));
        $published = Blog::modelsWhere('status = 1 ORDER BY date_add DESC', array(''));
		$rubrics = Rubric::modelsWhere('id ORDER BY date_add DESC', array(''));

        if(count($published)){
            foreach($published as $art){
                $art->calculateComments();
				$art->calculateAnswers();
            }
        }
        $this->render('index', array('status' => $status, 'published' => $published, 'rubrics' => $rubrics));
    }

    //Добавление новой "ожидающей" статьи 
    public function actionAdd() {
        if (isset($_POST['form'])) {
            $blog = new Blog();
            $blog->__attributes = $_POST['form'];
            $blog->url = translit($blog->title);
            if (Blog::isUnique('url', $blog->url)) {
                $blog->date_add = date("Y-m-d H:m:s");
                $blog->img = '';
                if ($blog->save()) {
                    if (isset($_FILES['userfile'])) {
                        $img = $this->loadImage($blog->url);
                        if ($img) {
                            $blog->img = $img;
                            $blog->save();
                        }
                    }
                }
            } else {
                $this->redirect('/cp/error/urlallreadyexist');
            }
        }
        $this->redirect('/cp/blog');
    }

    //Метод загрузки изображения
    private function loadImage($catalog = '') {
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/blog/';
        if (!empty($catalog)) {
            $uploaddir .= $catalog . '/';
        }
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        if (!empty($_FILES['userfile']['name'])) {
//            debug($_FILES['userfile']);
            $fileName = '1.';
            $type = explode('/', $_FILES['userfile']['type']);
            $fileName .= $type[1];
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $fileName)) {
                return $fileName;
            }else{
                return false;
            }
        }
    }

    //Редактирование "ожидающей" статьи
    public function actionEdit($url = '') {
        $exists = array();
        $blog = null;
        $blog = Blog::modelWhere('url = ?', array($url));

        if ($blog) {

            if (isset($_POST['form'])) {
            	if(!isset($_POST['form']['status'])){$_POST['form']['status'] = 0;}
				if(!isset($_POST['form']['best'])){$_POST['form']['best'] = 0;}
				if(!isset($_POST['form']['interesting'])){$_POST['form']['interesting'] = 0;}
                $blog->__attributes = $_POST['form'];
				
                if ($blog->save()) {
                    if (isset($_FILES['userfile'])) {
                        $img = $this->loadImage($url);
                        if ($img) {
                            $blog->img = $img;
                        }
                        $blog->save();
                    }
                }
            }
            $this->redirect('/cp/blog');
        } else {
            $blog = BlogPost::modelWhere('url = ?', array($url));
            if ($blog) {
                if (isset($_POST['form'])) {
                    $blog->__attributes = $_POST['form'];
                    if ($blog->save()) {
                        if (isset($_FILES['userfile'])) {
                            $img = $this->loadImage($url);
                            if ($img) {
                                $blog->img = $img;
                            }
                            $blog->save();
                        }
                    }
                }
                $this->redirect('/cp/blog');
            } else {
                $this->redirect('/cp/error/404');
            }
        }
    }

    //Смена статуса статьи отображать на сайте или нет
    public function actionStatus($id = 0) {
        $blog = Blog::model((int) $id);
        if ($blog) {
            if ($blog->status == Blog::STATUS) {
                $blog->status = 0;
            } else {
                $blog->status = 1;
            }
            $blog->save();

            $this->redirect('/cp/blog');
        } else {
            $this->redirect('/cp/error/404');
        }
    }

    //Редактирование конфигурации добавления "ожидающих" статей в блог
//    public function actionConfig(){
//        $config = BlogConfig::modelWhere('id');
//        if (isset($_POST['conf'])) {
//            $config->intervall = (int)$_POST['conf']['hour']*3600+(int)$_POST['conf']['day']*24*3600;
//            $config->post_count = $_POST['conf']['post_count'];
//            $config->save();
//        }
//            $this->redirect('/cp/blog');
//    }
    //Удаление "ожидающей" статьи
    public function actionDelete($id = 0) {
        Blog::delete((int) $id) ? Comment::deleteWhere('id_blog = ?', array((int)$id)) : $this->redirect('/cp/error/delete');
        $this->redirect('/cp/blog');
    }

}
