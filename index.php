<?php
require_once('App/config/initial.php');

require_once('Fw/Auth.php');
require_once('Fw/Session.php');
require_once('Fw/Request.php');

require_once('App/Routes/web.php');

echo 2;
Route::dispatch();