<?php 


function autoload($className) {
    $classPath = strtr(__DIR__."/app/". $className.".php", "/\\", DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR);
    if (file_exists($classPath)) {
        include_once $classPath;
    }
}


function coreAutoload($className) {
    $classPath = strtr(__DIR__."/core/". $className.".php", "/\\", DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR);
    if (file_exists($classPath)) {
        include_once $classPath;
    }
}

spl_autoload_register('autoload');
spl_autoload_register('coreAutoload');
