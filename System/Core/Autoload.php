<?php
namespace Titan\Core;

class Autoload
{
    /**
     * Controller Autoloader
     * @param $controller
     */
    public static function loadController($controller)
    {
        $parts  = explode('\\', $controller);
        $file   = APP_DIR . 'Controllers' . DS . end($parts) . '.php';

        if(file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * Model Autoloader
     * @param $model
     */
    public static function loadModel($model)
    {
        $parts  = explode('\\', $model);
        $file   = APP_DIR . 'Models' . DS . end($parts) . '.php';

        if(file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * Core Autoloader
     * @param $core
     */
    public static function loadCore($core)
    {
        $parts  = explode('\\', $core);
        $file   = SYSTEM_DIR . 'Core' . DS . end($parts) . '.php';

        if(file_exists($file)) {
            require_once $file;
        }
    }
    
}

spl_autoload_register(__NAMESPACE__ . "\\Autoload::loadCore");
spl_autoload_register(__NAMESPACE__ . "\\Autoload::loadController");
spl_autoload_register(__NAMESPACE__ . "\\Autoload::loadModel");