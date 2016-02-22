<?php
namespace Titan\Plugins;

use Titan\Core\Import;

/**
 * Benchmark Plugin
 *
 * @package Titan\Plugins
 */

class Cookie
{
    // Cookie Config
    private     $config;

    // Security Seperator
    private     $seperator  = '--';

    // Cookie Path
    protected   $path       = '/';

    // Cookie Domain
    protected   $domain     = '';

    // Cookie Secure
    protected   $secure     = false;

    // HTTP Only
    protected   $http_only  = true;

    public function __construct()
    {
        $this->config = Import::Config('config');
    }

    /**
     * Set Cookie Path
     * @param   string  $path
     * @return  $this|bool
     */
    public function set_path($path)
    {
        if ( ! is_string($path) ) {
            return false;
        }

        $this->path = $path;

        return $this;
    }

    /**
     * Set Cookie Domain
     * @param   string  $domain
     * @return  $this|bool
     */
    public function set_domain($domain)
    {
        if ( ! is_string($domain) ) {
            return false;
        }

        $this->domain = $domain;

        return $this;
    }

    /**
     * Set Cookie Secure
     * @param   bool    $secure
     * @return  $this|bool
     */
    public function set_secure($secure = false)
    {
        if ( ! is_bool($secure) ) {
            return false;
        }

        $this->secure = $secure;

        return $this;
    }

    /**
     * Set Cookie HTTP Only
     * @param   bool    $http
     * @return  $this|bool
     */
    public function set_http_only($http = true)
    {
        if ( ! is_bool($http) ) {
            return false;
        }

        $this->http_only = $http;

        return $this;
    }

    /**
     * Setting Cookie
     * @param 	string 	$name
     * @param 	string 	$value
     * @param 	int 	$time
     * @return 	bool
     */
    public function set($name, $value, $time = null)
    {
        if(is_null($time)) {
            if($this->config['cookie_security'] == true)
                setcookie($name, $value . $this->seperator . md5($value . $this->config['encryption_key']), 0, $this->path, $this->domain, $this->secure, $this->http_only);
            else
                setcookie($name, $value, 0, $this->path, $this->domain, $this->secure, $this->http_only);
        } else {
            if($this->config['cookie_security'] == true)
                setcookie($name, $value . $this->seperator . md5($value . $this->config['encryption_key']), time() + (60*60*$time), $this->path, $this->domain, $this->secure, $this->http_only);
            else
                setcookie($name, $value, time() + (60*60*$time), $this->path, $this->domain, $this->secure, $this->http_only);
        }
    }

    /**
     * Getting Cookie
     * @param 	string 	$name
     * @return 	string
     */
    public function get($name)
    {
        if($this->has($name)) {
            if($this->config['cookie_security'] == true) {
                $slices = explode($this->seperator, $_COOKIE[$name]);
                if(md5($slices[0] . $this->config['encryption_key']) == $slices[1]) {
                    return $slices[0];
                } else {
                    echo get_error('Errors', 'manipulated_cookie');
                    die();
                }
            } else {
                return $_COOKIE[$name];
            }
        }
    }

    /**
     * Delete Cookie
     * @param 	string 	$name
     * @return 	bool
     */
    public function delete($name)
    {
        if($this->has($name)) {
            unset($_COOKIE[$name]);
            setcookie($name, '', time() - 3600, $this->path, $this->domain);
        } else {
            return false;
        }
    }

    /**
     * Is Cookie Exists
     * @param 	string 	$name
     * @return 	bool
     */
    public function has($name)
    {
        if(isset($_COOKIE[$name]))
            return true;
        else
            return false;
    }
}