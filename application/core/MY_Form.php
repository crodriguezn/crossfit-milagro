<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form
{
    const ARRAY_FULL = 0;
    const ARRAY_ONLY_FIELDS = 1;
    const ARRAY_ONLY_ERRORS = 2;
    
    public $errors;
    public $id_form;
    public function __construct()
    {
        $this->errors   = array();
        $this->id_form  = Helper_Encrypt::encode(0);
    }
    
    public function setIdForm( $value )
    {
        $this->id_form = Helper_Encrypt::encode($value);
    }
    
    public function getIdForm()
    {
        $MY =& MY_Controller::get_instance();
        return Helper_Encrypt::decode($MY->input->post('id_form'));
    }
    
    public function addError( $field, $message )
    {
        $this->errors[$field] = $message;
    }
    
//    public function encode( $value, $isDecode=FALSE )
//    {
//        if( $isDecode )
//        {
//            $v = Helper_Encrypt::decode( $value );
//            if( $v === FALSE )
//            {
//                return FALSE;
//            }
//            
//            $v = json_decode($v, TRUE);
//            
//            return $v['*secure*'];
//        }
//        else
//        {
//            return Helper_Encrypt::encode( json_encode(array('*secure*'=>$value)) );
//        }
//    }
    
    public function clearErrors()
    {
        $this->errors = array();
    }
    
    public function isErrorEmpty()
    {
        return empty($this->errors);
    }
    
    
//    public function toArray( $ARRAY_TYPE = self::ARRAY_FULL, $fields_except=array() )
//    {
//        $arr = get_class_vars( get_class($this) );
//        
//        $fields = array();
//        foreach( $arr as $attr => $value )
//        {
//            if( !in_array($attr, $fields_except) )
//            {
//                if( strpos($attr, 'password') !== FALSE || strpos($attr, 'contrasenia') !== FALSE )
//                {
//                    $fields[ $attr ] = '';
//                }
//                else if( $attr != 'errors' )
//                {
//                    $fields[ $attr ] = $this->$attr;
//                }
//            }
//        }
//        
//        $arr = array('fields'=>$fields, 'errors'=>$this->errors);
//        if( $ARRAY_TYPE == self::ARRAY_ONLY_FIELDS ){ unset($arr['errors']); }
//        if( $ARRAY_TYPE == self::ARRAY_ONLY_ERRORS ){ unset($arr['fields']); }
//        
//        return $arr;
//    }
//    public function toArray()
//    {
//        return (array) $this;
//    }
    public function toArray()
    {
        $arr = get_class_vars( get_class($this) );
        
        $fields = array();
        foreach( $arr as $attr => $value )
        {
            $fields_except[] = 'errors';
            if( !in_array($attr, $fields_except) )
            {
                $field = array();
                $field[ $attr ] = array();

                if( is_array($this->$attr) )
                {
                    if( empty($this->$attr) )
                    {
                        $fields[ $attr ] = [];
                    }
                    else
                    {
                        $attrT = $this->$attr;

                        if( is_subclass_of( $attrT[0], 'MY_Form') )
                        {
                            foreach( $this->$attr as $frm )
                            {
                                $fields[ $attr ][] = $frm->toArray();
                            }
                        }
                        else
                        {
                            $fields[ $attr ]['value'] = $this->$attr;
                            $fields[ $attr ]['error'] = isset($this->errors[$attr]) && !empty($this->errors[$attr]) ? $this->errors[$attr] : [];
                        }
                    }
                }
                else
                {
                    if( strpos($attr, 'password') !== FALSE || strpos($attr, 'contrasenia') !== FALSE )
                    {
                        $fields[ $attr ]['value'] = '';
                        //$fields[ $attr ]['error'] = '';
                        $fields[ $attr ]['error'] = isset($this->errors[$attr]) ? $this->errors[$attr] : '';
                    }
                    else
                    {
                        $fields[ $attr ]['value'] = $this->$attr;
                        $fields[ $attr ]['error'] = isset($this->errors[$attr]) ? $this->errors[$attr] : '';
                    }
                }
            }
        }
        
        return $fields;
    }
}
