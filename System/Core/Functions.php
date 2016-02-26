<?php
/**
 * Main Functions
 *
 * Turan Karatuğ - <tkaratug@hotmail.com.tr>
 */

use \Titan\Core\Import;

/**
 * Get current language
 * @return  string
 */
if( ! function_exists('get_lang') ) {
    function get_lang()
    {
        $config = Import::Config('language');

        if( ! isset($_SESSION) ) {
            session_start();
        }

        if( ! isset($_SESSION[md5('lang')]) ) {
            return $_SESSION[md5('lang')] = $config['default_language'];
        } else {
            return $_SESSION[md5('lang')];
        }
    }
}

/**
 * Set language
 * @param   $lang   string
 * @return  void
 */
if( ! function_exists('set_lang') ) {
    function set_lang($lang = '')
    {
        $config = Import::Config('language');

        if( ! is_string($lang) ) {
            return false;
        }

        if( empty($lang) ) {
            $lang = $config['default_language'];
        }

        if( ! isset($_SESSION) ) {
            session_start();
        }

        $_SESSION[md5('lang')] = $lang;
    }
}

/**
 * Get string with current language
 * @param   $file   string
 * @param   $ley    string
 * @param   $change string
 * @return  string
 */
if ( ! function_exists('lang') ) {
    function lang($file = '', $key = '', $change = '')
    {
        global $lang;

        $config = Import::Config('language');

        if( ! is_string($file) || ! is_string($key) ) {
            return false;
        }

        $appLangDir = APP_DIR . 'Languages/' . ucfirst($config['languages'][get_lang()]) . '/' . ucfirst($file) . '.php';
        $sysLangDir = SYSTEM_DIR . 'Languages/' . ucfirst($config['languages'][get_lang()]) . '/' . ucfirst($file) . '.php';

        if( file_exists($appLangDir) ) {
            require_once $appLangDir;
        } elseif ( file_exists($sysLangDir) ) {
            require_once $sysLangDir;
        }

        $zone = strtolower($file);

        if( array_key_exists($key, $lang[$zone]) ) {
            $str = $lang[$zone][$key];

            // Change special words
            if( ! is_array($change) ) {
                if( ! empty($change) ) {
                    return str_replace('%s', $change, $str);
                } else {
                    return $str;
                }
            } else {
                if( ! empty($change) ) {
                    $keys = [];
                    $vals = [];

                    foreach($change as $key => $value) {
                        $keys[] = $key;
                        $vals[] = $value;
                    }

                    return str_replace($keys, $vals, $str);
                } else {
                    return $str;
                }
            }

        } else {
            return false;
        }
    }
}

/**
 * Get error message with current language
 * @param   $lang_file  string
 * @param   $key        string
 * @param   $change     string
 * @return  string
 */
if ( ! function_exists('get_error') ) {
    function get_error($lang_file = '', $key = '', $change = '')
    {
        $style = '
            border:solid 0px #ccc;
            background:#EEEEEE;
            padding:10px;
            margin-bottom:10px;
            font-family:Calibri, Tahoma, Arial;
            color:#BC5858;
            text-align:left;
            font-size:13px;
        ';

        if( ! empty($change) ) {
            $change = '<strong>' . $change . '</strong>';
        }

        $str  = "<div style=\"$style\">";
        $str .= lang($lang_file, $key, $change);
        $str .= '</div>';

        return $str;
    }
}

/**
 * String Debug
 * @param 	string 	$data
 * @param 	bool 	$stop
 * @return 	string
 */
if( ! function_exists('debug')) {
    function debug($data, $stop = false)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        if($stop)
            die();
    }
}

/**
 * Save log messages
 * @param   $level      int
 * @param   $message    string
 * @return  void
 */
if ( ! function_exists('save_log') ) {
    function save_log($level = '', $message = '')
    {
        if( ! is_int($level) || ! is_string($message)) {
            return false;
        }

        $log_levels = [
            0 => 'EMERGENCY',
            1 => 'ALERT',
            2 => 'CRITICAL',
            3 => 'ERROR',
            4 => 'WARNING',
            5 => 'NOTICE',
            6 => 'INFO',
            7 => 'DEBUG'
        ];

        $log_text   = date('Y-m-d H:i:s') . ' ----> ' . $log_levels[$level] . ' : ' . $message;
        $file_name  = 'log-' . date('Y-m-d') . '.log';
        $file       = fopen(APP_DIR . 'Logs/' . $file_name, 'a');

        if(fwrite($file, $log_text . "\n") === false) {
            echo get_error('Errors', 'file_write_error', 'Log');
        }

        fclose($file);
    }
}

