<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Request
{
    const POST_FIELD_NAME   = 1;
    const POST_FIELD_PREFIX = 2;
    
    static public function post($name_or_prefix=NULL, $post_field_type=self::POST_FIELD_NAME)
    {
        $MY =& MY_Controller::get_instance();
        
        if( empty($name_or_prefix) )
        {
            $post = $MY->input->post();
            
            $arrData = array();
            if( !empty($post) )
            {
                foreach( $post as $field_name => $field_value )
                {
                    $arrData[ $field_name ] = is_array($field_value) ? $field_value : trim($field_value);
                }
            }
            
            return $arrData;
        }
        
        if( $post_field_type == self::POST_FIELD_NAME )
        {
            $res = $MY->input->post( $name_or_prefix );
            return is_array($res) ? $res : trim( $res );
        }

        $arrData = array();
        $post = $MY->input->post();
        if( !empty($post) )
        {
            foreach( $post as $field_name => $field_value )
            {
                $matches = NULL;
                if( preg_match("/^$name_or_prefix([^.]+$)/i", $field_name, $matches) )
                {
                    $arrData[ $matches[1] ] = is_array($field_value) ? $field_value : trim($field_value);
                }
            }
        }
        
        return $arrData;
    }
}