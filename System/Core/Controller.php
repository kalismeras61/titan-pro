<?php
namespace Titan\Controllers;

use Titan\Core\Import;

class Controller
{

    protected $autoload;

    public function __construct()
    {
        // Getting autoload config file
        $this->autoload = Import::Config('autoload');

        // Autoload plugins
        $this->autoload_plugins();

        // Autoload helpers
        $this->autoload_helpers();
    }

    /**
     * Plugin Autoloader
     */
    public function autoload_plugins()
    {
        if(count($this->autoload['plugins']) > 0) {
            foreach($this->autoload['plugins'] as $plugin) {
                $plugin_name    = ucfirst($plugin);
                $this->$plugin  = Import::Plugin($plugin_name);
            }
        }
    }

    /**
     * Helper Autoloader
     */
    public function autoload_helpers()
    {
        if(count($this->autoload['helpers']) > 0) {
            foreach($this->autoload['helpers'] as $helper) {
                $helper_name = ucfirst($helper);
                Import::Helper($helper_name);
            }
        }
    }

}