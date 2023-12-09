<?php

namespace Framework\Database;

/**
 * An Item is an object that contains a register in a database query result
 * 
 * DB class always returns a list of items
 */

class Item{

    public $data;
    
    public function __construct($data) {
        $this->data = $data;
    }

    public function __get($key) {
        return $this->data[$key] ?? null;
    }
    
    static function createCollection($items){
        $itemsList = [];
        foreach($items as $item){
            $itemsList[] = new Item($item);
        }
        return $itemsList;
    }

    static function unifyMany($coll1,$coll2,$fk,$rel){
        foreach($coll1 as $index=>$item){
          $coll1[$index][$rel] = [];
          //buscar en coll2 el fk==pk actual
          foreach($coll2 as $item2){
            if($item2[$fk] == $item['id']){
                
              $coll1[$index][$rel][] = $item2;
            }
          }
        }
        return $coll1;
      }
      static function unifyOne($coll1,$coll2,$fk,$rel){
        foreach($coll1 as $index=>$item){
          //buscar en coll2 el fk==pk actual
          foreach($coll2 as $item2){
            if($item2[$fk] == $item['id']){
              $coll1[$index][$rel] = $item2;
              break;
            }
          }
        }
        return $coll1;
      }
}