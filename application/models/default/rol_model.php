<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol_Model extends MY_Model
{
    protected $table = 'rol';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eRol = new eRol();
        $eRol->parseRow($row);
        
        return $eRol;
    }
    
    function save(eRol &$eRol)
    {
        try
        {
            if( empty($eRol->id) )
            {
                $eRol->id = $this->genId();
                $this->insert($eRol->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eRol->toData(FALSE), $eRol->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    //function loadAllByCompany($id_company, $txt_filter='', $limit=NULL, $offset=NULL, $withSuperAdmin=FALSE, $withAdmin=FALSE, $isEditable=NULL/* 0||1 */, $isActive=NULL/* 0||1 */)
    function filter( filterRol $filter, &$eRols, &$count )
    {
        $eRols = array();
        $count = 0;
        
        $queryR = $this->db->query($this->filterQuery($filter));
        if( $queryR === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $queryC = $this->db->query($this->filterQuery($filter,TRUE));
        if( $queryC === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $row = $queryC->row_array();
        $count = $row['count'];
        
        $rows = $queryR->result_array();
        
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eRol = new eRol();
                $eRol->parseRow($row);

                $eRols[] = $eRol;
                
            }
        }
        
    }

    function filterQuery( filterRol $filter, $useCounter=FALSE )
    {
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : "*" )."
            FROM \"".( $this->table )."\"
            WHERE 1=1
                AND (
                    UPPER(\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"name_key\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . (is_null($filter->isEditable) ? '' : " AND \"isEditable\" = ".($filter->isEditable)."" ) . "
            " . ( $useCounter ? '' : " ORDER BY \"name\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        return $sql;
    }
    
    
}

class eRol extends MY_Entity
{
    public $name;
    public $name_key;
    public $isEditable;


    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->name_key = '';
            $this->isEditable = 1;
        }
    }
}

class filterRol extends MY_Entity_Filter
{
    public $isEditable;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->isEditable = NULL;
    }
    
}