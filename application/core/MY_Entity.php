<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Entity
{
    public $id;
    public $created;
    public $modified;
    
    public function __construct( $useDefault = TRUE )
    {
        if( !$useDefault )
        {
            $arr = get_class_vars( get_class($this) );
            foreach( $arr as $attr => $value )
            {
                $this->$attr = FALSE;
            }
            $this->created  = date('Y-m-d H:m:i');
            $this->modified = date('Y-m-d H:m:i');
            return;
        }
        
        $this->created  = date('Y-m-d H:m:i');
        $this->modified = date('Y-m-d H:m:i');
        $this->id = NULL;
    }
    
    public function genId()
    {
        return uniqid();
    }
    
    public function isEmpty()
    {
        return isset($this->id) ? empty($this->id) : TRUE;
    }
    
    public function toData( $withPK=TRUE )
    {
        $arr = get_class_vars( get_class($this) );
        
        $data = array();
        foreach( $arr as $attr => $value )
        {
            if( !( $this->$attr === FALSE && $attr != 'id' ) )
            {
                $data[ $attr ] = $this->$attr;
            }
        }
        
        if( !$withPK )
        {
            unset( $data['id'] );
        }
        
        return $data;
    }
    
    public function parseRow( $row, $prefix='', $isFieldToLower = FALSE )
    {
        if( !empty($row) )
        {
            foreach( $row as $field => $value )
            {
                if($isFieldToLower)
                {
                    $field = strtolower($field);
                }

                $field = preg_replace("/^$prefix/", "", $field);
                
                if( property_exists($this, $field) )
                {
                    $this->$field = $value;
                }
            }
        }
    }
}

class MY_Entity_Filter
{
    public $text;
    public $limit;
    public $offset;
    
    public function __construct()
    {
        $this->text = '';
        $this->limit = NULL;
        $this->offset = NULL;
    }
}