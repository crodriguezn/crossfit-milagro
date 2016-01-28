<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Provincia_Model extends MY_Model
{
    protected $table = 'provincia';

    function __construct()
    {
        parent::__construct();
    }
    
    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row =  parent::load($value, $by, $except_value, $except_by);
        
        $eProvincia = new eProvincia();
        $eProvincia->parseRow($row);
        
        return $eProvincia;
    }
    
    function save( eProvincia &$eProvincia )
    {
        try
        {
            if( empty($eProvincia->id) )
            {
                $eProvincia->id = $this->genId();
                $this->insert( $eProvincia->toData() );
            }
            else
            {
                $this->update( $eProvincia->toData(FALSE), $eProvincia->id );
            }
        }
        catch( Exception $e )
        {
            //Helper_Log::write( $e->getMessage() );
            throw new Exception( $e->getMessage() );
        }
    }
    
    function listAll($txt_filter='', $limit=null, $offset=null)
    {
        $query = $this->db->query( $this->queryAll($txt_filter, $limit, $offset) );

        $result_array = $query->result_array();

        return $result_array;
    }
    
    function countAll($txt_filter='')
    {
        $query = $this->db->query( $this->queryAll($txt_filter, null, null) );

        return $query->num_rows();
    }
    
    function queryAll($txt_filter='', $limit=null, $offset=null )
    {
        $sql = "
            SELECT *
            FROM ".( $this->table )."
            WHERE 1=1
                AND (
                    nombre LIKE '%".( $this->db->escape_like_str($txt_filter) )."%'
                )
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }
    
    function listProvinciaxPais($id_pais)
    {
        $sql = "
            SELECT *
            FROM ".( $this->table )."
            WHERE id_pais=".  $this->db->escape($id_pais)  
        ;
        
        $query = $this->db->query( $sql );

        $rows = $query->result_array();

        $eProvincias = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eProvincia = new eProvincia();
                $eProvincia->parseRow($row);
                
                $eProvincias[] = $eProvincia;
            }
        }
            
        return $eProvincias;
        
    }
}

class eProvincia extends MY_Entity
{
    public $id_pais;
    public $nombre;
    public $Code;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_pais = NULL;
            $this->nombre = '';
            $this->Code = '';
        }
    }
}