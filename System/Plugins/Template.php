<?php
namespace Titan\Plugins;

use Titan\Core\Import;

/**
 * Template Plugin
 *
 * Turan Karatuğ - <tkaratug@hotmail.com.tr>
 */

class Template
{
    // Asset Selector
    public static $asset = [];

    /**
     * Set CSS files.
     * @param 	$css_file 	string	(file path or url)
     * @param 	$source 	string	(local|remote)
     * @return 	void
     */
    public static function set_css($css_file, $source = 'local')
    {
        if($source == 'remote') {
            $url = $css_file;
            self::$asset['header']['css'][]	= '<link rel="stylesheet" type="text/css" href="' . $url . '">';
        } else {
            $url = 'public/css/' . $css_file;

            // Check is file exists
            if(!file_exists(ROOT_DIR . $url)) {
                $data['code'] = 1005;
                $data['text'] = lang('Errors', 'missing_css_file', $url);
                Import::View('Errors/Error_404', $data);
                die();
            }

            self::$asset['header']['css'][]	= '<link rel="stylesheet" type="text/css" href="' . base_url($url) . '">';
        }
    }

    /**
     * Set JS files.
     * @param 	$js_file	string	(file path or url)
     * @param 	$location 	string 	(header|footer)
     * @param 	$source 	string	(local|remote)
     * @return 	void
     */
    public static function set_js($js_file, $location = 'header', $source = 'local')
    {
        if($source == 'remote') {
            $url = $js_file;
            self::$asset[$location]['js'][]	= '<script type="text/javascript" src="' . $url . '"></script>';
        } else {
            $url = 'public/js/' . $js_file;

            // Check is file exists
            if(!file_exists(ROOT_DIR . $url)) {
                $data['code'] = 1006;
                $data['text'] = lang('Errors', 'missing_js_file', $url);
                Import::View('Errors/Error_404', $data);
                die();
            }

            self::$asset[$location]['js'][]	= '<script type="text/javascript" src="' . base_url($url) . '"></script>';
        }
    }

    /**
     * Set Meta Tags
     * @param 	$meta_name 		string	(meta tag name)
     * @param 	$meta_content 	string	(meta tag content)
     * @return 	void
     */
    public static function set_meta($meta_name, $meta_content)
    {
        self::$asset['header']['meta'][] = '<meta name="' . $meta_name . '" content="' . $meta_content . '">';
    }

    /**
     * Set Page Title
     * @param 	$title string
     * @return 	void
     */
    public static function set_title($title)
    {
        self::$asset['header']['title'] = '<title>' . $title . '</title>';
    }

    /**
     * Set favicon
     * @param 	$image 	string
     * @param 	$type 	string
     * @return 	void
     */
    public static function set_favicon($image)
    {
        $image_file = explode('.', $image);
        $extension 	= end($image_file);

        // Check is file exists
        if(!file_exists(ROOT_DIR . '/public/images/' . $image)) {
            $data['code'] = 1005;
            $data['text'] = lang('Errors', 'missing_favicon_file', $image);
            Import::View('Errors/Error_404', $data);
            die();
        }

        switch($extension) {
            case 'png' 	: $icon_type = 'image/png'; break;
            case 'ico' 	: $icon_type = 'image/x-icon'; break;
            default 	: $icon_type = 'image/x-icon'; break;
        }

        self::$asset['header']['favicon'] = '<link rel="shortcut icon" type="' . $icon_type . '" href="' . base_url('public/images/' . $image) . '" />';
    }

    /**
     * Get CSS Files
     * @return array
     */
    public static function get_css()
    {
        if(array_key_exists('header', self::$asset) && array_key_exists('css', self::$asset['header']))
            return self::$asset['header']['css'];
        else
            return null;
    }

    /**
     * Get JS Files
     * @param 	$location 	(header|footer)
     * @return 	array
     */
    public static function get_js($location = 'header')
    {
        if(array_key_exists($location, self::$asset) && array_key_exists('js', self::$asset[$location]))
            return self::$asset[$location]['js'];
        else
            return null;
    }

    /**
     * Get Meta Tags
     * @return array
     */
    public static function get_meta()
    {
        if(array_key_exists('header', self::$asset) && array_key_exists('meta', self::$asset['header']))
            return self::$asset['header']['meta'];
        else
            return null;
    }

    /**
     * Get Page Title
     * @return string
     */
    public static function get_title()
    {
        if(array_key_exists('header', self::$asset) && array_key_exists('title', self::$asset['header']))
            return self::$asset['header']['title'];
        else
            return null;
    }

    /**
     * Get favicon
     * @return string
     */
    public static function get_favicon()
    {
        if(array_key_exists('header', self::$asset) && array_key_exists('favicon', self::$asset['header']))
            return self::$asset['header']['favicon'];
        else
            return null;
    }
}