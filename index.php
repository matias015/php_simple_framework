<?php


date_default_timezone_set('America/Argentina/Buenos_Aires');    

include_once('Fw/Autoload.php');

use \Fw\Routing;

include_once('App/Routes/web.php');

Routing::dispatch();