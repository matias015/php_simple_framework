<?php

require_once('App/config/config.php');

class DB{
    static $pdo;
    static $lastQuery;
    static $lastResult;
    static $username = DB_USERNAME;
    static $password = DB_PASSWORD;
    static $host = DB_HOST;
    static $dbname = DB_DBNAME;
    static $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
  
    // public function pdo_instance(){
    //   return $this -> pdo;
    // }

    static function connect(){
        $host = DB::$host;
        $dbname = DB::$dbname;
        DB::$pdo = new PDO("mysql:host=$host;dbname=$dbname", DB::$username, DB::$password, DB::$options);
    }
  
    static function disconnect() {
      DB::$pdo = null;
    }

    static function queryFirst($sql, $params = null, $save=false){
      $query = DB::query($sql,$params,$save);
      
      if(count($query) < 1){
        return false;
      }else return $query[0];
    }


    static function query($sql, $params = null, $save=false) {
      DB::connect();    

      $stmt = DB::$pdo->prepare($sql);
      $stmt->execute($params);

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if($save) {
        DB::$lastResult = $result;
        DB::$lastQuery = $stmt->queryString;
      }

      DB::disconnect();

      return $result;
    }
  
    static function lastSet() {
      return DB::$lastResult;
    }
  
    static function lastQuery() {
      return DB::$lastQuery;
    }

    static function forEachRow($callback, $result = null) {
      if ($result === null) {
        $result = DB::$lastResult;
      }
  
      if (!empty($result)) {
        foreach ($result as $row) {
            $callback($row); 
        }
    }
  }


}
  
?>