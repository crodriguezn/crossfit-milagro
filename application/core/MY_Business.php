<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Business extends MY_Model
{
    
    const DB_DEFAULT = 10;
    const DB_DIGIFORT = 11;
    
    function __construct( $DB_TYPE=self::DB_DEFAULT )
    {
        $conn_type = NULL;
        
        switch( $DB_TYPE )
        {
            case self::DB_DEFAULT:
                $conn_type = self::CONN_DEF;
                break;
            case self::DB_DIGIFORT:
                $conn_type = self::CONN_DBD;
                break;
        }
        
        parent::__construct($conn_type);
    }
    

    function begin() 
    {
        return parent::begin();
    }
    
    function commit() 
    {
        return parent::commit();
    }
    
    function rollback()
    {
        return parent::rollback();
    }
}