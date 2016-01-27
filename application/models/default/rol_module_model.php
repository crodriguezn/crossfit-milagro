<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol_Module_Model extends MY_Model
{
    protected $table = 'rol_module';
    
    function __construct()
    {
        parent::__construct();
    }
    
    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eRolModule = new eRolModule();
        $eRolModule->parseRow($row);
        
        return $eRolModule;
    }
    
    function save( eRolModule &$eRolModule )
    {
        try
        {
            if( $eRolModule->isEmpty() )
            {
                $eRolModule->id = $this->genId();
                $this->insert( $eRolModule->toData() );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update( $eRolModule->toData(FALSE), $eRolModule->id );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
   
    
    public function deleteByRol( $id_rol )
    {
        if( $this->db->delete($this->table, array('id_rol'=>$id_rol)) === FALSE )
        {
            throw new Exception("Error in: TABLE:".$this->table.", FUNCTION:".__FUNCTION__);
        }
        Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_DELETE );
    }
    
    public function listRolesAndModulesByRol( $id_rol )
    {
        $sql = '
                SELECT
                    "rm".*
                FROM
                    '.$this->table.' AS rm
                    INNER JOIN "module" AS "m" ON "rm"."id_module" = "m"."id"
                    INNER JOIN "rol" AS "r" ON "rm"."id_rol" = "r"."id"
                WHERE
                    1=1
                    AND "r"."id" = ?
        ';
        
        $query = $this->db->query($sql, array($id_rol));
        //$query = $this->db->get_where($this->table, array('id_module'=>$id_module));

        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $rows = $query->result_array();

        $eRolesModules = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eRolModule = new eRolModule();
                $eRolModule->parseRow($row);
                
                $eRolesModules[] = $eRolModule;
            }
        }
        
        return $eRolesModules;
    }


    function listModulesByRol( $id_rol, $id_parent = NULL )
    {
        $select_module = $this->buildSelectFields('m_', 'm', 'module');
        $sql = "
            SELECT 
                ".( $select_module )."
            FROM \"".( $this->table )."\" AS \"rm\"
                INNER JOIN \"rol\" AS \"r\" ON \"r\".\"id\" = \"rm\".\"id_rol\" 
                INNER JOIN \"module\" AS \"m\" ON \"m\".\"id\" = \"rm\".\"id_module\" 
            WHERE 1=1
                AND \"r\".\"id\" =  ?
                ".(is_null($id_parent) ? " AND \"m\".\"id_parent\" IS NULL ":" AND \"m\".id_parent = ".$id_parent )."
            ORDER BY \"m\".\"num_order\" ASC
        ";
        //Helper_Log::write($sql);
        $query = $this->db->query($sql, array($id_rol));
        
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();

        $eModules = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eModule = new eModule();
                $eModule->parseRow($row, 'm_');
                
                $eModules[] = $eModule;
            }
        }
        
        return $eModules;
    }

    /*public function listByModule( $id_module )
    {
        
        $sql = '
                SELECT
                    "p".*
                FROM
                    '.$this->table.' AS mpr
                    INNER JOIN "module" AS "m" ON mpr.id_module = "m"."id"
                    INNER JOIN "permission" AS "p" ON "p"."id" = mpr.id_permission
                    INNER JOIN rol AS r ON r."id" = mpr.id_rol
                WHERE
                    1=1
                    AND "m"."id" = ?
        ';
        
        $query = $this->db->query($sql, array($id_module));
        //$query = $this->db->get_where($this->table, array('id_module'=>$id_module));
        
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
    }*/

    /*public function listByRolAndModule($id_module, $id_rol)
    {
        $sql = '
                SELECT
                    "p".*
                FROM
                    '.$this->table.' AS mpr
                    INNER JOIN "module" AS "m" ON mpr.id_module = "m"."id"
                    INNER JOIN "permission" AS "p" ON "p"."id" = mpr.id_permission
                    INNER JOIN rol AS r ON r."id" = mpr.id_rol
                WHERE
                    1=1
                    AND "m"."id" = ?
                    AND r."id" = ?
        ';

        $query = $this->db->query($sql, array($id_module, $id_rol));
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
    }*/
    
}

class eRolModule extends MY_Entity
{
    public $id_module;
    public $id_rol;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_module = 0;
            $this->id_rol = 0;
        }
    }
}