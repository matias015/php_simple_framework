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

        'create_reset_password_table' => "CREATE TABLE `movedb`.password_reset (`id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(150) , `token` VARCHAR(150) NULL , PRIMARY KEY (`id`))",

        'mod_alumnos_table' => "ALTER TABLE `alumnos` 
        ADD `mail_token` VARCHAR(150) NULL DEFAULT NULL AFTER `CODIGOPOSTAL`, 
        ADD `verified` INT NOT NULL DEFAULT '0' AFTER `mail_token`, 
        ADD `password` VARCHAR(100) NULL AFTER `verified`;",

        'create_carrera_default_table' => "CREATE TABLE `movedb`.`carrera_default` (`id` INT NOT NULL AUTO_INCREMENT , `id_alumno` INT NOT NULL , `id_carrera` INT NOT NULL , PRIMARY KEY (`id`))"
    ]; 
    
}    

Migrator::exec(Migrations::$migrations);