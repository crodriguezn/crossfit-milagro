<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_Permission_Model extends MY_Model
{
    protected $table = 'profile_permission';

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
    
    function save(eProfilePermission &$eProfilePermission)
    {
        try
        {
            if( $eProfilePermission->isEmpty() )
            {
                $eProfilePermission->id = $this->genId();
                $this->insert($eProfilePermission->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eProfilePermission->toData(FALSE), $eProfilePermission->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    //function loadAllByCompany($id_company, $txt_filter='', $limit=NULL, $offset=NULL, $withSuperAdmin=FALSE, $withAdmin=FALSE, $isEditable=NULL/* 0||1 */, $isActive=NULL/* 0||1 */)
    function filter( eProfilePermission $filter, &$eRols, &$count )
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

    function filterQuery( eProfilePermission $filter, $useCounter=FALSE )
    {
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : "*" )."
            FROM \"".( $this->table )."\"
            WHERE 1=1
                AND (
                    UPPER(\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( is_null($filter->isActive) ? '':" AND \"isActive\"='". ( $filter->isActive ) ."'" ) . "
            AND \"isEditable\"='1'
            " . ( $useCounter ? '' : " ORDER BY \"name\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";

        return $sql;
    }
    
    function deleteByProfile( $id_profile )
    {
        if( $this->db->delete($this->table, array('id_profile'=>$id_profile)) === FALSE )
        {
            throw new Exception("Error in: TABLE:".$this->table.", FUNCTION:".__FUNCTION__);
        }
        Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_DELETE );
    }
    
    
    public function listByProfile( $id_profile )
    {
        $query = $this->db->get_where($this->table, array('id_profile'=>$id_profile));

        $result_array = $query->result_array();

        return $result_array;
    }
    
}

class eProfilePermission extends MY_Entity
{
    public $id_profile;
    public $id_permission;


    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_profile = 0;
            $this->id_permission = 0;
        }
    }
}

class filterProfilePermission extends MY_Entity_Filter
{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
}