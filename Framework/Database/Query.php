<?php

namespace Framework\Database;




class Query{


  public $queryStr="";
  public $args;

  static function query(){
    return new Query();
  }

  static function in($list){
    return '('.implode(',',$list).')';
  }
  
  function select(){
    $this->queryStr = $this->queryStr."SELECT ";
    return $this;
  }
  
  function selectAll(){
    $this->queryStr  = $this->queryStr. "SELECT *";
    return $this;
  }

  function fields($fields, $prefix=null){
    if($prefix){
      $this->queryStr = $this->queryStr.$fields[0].' as '.$prefix.'_'.$fields[0];
    }else{
      $this->queryStr = $this->queryStr.$fields[0];
    }
          
    for($i=1; $i<count($fields);$i++){
      if($prefix){
        $this->queryStr = $this->queryStr.', '.$fields[$i].' as '.$prefix.'_'.$fields[$i];
      }else{
        $this->queryStr = $this->queryStr.', '.$fields[$i];
      }
    }
    return $this;
  }

  function andFields($fields, $prefix){
    for($i=0; $i<count($fields);$i++){
      if($prefix){
        $this->queryStr  = $this->queryStr. ', '.$fields[$i].' as '.$prefix.'_'.$fields[$i];
      }else{
        $this->queryStr = $this->queryStr. ', '.$fields[$i];
      }
    }
    return $this;
  }
  
  function from($tables){
    $this->queryStr = $this->queryStr." FROM ". $tables;
    return $this;
  }
  
  function join($table,$rel1,$rel2){
    $this->queryStr = $this->queryStr." JOIN ".$table.' ON '.$rel1.' = '.$rel2;
    return $this;
  }
  
  function where($cond){
    $this->queryStr = $this->queryStr. " WHERE $cond ";
    return $this;
  }
  
  function andWhere($cond){
    $this->queryStr = $this->queryStr. " AND $cond ";
    return $this;
  }
  
  function orWhere($cond){
    $this->queryStr = $this->queryStr. " OR $cond ";
    return $this;
  }
  
  function openPars($fn){
    $this->queryStr = $this->queryStr."(";
    return $this;
  }
  
  function closePars($fn){
    $this->queryStr = $this->queryStr.")";
    return $this;
  }

  function args($array){
    $this->args = $array;
    return $this;
  }

  function exec(){
    return DB::query($this->queryStr,$this->args);
  }
  
//   function with($fields, $table, $prefix){
//     $this->andFiels($fields,$prefix);
//     $this->join($table, 
//   }
    
  
} 


// User::query()
//   -> select()
//   -> fields(['username', 'email'])
//   -> andFiels(Post::fiels(), 'post')
//   -> from('users')
//   -> join('posts', 'users.id','posts.id_user')
//   -> where('users.username = :name)
//   -> args(['name'=>$username])
  
  
// User::query()
//   -> select(User::fields)
//   -> with(Post::fields,'post')
  
  
  
// class User{

//   static $fields = []
  
//   static $relations = [
//     "posts"=> [Post::class, 'id_
//   ]

// }

// User::query
//   -> all()
//   -> where(...)
//   -> args(...)
//   -> get()
  

