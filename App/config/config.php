<?php

define("BASE_URL", '127.0.0.1/iseta_web/');

define('AUTH_TABLE_NAME','alumnos');
define('AUTH_ID_NAME','id_alumno');
define('AUTH_TABLE_TOKENS_NAME','user_tokens');

define('COOKIE_EXPIRATION_TIME','+2 day');
define('SECURE_COOKIES', true);
define('HTTP_COOKIES_ONLY', true);
define('LOGIN_EXPIRATION_TIME', 9999100);
define('DELETE_DUPLICATED_COOKIES', true);

define('DB_TYPE','mysql');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_DBNAME','movedb');
define('DB_HOST','127.0.0.1');

define('MAIL_HOST','sandbox.smtp.mailtrap.io');   
define('MAIL_SMTP_AUTH',true); 
define('MAIL_USERNAME','af5abb26f9dc63');
define('MAIL_PASSWORD','fa016bcca8a71c');      
define('MAIL_PORT',25 ); 