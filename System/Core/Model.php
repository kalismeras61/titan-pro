<?php
namespace Titan\Models;

use Titan\Core\Import;

class Model
{
    public $db;

    public function __construct()
    {
        $db_config  = Import::Config('database');
        $this->db   = Import::Plugin('database', $db_config);
    }
}