<?php

class ArrayFlatter{
    static function flat (array $items, array $flattened = []){
        foreach ($items as $item){
            if (is_array ($item)){
                $flattened = ArrayFlatter::flat ($item, $flattened);
                continue;
            }
            $flattened[] = $item;
        }
        return $flattened;
    }
}