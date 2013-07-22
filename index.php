<?php

/* Main File */
require('common.php');

$_PAGES = array('home');

/* Recovering the parameters in the URL */
$ARGS = explode('/', isset($_GET['p']) ? $_GET['p'] : null);

if (isset($ARGS[0]) && in_array($ARGS[0], $_PAGES))
    require('include/php/part.' . $ARGS[0] . '.php');
else
    require('include/php/part.home.php');

require('include/php/part.general.php');

/* Display HTML */
include('templates/tpl/tpl.main.php');
?>