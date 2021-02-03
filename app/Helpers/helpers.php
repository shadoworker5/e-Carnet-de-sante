<?php

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