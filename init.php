<?php

//connection path:
include 'admin/connection.php';


// includes folder path:
$templates_path = 'includes/templates/';
$func_path = 'includes/functions/';
$lang_path = 'includes/languages/';
$libr_path = 'includes/libraries/';

//layout folder path:
$css    = 'layout/css/';
$fonts  = 'layout/fonts/';
$images = 'layout/img/';
$js     = 'layout/js/';


include $lang_path.'english.php';
include $func_path.'functions.php';
include $templates_path.'header.php';
if (!isset($noNavbar)) {
	include $templates_path.'navbar2.php';
}