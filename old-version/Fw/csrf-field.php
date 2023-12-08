<?php
include_once('Fw/Csrf.php');
$_input = "<input hidden name='csrf' value=". CSRF::get() .">";
echo $_input;