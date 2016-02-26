<?php
namespace Titan\Controllers;

use Titan\Core\Import;

class Home extends Controller
{

    public function index()
    {
        Import::View('Home');
    }

    public function username($name)
    {
    	echo $name;
    }

    public function userage($age)
    {
    	echo $age;
    }

}