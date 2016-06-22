<?php
namespace Titan\Models;

use Titan\Core\Import;
use Titan\Plugins\Database;

class Model
{
    public $db;

    public function __construct()
    {
    	// Including database configurations
        $db_config  = Import::Config('database');
        
        // Importing database plugin
        Import::Plugin('database', $db_config);

        // Initializing database plugin
        $this->db = Database::init($db_config);
    }
}