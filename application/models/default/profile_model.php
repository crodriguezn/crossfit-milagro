<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_Model extends MY_Model
{
    protected $table = 'profile';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eProfile = new eProfile();
        $eProfile->parseRow($row);
        
        return $eProfile;
    }
    
    function save(eProfile &$eProfile)
    {
        try
        {
            if( empty($eProfile->id) )
            {
                $eProfile->id = $this->genId();
                $this->insert($eProfile->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eProfile->toData(FALSE), $eProfile->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    //function loadAllByCompany($id_company, $txt_filter='', $limit=NULL, $offset=NULL, $withSuperAdmin=FALSE, $withAdmin=FALSE, $isEditable=NULL/* 0||1 */, $isActive=NULL/* 0||1 */)
    function filter( filterProfile $filter, &$eProfiles, &$eRols=NULL, &$count=NULL )
    {
        $eProfiles = array();
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
                $eProfile = new eProfile();
                $eRol = new eRol();
                
                $eProfile->parseRow($row, 'p_');
                $eRol->parseRow($row, 'r_');
                
                $eProfiles[] = $eProfile;
                $eRols[] = $eRol;
            }
        }        
        
    }

    function filterQuery( filterProfile $filter, $useCounter=FALSE )
    {
        
        $select_profile = $this->buildSelectFields('p_', 'p', 'profile');
        $select_rol = $this->buildSelectFields('r_', 'r', 'rol');
        
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select_profile.','.$select_rol )."
            FROM \"".( $this->table )."\" AS \"p\"
                INNER JOIN \"rol\" AS \"r\" ON \"r\".\"id\" = \"p\".\"id_rol\" 
            WHERE 1=1
                " . ( $filter->withSuperAdmin ? '' : " AND \"p\".\"isSuperAdmin\"<>" . ( $this->db->escape(1) ) . " " ) . "
                " . ( $filter->withAdmin ? '' : " AND \"p\".\"isAdmin\"<>" . ( $this->db->escape(1) ) . " " ) . "
                " . ( is_null($filter->isEditable) ? '' : " AND \"p\".\"isEditable\"=" . ( $this->db->escape($filter->isEditable) ) . " " ) . "
                " . ( is_null($filter->isActive) ? '' : " AND \"p\".\"isActive\"=" . ( $this->db->escape($filter->isActive) ) . " " ) . "
                AND 
                (
                    UPPER(\"p\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"r\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( $useCounter ? '' : " ORDER BY \"p\".\"name\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        return $sql;
    }
    
    
}

class eProfile extends MY_Entity
{
    public $name;
    public $description;
    public $isAdmin;
    public $isSuperAdmin;
    public $isActive;
    public $isEditable;
    public $id_rol;


    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->description = NULL;
            $this->isAdmin = 0;
            $this->isSuperAdmin = 0;
            $this->isActive = 1;
            $this->isEditable = 1;
            $this->id_rol = 0;
        }
    }
}

class filterProfile extends MY_Entity_Filter
{
    
    public $withSuperAdmin;
    public $withAdmin;
    public $isEditable;
    public $isActive;
    

    public function __construct()
    {
        parent::__construct();
        
        $this->withSuperAdmin = FALSE;
        $this->withAdmin = FALSE;
        $this->isEditable = NULL;
        $this->isActive = NULL;
    }
    
}