<?php
namespace Titan\Core;

class App
{

    protected $config;
    protected $url;

    public function __construct()
    {
        $this->config   = Import::Config('config');
        $this->url      = $this->parseURL();
    }

    /**
     * Parsing URL
     * @return array
     */
    public function parseURL()
    {
        $userURI = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $userURI = str_replace(BASE_DIR, '', $userURI);
        $userURI = rtrim($userURI, '/');
        $userURI = ltrim($userURI, '/');
        $userURI = explode('/', $userURI);
        $userURI = array_filter($userURI);
        return $userURI;
    }

    /**
     * Making URL
     * @param 	string $queryString
     * @return 	string
     */
    public function makeURL($queryString)
    {
        $queryString = ucwords(strtolower(str_replace(['-','_','%20'],[' ',' ',' '],$queryString)));
        $queryString = str_replace(' ','_',$queryString);
        return $queryString;
    }

}