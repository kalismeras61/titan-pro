<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
    // Page Title
    if(\Titan\Plugins\Template::get_title())
        echo \Titan\Plugins\Template::get_title() . "\n";

    // Meta Tags
    if(\Titan\Plugins\Template::get_meta()) {
        foreach(\Titan\Plugins\Template::get_meta() as $meta_tag) {
            echo $meta_tag . "\n";
        }
    }

    // Favicon
    if(\Titan\Plugins\Template::get_favicon())
        echo \Titan\Plugins\Template::get_favicon() . "\n";

    // Custom CSS Files
    if(\Titan\Plugins\Template::get_css()) {
        foreach(\Titan\Plugins\Template::get_css() as $css_file) {
            echo $css_file . "\n";
        }
    }

    // Custom JS Files
    if(\Titan\Plugins\Template::get_js('header')) {
        foreach(\Titan\Plugins\Template::get_js('header') as $js_file) {
            echo $js_file . "\n";
        }
    }
    ?>
</head>
<body>