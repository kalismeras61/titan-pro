<?php
/**
 * Routes
 * Turan Karatuğ - <tkaratug@hotmail.com.tr>
 */

$config['routes']['anasayfa'] 				= 'Home/index';
$config['routes']['username/([a-zA-Z]+)'] 	= 'Home/username/$1';
$config['routes']['userage/(\d+)'] 			= 'Home/userage/$1';