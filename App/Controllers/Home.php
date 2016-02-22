<?php
namespace Titan\Controllers;

use Titan\Core\Import;

class Home extends Controller
{

    public function index()
    {
        Import::View('Home');
    }

}