<?php
return array(
    'sitename' => 'Stuffex',
    'layout' => 'base',
    'db' => include ('config.db.php'),
    'path_error_controller' => '/cp/error',
//    'error_url' => '/cp/error',
    'router' => array(
        //'cp/([a-z0-9+_\-]+)/([a-z0-9+_\-]+)/([0-9]+)' => '$controller/$action/$id',
    	'([a-z]{2})/cp/([a-z0-9+_\-]+)/([a-z0-9+_\-]+)' => '$lang/$controller/$action',
        '([a-z]{2})/cp/([a-z0-9+_\-]+)/?' => '$lang/$controller',

        '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)' => '$controller/$action',
        '([a-z0-9+_\-]+)' => '$controller',
        'cp/login'=>'index/login'
    ),
);

