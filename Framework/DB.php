<?php

namespace Framework;

use PDO;
use Framework\Item;


class DB{
    // PDO instance
    static $pdo;
    
    // Config is got from config file
    static $dbdriver = DB_DRIVER;
    static $username = DB_USERNAME;
    static $password = DB_PASSWORD;
    static $host = DB_HOST;
    static $dbname = DB_DBNAME;
    static $connString = null;

    static $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    // Connect to database, It is done automatically when executing a query
    
    static function connect(){
      $host = DB::$host;
      $dbname = DB::$dbname;
      $dbdriver = DB::$dbdriver;

      if(!self::$connString){
        self::$connString = "$dbdriver:host=$host;dbname=$dbname";
      }

      DB::$pdo = new PDO(self::$connString, DB::$username, DB::$password, DB::$options);
    }

     // Close the connection to database
     // It is done automatically after query has been executed
    static function disconnect() {
      DB::$pdo = null;
    }

    // query but only getting first element instead of an array of elements
    // returns -> object 
    static function queryFirst($sql, $params = null){
      $query = DB::query("$sql LIMIT 1",$params);
      
      if(count($query) < 1){
        return false;
      }else return $query[0];
    }

    // query getting all element
    // returns -> [object, object, object]
    static function query($sql, $params = null) {
      DB::connect();    

      $stmt = DB::$pdo->prepare($sql);
      $stmt->execute($params);

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $result = Item::createCollection($result);

      DB::disconnect();

      return $result;
    }

}
  
?>