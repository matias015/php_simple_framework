<?php

include_once('DB.php');

class Migrator{

    static $registered = [];

    static function getMigrationsData(){
        $exists = DB::query("SHOW TABLES LIKE 'migrations'",[]);
        
        if(empty($exists)){
            DB::query("CREATE TABLE migrations (
                id INT NOT NULL AUTO_INCREMENT, 
                name VARCHAR(255) NOT NULL , 
                PRIMARY KEY (id)
                ) 
                ",[]);
        }
        
        return DB::query("SELECT * FROM migrations",[]);
    }        

    
    static function exec($registered){
        
        $migrationsData = Migrator::getMigrationsData();

        foreach($registered as $name => $sql){
            $exists = false;

            foreach($migrationsData as $migration){
                if($migration['name'] === $name) $exists=true;
            }
            
            if(!$exists){
                DB::query($sql,[]);
                Migrator::registerMigrated($name);
            }
            
        }

    }

    static function registerMigrated($name){
        DB::query("INSERT INTO migrations VALUES(NULL, ?)",[$name]);
    }


}