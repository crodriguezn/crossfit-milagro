<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Response_Entity extends MY_Response
{
    protected $entities;
    protected $count;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->entities = array();
        $this->count = 0;
    }
    
    public function entity( $name_key, $eEntity=NULL )
    {
        if( empty($eEntity) )
        {
            return isset($this->entities[$name_key]) ? $this->entities[$name_key] : array();
        }
        
        $this->entities[$name_key] = $eEntity;
    }
    
    public function count( $count = NULL )
    {
        if( !is_null($count) )
        {
            return $this->count;
        }
            
        $this->count = $count;
    }
}