/**
 * Getting Request Scheme
 * @return string
 */
if ( ! function_exists('protochol') ) {
    function protochol()
    {
        return $_SERVER['REQUEST_SCHEME'] . '://';
    }
}

/**
 * Getting Http Host
 * @return string
 */
if ( ! function_exists('http_host') ) {
    function http_host()
    {
        return $_SERVER['HTTP_HOST'];
    }
}

/**
 * Getting Request URI
 * @return string
 */
if ( ! function_exists('request_uri') ) {
    function request_uri()
    {
        return $_SERVER['REQUEST_URI'];
    }
}

/**
 * Getting Full Path of application
 * @return string
 */
if ( ! function_exists('full_path') ) {
    function full_path()
    {
        return protochol() . http_host() . request_uri();
    }
}

/**
 * Getting Current Url
 * @return string
 */
if ( ! function_exists('current_url') ) {
    function current_url()
    {
        return protochol() . http_host() . request_uri();
    }
}

/**
 * Getting base url of application
 * @return string
 */
if ( ! function_exists('base_url') ) {
    function base_url($path = null)
    {
        if(is_null($path)) {
            if(BASE_DIR == '/')
                return protochol() . http_host();
            else
                return protochol() . http_host() . BASE_DIR;
        } else {
            if( ! is_string($path) ) {
                return false;
            }

            if(BASE_DIR == '/')
                return protochol() . http_host() . '/' . $path;
            else
                return protochol() . http_host() . BASE_DIR . '/' . $path;
        }
    }
}

/**
 * Getting URL segments
 * @param 	int $index
 * @return 	array | string
 */
if ( ! function_exists('get_segments') ) {
    function get_segments($index = null)
    {
        $segments = explode('/', trim(parse_url(request_uri(), PHP_URL_PATH), '/'));
        if(is_null($index)) {
            return $segments;
        } else {
            if( ! is_int($index) ) {
                return false;
            }

            if(array_key_exists($index, $segments))
                return $segments[$index];
            else
                return get_error('Errors', 'segment_error', $index);
        }
    }
}

/**
 * Getting current segment
 * @return string
 */
if ( ! function_exists('current_segment')) {
    function current_segment()
    {
        return get_segments( count(get_segments()) - 1 );
    }
}

/**
 * Getting image file
 * @param 	string 	$filepath
 * @return 	string
 */
if ( ! function_exists('get_image')) {
    function get_image($filepath)
    {
        if( ! is_string($filepath) ) {
            return false;
        }

        return base_url(PUBLIC_DIR . 'images/' . $filepath);
    }
}

/**
 * Getting CSS Style File
 * @param 	string 	$filepath
 * @return 	string
 */
if ( ! function_exists('get_css')) {
    function get_css($filepath)
    {
        if( ! is_string($filepath) ) {
            return false;
        }

        return base_url(PUBLIC_DIR . 'css/' . $filepath);
    }
}

/**
 * Getting JS File
 * @param 	string 	$filepath
 * @return 	string
 */
if ( ! function_exists('get_js')) {
    function get_js($filepath)
    {
        if( ! is_string($filepath) ) {
            return false;
        }

        return base_url(PUBLIC_DIR . 'js/' . $filepath);
    }
}

/**
 * Redirection
 * @param 	string 	$link
 * @return 	void
 */
if ( ! function_exists('redirect')) {
    function redirect($link, $method = 'location')
    {
        if( ! is_string($link) ) {
            return false;
        }

        if($method == 'refresh')
            header("Refresh:0;url=" . $link);
        else
            header("Location:" . $link);
    }
}

/**
 * URL Validation
 * @param   $url    string
 * @return  bool
 */
if ( ! function_exists('is_url') ) {
    function is_url($url) {
        if( ! is_string($url) ) {
            return false;
        }

        if(filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}

/**
 * E-Mail Validation
 * @param   $email  string
 * @return  bool
 */
if( ! function_exists('is_email') ) {
    function is_email($email) {
        if( ! is_string($email) ) {
            return false;
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}