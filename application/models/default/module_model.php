<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_Model extends MY_Model
{
    protected $table = 'module';
    
    const ORDER_BY_NAME  = 0;
    const ORDER_BY_ORDER = 1;

    function __construct()
    {
        parent::__construct();
    }
    
    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eModule = new eModule();
        $eModule->parseRow($row);
        
        return $eModule;
    }
    
    function save( eModule &$eModule )
    {
        try
        {
            if( $eModule->isEmpty() )
            {
                $eModule->id = $this->genId();
                $this->insert( $eModule->toData() );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update( $eModule->toData(FALSE), $eModule->id );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    function saveOrder( eModule $eModule )
    {
        try
        {
            $this->update(array('num_order'=>$eModule->num_order), $eModule->id );
            Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    function listAll( $withIsAdmin = FALSE, $isActive = NULL )
    {
        
        $where = array();
        
        if( !is_null($isActive ) )
        {           
            $where['isActive'] = $isActive;
        }
        
        
        if( !$withIsAdmin )
        {
            $where['isAdmin'] = 0;
        }
        
        $this->db->order_by("num_order","asc");
        $query = $this->db->get_where($this->table, $where);

        $rows = $query->result_array();

        $eModules = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eModule = new eModule();
                $eModule->parseRow($row);
                
                $eModules[] = $eModule;
            }
        }
        
        return $eModules;
    }
    function listModules( $id_parent = NULL, $ORDER_BY = self::ORDER_BY_ORDER, $withIsAdmin=FALSE, $isActive=NULL )
    {
        $where = array('id_parent'=>$id_parent);
        
        if( !$withIsAdmin )
        {
            $where['isAdmin'] = 0;            
        }
        
        if( !is_null($isActive ) )
        {           
            $where['isActive'] = $isActive;
        }
        
        $this->db->order_by( $ORDER_BY == self::ORDER_BY_NAME ? 'name' : "num_order","asc");
        $query = $this->db->get_where($this->table, $where);
        
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
                $eModule->parseRow($row);
                
                $eModules[] = $eModule;
            }
        }
        
        return $eModules;
    }
    
}

class eModule extends MY_Entity
{
    public $id_parent;
    public $name;
    public $description;
    public $name_key;
    public $num_order;
    public $isAdmin;
    public $isActive;
    public $name_icon;


    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_parent    = NULL;
            $this->name         = '';
            $this->description  = '';
            $this->name_key     = '';
            $this->num_order    = 0;
            $this->isAdmin      = 0;
            $this->isActive     = 0;
            $this->name_icon    = NULL;
        }
    }
}