<?php

class Router extends Singleton
{
    public function parse($path)
    {
        $request = $_REQUEST;
        $request['lang'] = Settings::lang();
        $request['controller'] = App::gi()->config->default_controller;
        $request['action'] = App::gi()->config->default_action;
        $request['id'] = array();
        $parts = parse_url($path);
        if (isset($parts['query']) and ! empty($parts['query'])) {
            $path = str_replace('?' . $parts['query'], '', $path);
            parse_str($parts['query'], $req);
            $request = array_merge($request, $req);
        }
        foreach (App::gi()->config->router as $rule => $keypath) {
            if (preg_match('#' . $rule . '#sui', $path, $list)) {
                for ($i = 1; $i < count($list); $i = $i + 1) {
                    $keypath = preg_replace('#\$[a-z0-9]+#', $list[$i], $keypath, 1);
                }
                $keypath = explode('/', $keypath);
                
                $request['controller'] = $keypath[0];
                unset($keypath[0]);
                
                if(isset($keypath[1])){
                    $request['action'] = $keypath[1];
                    unset($keypath[1]);
                }
                
                $argsCount = count($keypath);
                if($argsCount > 0){
                    $keypath = array_values($keypath);
                    for($i=0; $i<$argsCount; $i++){
                        $request['id'][] = $keypath[$i];
                    }
                }
                break;
            }
        }
        return $request;
    }
}
