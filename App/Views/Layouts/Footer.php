    <?php
    // Custom JS Files
    if(\Titan\Plugins\Template::get_js('footer')) {
        foreach(\Titan\Plugins\Template::get_js('footer') as $js_file) {
            echo $js_file . "\n";
        }
    }
    ?>
</body>
</html>