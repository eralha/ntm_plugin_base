<?php


spl_autoload_register(function ($class) {

    //Vemos se a class que está a tentar ser carregada tem o nosso name_space
    $index = strpos($class, 'ER', 0);
    //Se não tiver o nosso name space não carregamos
    if($index === false){ return false; }

    $dirName = dirname(__FILE__);
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    $file = str_replace('ER\\app', '', $file);

    $file = $dirName.$file;

    if (file_exists($file)) {
        require_once($file);
        return true;
    }
    return false;
});



?>