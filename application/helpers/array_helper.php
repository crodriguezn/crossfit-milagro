<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Array
{
    static public function entitiesToIdText( $entities, $field_name_id, $field_name_text, $idx_id='id', $idx_text='text', $value_id_selected=NULL )
    {
        $arr = array();
        
        if( !empty($entities) )
        {
            foreach( $entities as $entity )
            {
                $idx_idT   = $entity->$field_name_id;
                $idx_textT = $entity->$field_name_text;
                
                $arr[] = array($idx_id=>$idx_idT, $idx_text=>$idx_textT, 'selected'=> $idx_idT == $value_id_selected );
            }
        }
        
        return $arr;
    }
    
    static public function toIdText( $array_array, $field_name_id, $field_name_text, $idx_id='id', $idx_text='text' )
    {
        $arr = array();
        
        if( !empty($array_array) )
        {
            foreach( $array_array as $array )
            {
                $arr[] = array($idx_id=>$array[$field_name_id], $idx_text=>$array[$field_name_text]);
            }
        }
        
        return $arr;
    }
    
    static public function unsetText( $array_array, $unset = 'index.html' )
    {
        
        if( !empty($array_array) && is_array($array_array) )
        {
            $key = array_search($unset, $array_array);
            unset($array_array[$key]);
        }
        
        return $array_array;
    }
}