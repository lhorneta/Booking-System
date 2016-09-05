<?php

class Router extends Singleton {

    // private $path_elements = array('controller', 'action');

    function parse($path) {
        $request = $_REQUEST;
        $request['lang'] = '';
        $request['controller'] = app::gi()->config->default_controller;
        $request['action'] = app::gi()->config->default_action;
        $request['args'] = array();

        
        if(isset($request['route'])){
        
                $url = explode('/', $request['route']);

                if(isset($url[0]) && strtolower($url[0]) == 'cp'){
                    unset($url[0]);
                    $url = count($url) ? array_values($url) : array();
                }

                if(isset($url[0])){
                    if(strlen($url[0]) == 2){
                        $request['lang'] = $url[0];
                        unset($url[0]);
                        if(count($url)){
                            $url = array_values($url);
                        }
                    }
                }

                
                if(count($url)){
                    if(isset($url[0])){
                        if(!empty($url[0])){
                            $request['controller'] = $url[0];    
                        }
                        unset($url[0]);
                    }
                    if(isset($url[1])){
                        if(!empty($url[1])){
                            $request['action'] = $url[1];    
                        }
                        unset($url[1]);
                    }
    
                    if(!empty($url)){
                        $request['args'] = array_values($url);
                    }
                }

            }

        return $request;
    }

}
