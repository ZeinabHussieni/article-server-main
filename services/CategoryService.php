<?php 

class CategoryService {

    public static function categoryToArray($articles_db){
        $results = [];

        foreach($articles_db as $a){
             $results[] = $a->toArray();  
        } 

        return $results;
    }



}