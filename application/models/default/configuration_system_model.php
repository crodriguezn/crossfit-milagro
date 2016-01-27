<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Configuration_System_Model extends MY_Model 
{
    protected $table = 'configuration_system';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eConfigurationSystem = new eConfigurationSystem();
        
        $eConfigurationSystem->parseRow($row);
        
        return $eConfigurationSystem;
    }
    
    function save(eConfigurationSystem &$eConfigurationSystem)
    {
        try
        {
            if (empty($eConfigurationSystem->id)) 
            {
                $eConfigurationSystem->id = $this->genId();
                 
                $this->insert($eConfigurationSystem->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eConfigurationSystem->toData(TRUE), $eConfigurationSystem->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
}

class eConfigurationSystem extends MY_Entity
{
    public $name_system;
    public $logo;
    public $session_time_limit_min;
    public $session_time_limit_max;
    public $isSaveBinnacle;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name_system              = NULL;
            $this->logo                     = NULL;
            $this->session_time_limit_min   = NULL;
            $this->session_time_limit_max   = NULL;
            $this->isSaveBinnacle           = NULL;
        }
    }
}