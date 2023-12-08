<?php

/**
 * Database cache
 */

class Cache{

    static function get($key,$cb=null){
        DB::connect(); 
        $pdo = DB::$pdo;
        
        $stmt = $pdo->prepare('SELECT value 
            FROM cache 
            WHERE cache.key = ? 
            AND expiration_time > NOW()
            LIMIT 1');
        $stmt->execute([$key]);
  
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        DB::disconnect();

        if(!$result) {
              
            if(!$cb) return null;
            $data = $cb();
            DB::connect(); 
            $stmt = $pdo->prepare('INSERT INTO cache 
                VALUES(NULL,:key,:data,:date)
                ON DUPLICATE KEY UPDATE value = :data, expiration_time = :date '
            );

            $stmt->execute([
                'key'=>$key,
                'data'=>serialize($data),
                'date' => date('Y-m-d H:i:s', strtotime('+10 minutes', time()))
            ]);
            DB::disconnect();   
            return $data;
        }

        

        return unserialize($result[0]['value']);
    }

    static function set($key,$value){
        DB::query('INSERT INTO cache 
        VALUES(NULL,:key,:data,:date)
        ON DUPLICATE KEY UPDATE value = :data
        ',['key'=>$key,'data'=>serialize($value),'date' => date('Y-m-d H:i:s', strtotime('+10 minutes', time()))]);
    }
    
    static function setForLogged($key, $value){
        $finalkey = Auth::getGuard() .'.'. Auth::id() .'.'. $key;
        Cache::set($finalkey,$value);
    }

    static function getForLogged($key,$cb=null){
        $finalkey = Auth::getGuard() .'.'. Auth::id() .'.'. $key;
        return Cache::get($finalkey,$cb);
    }

}