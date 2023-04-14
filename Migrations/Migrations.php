<?php

include_once('Fw/Migrations.php');
include_once('App/config/config.php');

class Migrations{
    
    static $migrations = [

        'create_users_tokens_table' => "CREATE TABLE ".AUTH_TABLE_TOKENS_NAME."(
            id INT NOT NULL AUTO_INCREMENT, 
            user_id VARCHAR(255) NOT NULL ,
            token VARCHAR(255) NOT NULL ,
            exp_date DATE,
            PRIMARY KEY (id)
            ) 
        ",

        'add_password_alumnos' => "ALTER TABLE `alumnos` ADD `PASSWORD` VARCHAR(100) NULL DEFAULT NULL AFTER `CODIGOPOSTAL`; "
    ]; 
    
}    

Migrator::exec(Migrations::$migrations);