<?php

class Collection{
    static function create($arr){
        foreach($arr as $key=>$value){
            $arr[$key] = Collection::toObject($arr[$key]);
        }
        return $arr;
    }

    static function toObject($arr){
        $obj = new stdClass();
        foreach($arr as $key => $value){
            $obj -> {strtolower($key)} = $value;
        }
        return $obj;
    }
}