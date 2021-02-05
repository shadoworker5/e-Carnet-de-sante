<?php

use Illuminate\Routing\Route;

if(!function_exists('get_title')){
    function get_title($title){
        $base_title = config('app.name');
        
        if($title === ''){
            return $base_title;
        }else{
            return $title.' | '.$base_title;
        }
    }
}

if(!function_exists('set_active_route')){
    function set_active_route($route){
        // Route::is($route) ? 'active' :
        return  '';
    }
}