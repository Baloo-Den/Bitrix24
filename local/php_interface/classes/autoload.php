<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
    die();
}

spl_autoload_register(function ($className) {
    $classPath = str_replace('\\', '/', $className);
    $file = __DIR__."/$classPath.php";
 //pr( $file);
    if (file_exists($file)) {
        include_once $file;
    }
});




