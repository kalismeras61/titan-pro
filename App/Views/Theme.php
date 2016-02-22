<?php \Titan\Core\Import::View('Layouts/Header'); ?>

    <div id="logo">
        <img src="<?php echo get_image('titan.png'); ?>" width="90" />
    </div>
    <div id="container">
        <h3>Welcome to <span class="error_code">TITAN Pro</span></h3>
        <p>This is theme page.</p>
    </div>
    <div id="footer">
        <span class="copyright">Developed by <a href="http://www.turankaratug.com" target="_blank">Turan Karatuğ</a></span>
        <span class="version">Version <?php echo VERSION; ?> | <?php echo \Titan\Core\Titan::$lib->benchmark->memory_usage(); ?></span>
    </div>

<?php \Titan\Core\Import::View('Layouts/Footer'); ?>
