<?php
include_once('vendor/autoload.php');
require_once('Fw/Auth.php');
require_once('Fw/Session.php');
require_once('Fw/Request.php');
include_once('Fw/Response.php');

require_once('App/Routes/web.php');


Routing::dispatch();