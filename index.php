<?php
/**
 * TITAN PRO Mini MVC Framework
 *
 * Titan is a web application framework for php developers.
 *
 * @author 		Turan Karatuğ - <tkaratug@hotmail.com.tr> - <www.turankaratug.com>
 * @version 	1.0.0
 * @copyright	2016
 * @license		https://opensource.org/licenses/MIT
 * @link 		https://github.com/tkaratug/titan-pro
 */

// Constants
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', '/');
define('ROOT_DIR', realpath(dirname(__FILE__)) . DS);
define('APP_DIR', ROOT_DIR . 'App/');
define('SYSTEM_DIR', ROOT_DIR . 'System/');
define('PUBLIC_DIR', 'Public/');
define('VERSION', '1.0.0');
define('ENVIRONMENT', 'production'); // production | development

// Error Reporting
if(ENVIRONMENT == 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// General Functions
require_once SYSTEM_DIR . 'Core/Functions.php';

// Including Autoloader
require SYSTEM_DIR . 'Core/Autoload.php';

// Starting Titan
$App = new \Titan\Core\Router();
