<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_Version_Model extends MY_Model 
{
    protected $table = 'app_version';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eAppVersion = new eAppVersion();
        
        $eAppVersion->parseRow($row);
        
        return $eAppVersion;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id') 
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eAppVersion = new eAppVersion();
        
        $eAppVersion->parseRow($row);
        
        return $eAppVersion;
    }
            
    function save(eAppVersion &$eAppVersion)
    {
        try
        {
            if (empty($eAppVersion->id)) 
            {
                $eAppVersion->id = $this->genId();
                 
                $this->insert($eAppVersion->toData());
            }
            else
            {
                $this->update($eAppVersion->toData(TRUE), $eAppVersion->id);
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
}

class eAppVersion extends MY_Entity
{
    public $name;
    public $name_key;
    public $update_time;
    public $isActive;
    public $isDataBase;
    public $isProject;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->name_key = '';
            $this->update_time = '';
            $this->isActive = 0;
            $this->isDataBase = 0;
            $this->isProject = 0;
        }
    }
}