<?php

namespace Framework\Database;

class DataList{

    public $data;
    
    public function __construct($data) {
        $this->data = $data;
    }

    static function relation_many($coll1,$coll2,$fk,$rel)
    {
        foreach($coll1 as $index=>$item){
          $coll1[$index][$rel] = [];
          foreach($coll2 as $item2){
            if($item2[$fk] == $item['id']){
                
              $coll1[$index][$rel][] = $item2;
            }
          }
        }
        return $coll1;
      }
    
    static function relation_one($coll1,$coll2,$fk,$rel)
    {
        foreach($coll1 as $index=>$item){
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
