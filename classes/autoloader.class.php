<?php

class Autoloader
{

    public static function loader($className)
    {
        $filename = "classes/" .
            str_replace("\\", '/', $className) .
            ".class.php";

        if (file_exists($filename)) {

            require_once($filename);

            if (class_exists($className)) {
                return true;
            }
        }
        return false;
    }
}

spl_autoload_extensions('.class.php');
spl_autoload_register('Autoloader::loader');
