<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Model
{
    static public function readPostData($dbtable, $prefix='', $post=array() )
    {
        $MY =& MY_Controller::get_instance();
        
        $arrData = array();
        
        $arrField = $MY->db->list_fields( $dbtable );
        
        foreach( $arrField as $field )
        {
            $data = FALSE;
            if( empty($post) )
            {
                $data = $MY->input->post( $prefix . $field );
            }
            else
            {
                if( isset( $post[ $prefix . $field ] ) )
                {
                    $data = $post[ $prefix . $field ];
                }
            }
            
            if( $data !== FALSE )
            {
                $arrData[ $field ] = $data;
            }
        }
        
        return $arrData;
    }
    
    static public function readPostArray($dbtable, $field_name, $prefix='')
    {
        $MY =& MY_Controller::get_instance();
        
        $arrData = array();
        
        $arrPost = $MY->input->post($field_name);
        
        if( !empty($arrPost) )
        {
            foreach( $arrPost as $post )
            {
                $arrData[] = self::readPostData($dbtable, $prefix, $post);
            }
        }
        
        return $arrData;
    }

    // ========================================================================
    // ========================================================================
    
    static public function encryptIdFromResultArray( &$arrData )
    {
        if( !empty($arrData) )
        {
            foreach( $arrData as $index => $data )
            {
                self::encryptIdFromRowArray($data);

                $arrData[$index] = $data;
            }
        }
    }
    
    static public function encryptIdFromRowArray( &$data )
    {
        if( !empty($data) )
        {
            foreach( $data as $field_name => $field_value )
            {
                if( self::isFieldNamedId($field_name) )
                {
                    self::encryptIdValue($field_value);

                    $data[$field_name] = $field_value;
                }
            }
        }
    }
    
    static public function encryptIdValue( &$value_id )
    {
        if( ENVIRONMENT == 'development' )
        {
            return;
        }
        
        $encryption_key = Helper_App_Session::getEncryptionKey();
        
        $value_id = Helper_Encrypt::encryptId($value_id, $encryption_key);
    }
    
    // ===============================================================================================
    // ===============================================================================================

    static public function decryptIdFromResultArray( &$arrData )
    {
        if( !empty($arrData) )
        {
            foreach( $arrData as $index => $data )
            {
                self::decryptIdFromRowArray($data);

                $arrData[$index] = $data;
            }
        }
    }
    
    static public function decryptIdFromRowArray( &$data )
    {
        if( !empty($data) )
        {
            foreach( $data as $field_name => $field_value )
            {
                if( self::isFieldNamedId($field_name) )
                {
                    self::decryptIdValue($field_value);

                    $data[$field_name] = $field_value;
                }
            }
        }
    }
    
    static public function decryptIdValue( &$value_id )
    {
        if( ENVIRONMENT == 'development' ) { return; }
        
        if( empty($value_id) ) { return; }
        
        $encryption_key = Helper_App_Session::getEncryptionKey();
        
        $value_id = Helper_Encrypt::decryptId($value_id, $encryption_key);
        
        if( !is_numeric($value_id) ) // checks if it "id"
        {
            exit('Violacion de seguridad');
        }
    }
    
    /*
     * id, id_, id_XXX -> TRUE
     * _id, sdf_id_p ->  FALSE
     */
    
    static public function isFieldNamedId( $field_name )
    {
        $res = preg_match("/^id[^.]*/", $field_name);
        return !empty($res);
    }
}