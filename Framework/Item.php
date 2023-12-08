<?php

namespace Framework;

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

}