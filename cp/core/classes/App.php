<?php

class App extends Singleton {

    public $config = null;
    public $uri = null;
    public $user = null;
    public $user_role = 'guest';
    public $default_lang = '';
    public $translate = array();

    public function __construct() {
        $this->initSystemHandlers();
        $default_config = include CORE . 'config.php';
        $custom_config = include APP . 'config.php';
        $this->config = new Registry(array_merge($default_config, $custom_config));
        require CORE . 'classes/adapter/db.php';
    }

    function start() {
        $this->uri = new Registry(Router::gi()->parse($_SERVER['REQUEST_URI']));
        $controller = null;
        if (class_exists($this->uri->controller . 'Controller')) {
            $this->loadUser();

            if ($this->isAllowed($this->uri->controller . 'Controller', $this->uri->action)) {
                $controller = app::gi($this->uri->controller . 'Controller');
            }
        } else {
            Controller::gi()->redirect(App::gi()->config->path_error_controller . '/404');
        }
        ob_start();
        $controller->__call('action' . $this->uri->action, $this->uri->args);
        $content = ob_get_clean();
        if ($this->config->scripts and is_array($this->config->scripts)) {
            foreach ($this->config->scripts as $script) {
                $controller->addScript($script);
            }
        }
        if ($this->config->styles and is_array($this->config->styles)) {
            foreach ($this->config->styles as $style) {
                $controller->addStyleSheet($style);
            }
        }
        $controller->renderPage($content);
    }

    private function loadTranslate() {
        if (file_exists(ROOT . 'lang/' . $this->uri->lang . '.php')) {
            require_once ROOT . 'lang/' . $this->uri->lang . '.php';
            $this->translate = $text;
        }
    }

    public function loadUser() {
        if (Auth::issetCookie('auth_token')) {
            $user = User::modelWhere('auth_token = ?', array($_COOKIE['auth_token']));
            if ($user) {
                $this->user = $user;
                $this->user_role = $user->role()->title;
            }
        }
    }

    public function isAuthorize() {
        return ($this->user instanceof User) ? true : false;
    }

    function isAllowed($controller, $action) {
//        if(discardShares()){
//            die('Discard');
//            rewritePackagePrices();
//        }
//        if(countNoShareProducts()){
//            die('No share products');
//            $shares = attachShareToProducts();
//            rewritePackagePrices();
//            attachShareToPackages($shares);
//        }
//        if(countNoSharePackages()){
//            die('No share packages');
//            attachShareToPackages($shares);            
//        }
        
        $rules = $controller::$rules;
        
        if (array_key_exists($action, $rules)) {

            if (in_array($this->user_role, $rules[$action]['users'])) {
                return true;
            } else if (in_array('*', $rules[$action]['users'])) {
                return true;
            } else {
                Controller::gi()->redirect($rules[$action]['redirect']);
            }
        } else {
            Controller::gi()->redirect('/cp/error/404');
        }



//        if (array_key_exists('*', $rules)) {
//            if (in_array('*', $rules['*']['users'])) {
//                return true;
//            } else {
//                if (in_array($this->user_role, $rules['*']['users'])) {
//                    return true;
//                }
//            }
//        } else {
//            if (array_key_exists($action, $rules)) {
//                if (in_array('*', $rules[$action]['users'])) {
//                    return true;
//                } else {
//                    if (in_array($this->user_role, $rules[$action]['users'])) {
//                        return true;
//                    }
//                }
//            }
//        }

        $redirect_path = empty($action) ? $rules['*']['redirect'] : $rules[$action]['redirect'];
        Controller::gi()->redirect($redirect_path);
    }


    protected function initSystemHandlers() {
        set_exception_handler(array($this, 'handleException'));
        set_error_handler(array($this, 'handleError'), error_reporting());
    }

    public function handleError($code, $message, $file, $line) {
        if ($code & error_reporting()) {
            restore_error_handler();
            restore_exception_handler();
            try {
                $this->displayError($code, $message, $file, $line);
            } catch (Exception $e) {
                $this->displayException($e);
            }
        }
    }

    public function handleException($exception) {
        restore_error_handler();
        restore_exception_handler();
        $this->displayException($exception);
    }

    public function displayError($code, $message, $file, $line) {
        echo "<h1>PHP Error [$code]</h1>\n";
        echo "<p>$message ($file:$line)</p>\n";
        echo '<pre>';

        $trace = debug_backtrace();

        if (count($trace) > 3)
            $trace = array_slice($trace, 3);

        foreach ($trace as $i => $t) {
            if (!isset($t['file']))
                $t['file'] = 'unknown';
            if (!isset($t['line']))
                $t['line'] = 0;
            if (!isset($t['function']))
                $t['function'] = 'unknown';
            echo "#$i {$t['file']}({$t['line']}): ";
            if (isset($t['object']) && is_object($t['object']))
                echo get_class($t['object']) . '->';
            echo "{$t['function']}()\n";
        }

        echo '</pre>';
        exit();
    }

    public function displayException($exception) {
        echo '<h1>' . get_class($exception) . "</h1>\n";
        echo '<p>' . $exception->getMessage() . ' (' . $exception->getFile() . ':' . $exception->getLine() . ')</p>';
        echo '<pre>' . $exception->getTraceAsString() . '</pre>';
    }

}
