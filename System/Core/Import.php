<?php
namespace Titan\Core;

class Import
{

    /**
     * Load Model
     * @param   string  $model
     * @param   string  $custom_name
     * @return  obj|string
     */
    public static function Model($model)
    {
        if(class_exists('\Titan\Models\\' . ucfirst($model))) {
            $modelClass = '\Titan\Models\\' . ucfirst($model);
            self::use_library('\Titan\Models\\' . $model);
            return new $modelClass;
        } else {
            $data['code'] = 404;
            $data['text'] = lang('Errors', 'missing_model') . ': { ' . $model . ' }';
            self::View('Errors/Error_404', $data);
            die();
        }
    }

    /**
     * Load View
     * @param   string  $view
     * @param   array   $data
     */
    public static function View($view, $data = [])
    {
        if(file_exists(APP_DIR . 'Views/' . ucfirst($view) . '.php')) {
            extract($data);
            require_once APP_DIR . 'Views/' . ucfirst($view) . '.php';
        } else {
            $data['code'] = 404;
            $data['text'] = lang('Errors', 'missing_view') . ': { ' . $view . ' }';
            extract($data);
            require_once APP_DIR . 'Views/Errors/Error_404.php';
            die();
        }
    }

    /**
     * Load Plugin
     * @param   string $plugin
     * @return  obj|string
     */
    public static function Plugin($plugin, $params = null)
    {
        if(file_exists(APP_DIR . 'Plugins/' . ucfirst($plugin) . '/' . ucfirst($plugin) . '.php')) {
            require_once APP_DIR . 'Plugins/' . ucfirst($plugin) . '/' . ucfirst($plugin) . '.php';
            $plugin_class = '\Titan\Plugins\\' . ucfirst($plugin);
            if(is_null($params)) {
                self::use_library('\Titan\Plugins\\' . $plugin);
                return new $plugin_class;
            } else {
                self::use_library('\Titan\Plugins\\' . $plugin, $params);
                return new $plugin_class($params);
            }
        } elseif(file_exists(APP_DIR . 'Plugins/' . ucfirst($plugin) . '.php')) {
            require_once APP_DIR . 'Plugins/' . ucfirst($plugin) . '.php';
            $plugin_class = '\Titan\Plugins\\' . ucfirst($plugin);
            if(is_null($params)) {
                self::use_library('\Titan\Plugins\\' . $plugin);
                return new $plugin_class;
            } else {
                self::use_library('\Titan\Plugins\\' . $plugin, $params);
                return new $plugin_class($params);
            }
        } elseif(file_exists(SYSTEM_DIR . 'Plugins/' . ucfirst($plugin) . '/' . ucfirst($plugin) . '.php')) {
            require_once SYSTEM_DIR . 'Plugins/' . ucfirst($plugin) . '/' . ucfirst($plugin) . '.php';
            $plugin_class = '\Titan\Plugins\\' . ucfirst($plugin);
            if(is_null($params)) {
                self::use_library('\Titan\Plugins\\' . $plugin);
                return new $plugin_class;
            } else {
                self::use_library('\Titan\Plugins\\' . $plugin, $params);
                return new $plugin_class($params);
            }
        } elseif(file_exists(SYSTEM_DIR . 'Plugins/' . ucfirst($plugin) . '.php')) {
            require_once SYSTEM_DIR . 'Plugins/' . ucfirst($plugin) . '.php';
            $plugin_class   = '\Titan\Plugins\\' . ucfirst($plugin);
            if(is_null($params)) {
                self::use_library('\Titan\Plugins\\' . $plugin);
                return new $plugin_class;
            } else {
                self::use_library('\Titan\Plugins\\' . $plugin, $params);
                return new $plugin_class($params);
            }
        } else {
            $data['code'] = 404;
            $data['text'] = lang('Errors', 'missing_plugin') . ': { ' . $plugin . ' }';
            self::View('Errors/Error_404', $data);
            die();
        }
    }

    /**
     * Load Helper
     * @param   string  $helper
     */
    public static function Helper($helper)
    {
        if(file_exists(APP_DIR . 'Helpers/' . ucfirst($helper) . '.php')) {
            require_once APP_DIR . 'Helpers' . ucfirst($helper) . '.php';
        } elseif(file_exists(SYSTEM_DIR . 'Helpers/' . ucfirst($helper) . '.php')) {
            require_once SYSTEM_DIR . 'Helpers/' . ucfirst($helper) . '.php';
        } else {
            $data['code'] = 404;
            $data['text'] = lang('Errors', 'missing_helper') . ': { ' . $helper . ' }';
            self::View('Errors/Error_404', $data);
            die();
        }
    }

    /**
     * Load Config
     * @param   string  $config
     */
    public static function Config($file)
    {
        if(file_exists(APP_DIR . 'Config/' . ucfirst($file) . '.php')) {
            require APP_DIR . 'Config/' . ucfirst($file) . '.php';
            return $config[$file];
        } else {
            $data['code'] = 404;
            $data['text'] = lang('Errors', 'missing_config') . ': { ' . $file . ' }';
            self::View('Errors/Error_404', $data);
            die();
        }
    }

    /**
     * Load Custom File
     * @param   string  $file
     */
    public static function File($file)
    {
        if(file_exists(ROOT_DIR . '/' . $file)) {
            require ROOT_DIR . '/' . $file;
        } else {
            $data['code'] = 404;
            $data['text'] = lang('Errors', 'missing_file') . ': { ' . $file . ' }';
            self::View('Errors/Error_404', $data);
            die();
        }
    }

    /**
     * @param   string  $class
     * @param   string  $params
     * @return  obj
     */
    private static function use_library($class, $params = null)
    {
        $parts      = explode('\\', $class);
        $library    = strtolower(end($parts));

        if(!isset(Titan::$lib->$library)) {
            if(!is_object(Titan::$lib)) {
                Titan::$lib = new \stdClass();
            }

            if(is_null($params))
                Titan::$lib->$library = new $class;
            else
                Titan::$lib->$library = new $class($params);
        }

        return Titan::$lib->$library;
    }

}