<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_Model extends MY_Model
{
    protected $table = 'permission';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $ePermission = new ePermission();
        $ePermission->parseRow($row);
        
        return $ePermission;
    }
            
    function save( ePermission &$ePermission )
    {
        try
        {
            $row = $this->load($ePermission->id);
            
            if( $row->isEmpty() )
            {
                
                $ePermission->id = $this->genId();
                $this->insert( $ePermission->toData() );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($ePermission->toData(FALSE), $ePermission->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    
    public function listByModule( $id_module )
    {
        $query = $this->db->get_where($this->table, array('id_module'=>$id_module));
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $rows = $query->result_array();

        $ePermissions = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $ePermission = new ePermission();
                $ePermission->parseRow($row);
                
                $ePermissions[] = $ePermission;
            }
        }
        
        return $ePermissions;
    }
    
    public function listByProfileAndModule($id_company_branch, $id_module, $id_profile)
    {
        $sql = '
            SELECT
                "permission".*
            FROM
                "user_profile__company_branch", "user_profile", "profile", "profile_permission", "permission" 
            WHERE 1=1
                AND "user_profile__company_branch"."id_user_profile" = "user_profile"."id"
                AND "user_profile"."id_profile" = "profile"."id"
                AND "profile_permission"."id_profile" = "profile"."id"
                AND "profile_permission"."id_permission" = "permission"."id"
                AND "user_profile__company_branch"."id_company_branch" = ?
                AND "permission"."id_module" = ?
                AND "profile"."id" = ?
        ';

        $query = $this->db->query($sql, array($id_company_branch, $id_module, $id_profile));
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();
        //Helper_Log::write($rows);

        $ePermissions = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $ePermission = new ePermission();
                $ePermission->parseRow($row);
                
                $ePermissions[] = $ePermission;
            }
        }

        return $ePermissions;
    }
    
    
    function filter(filterPermission $filter, &$ePermissions, &$count )
    {
        $ePermissions = array();
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
                $ePermission = new ePermission();
                $ePermission->parseRow($row);

                $ePermissions[] = $ePermission;
            }
        }
        
    }

    function filterQuery( filterPermission $filter, $useCounter=FALSE )
    {
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : "*" )."
            FROM \"".( $this->table )."\"
            WHERE 1=1
                AND (
                    UPPER(\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"name_key\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"description\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( $useCounter ? '' : " ORDER BY \"name\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";

        return $sql;
    }
    
}

class ePermission extends MY_Entity
{
    public $name;
    public $description;
    public $name_key;
    public $id_module;

    public function __construct( $useDefault = TRUE )
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->description = '';
            $this->name_key = '';
            $this->id_module = 0;
        }
    }
}

class filterPermission extends MY_Entity_Filter
{
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
}