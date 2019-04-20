<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Input;

class Utility {

  public static function stripXSS($except)
  {
    
    if(!empty($except)){
     $data    =  Input::except($except);


    }else{

       $data  =   Input::get();

     }

   
    $sanitized = static::cleanArray($data);
    
    Input::merge($sanitized);
  }

  public static function cleanArray($array)
  {
    $result = array();
    foreach ($array as $key => $value) {
        $key = strip_tags($key);
        if (is_array($value)) {
            $result[$key] = static::cleanArray($value);
        } else {

            $options= config('global.html_entity_decode_option');
            
            if ($options['remove']) {
               $value = trim(strip_tags($value));
            }


            $result[$key] =  htmlentities(trim($value), $options['quotes'], $options['charset'], $options['double']);// Remove trim() if you want to.
            //echo $result[$key]."<br>";

        }
    }
    return $result;
  }
}