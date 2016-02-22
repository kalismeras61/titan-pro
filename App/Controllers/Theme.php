<?php
namespace Titan\Controllers;

use Titan\Core\Import;
use Titan\Plugins\Template;

class Theme extends Controller
{

    public function index()
    {
        Template::set_title('Welcome to TITAN Pro');
        Template::set_favicon('favicon.ico');
        Template::set_css('style.css');
        Import::View('theme');
    }

}