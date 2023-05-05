<?php

class ArrayFlatter{
    static function flat ($items, array $flattened = []){
        foreach ($items as $item){
            if ($item instanceof stdClass){
                $flattened = ArrayFlatter::flat($item, $flattened);
                continue;
            }
            $flattened[] = $item;
        }
        return $flattened;
    }
}