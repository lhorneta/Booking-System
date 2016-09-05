<?php

class Controller extends Singleton {

    static $rules = array(
        'index' => array(
            'users' => array('*')
        )
    ); //права доступа к контроллеру
    public $layout = '';
    public $mainTemplate = 'main';

    function __call($methodName, $args = array()) {
        if (method_exists($this, $methodName))
            return call_user_func_array(array($this, $methodName), $args);
        else
            throw new Except('In controller ' . get_called_class() . ' method ' . $methodName . ' not found!');
    }

    public $tplPath = '';
    public $tplControllerPath = '';

    function __construct() {
        $this->layout = app::gi()->config->layout;
        $this->tplPath = APP . 'views/';
        $this->tplControllerPath = APP . 'views/' . strtolower(str_replace('Controller', '', get_called_class())) . '/';
    }

    //редирект
    function redirect($path = '/') {
//        debug($path);
        header('Location: ' . $path);
    }
    
    function refresh() {
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
    
    
   function link($path = '') {
        $link = '';
        if(App::gi()->default_lang !== App::gi()->uri->lang){
            $link = '/' . App::gi()->uri->lang;
        }
        return $link . $path;
   }

    private function _renderPartial($fullpath, $variables = array(), $output = true) {
        extract($variables);

        if (file_exists($fullpath)) {
            if (!$output)
                ob_start();
            include $fullpath;
            return !$output ? ob_get_clean() : true;
        } else
            throw new Except('File ' . $fullpath . ' not found');
    }

    /**
     * Рендер вида
     *
     * @params $filename - название темплейта в папке views / controller name / {}. php
     * @params $variables - массив занчений которые будут доступны из файла вида
     * @params $output - вывод на экран либо в переменную
     */
    public function renderPartial($filename, $variables = array(), $output = true) {
        $file = $this->tplControllerPath . str_replace('..', '', $filename) . '.php';
        return $this->_renderPartial($file, $variables, $output);
    }

    public function render($filename, $variables = array(), $output = true) {
        $this->renderPartial($filename, $variables, $output);
    }

    /**
     * render - рендер страницы
     */
    public function renderPage($content) {
        $html = $this->_renderPartial($this->tplPath . $this->mainTemplate . '.php', array('content' => $content), false);
        $output = array('head' => '', 'body' => '');
        foreach ($this->assets as $item) {
            if ($item['asset'] == 'script') {
                if ($item['type'] == 'inline') {
                    $output[$item['where']].='<script type="text/javascript">' . $item['data'] . '</script>' . "\n";
                } else {
                    $output[$item['where']].='<script type="text/javascript" src="' . $item['data'] . '"></script>' . "\n";
                }
            } else {
                if ($item['type'] == 'inline') {
                    $output[$item['where']].='<style>' . $item['data'] . '</style>' . "\n";
                } else {
                    $output[$item['where']].='<link rel="stylesheet" href="' . $item['data'] . '" type="text/css" />' . "\n";
                }
            }
        }
        if ($output['head']) {
            $html = preg_replace('#(<\/head>)#iu', $output['head'] . '$1', $html);
        }
        if ($output['body']) {
            $html = preg_replace('#(<\/body>)#iu', $output['body'] . '$1', $html);
        }

        echo $html;
    }

    //подключение скриптов и стилей
    private $assets = array();

    private function addAsset($link, $where = 'head', $asset = 'script', $type = 'url') {
        $hash = md5('addScript' . $link . $where . $asset . $type);
        $where = $where == 'head' ? 'head' : 'body';
        $asset = $asset == 'script' ? 'script' : 'style';
        if (!isset($this->assets[$hash])) {
            $this->assets[$hash] = array('where' => $where, 'asset' => $asset, 'type' => $type, 'data' => $link);
        }
    }

    public function addScript($link, $where = 'head') {
        $this->addAsset($link, $where);
    }

    public function addStyleSheet($link, $where = 'head') {
        $this->addAsset($link, $where, 'style');
    }

    public function addScriptDeclaration($data, $where = 'head') {
        $this->addAsset($data, $where, 'script', 'inline');
    }

    public function addStyleSheetDeclaration($data, $where = 'head') {
        $this->addAsset($data, $where, 'style', 'inline');
    }

}
