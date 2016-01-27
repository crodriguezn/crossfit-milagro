<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Session_Activity_Model extends MY_Model
{
    protected $table = 'session_activity';

    function __construct()
    {
        parent::__construct();
    }
    
    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eSessionActivity = new eSessionActivity();
        $eSessionActivity->parseRow($row);
        
        return $eSessionActivity;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id')
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eSessionActivity = new eSessionActivity();
        $eSessionActivity->parseRow($row);
        
        return $eSessionActivity;
    }
    
    function save( eSessionActivity &$eSessionActivity )
    {
        try
        {
            if( empty($eSessionActivity->id) )
            {
                $eSessionActivity->id = $this->genId();
                $this->insert($eSessionActivity->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eSessionActivity->toData(FALSE), $eSessionActivity->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
}

class eSessionActivity extends MY_Entity
{
    public $id_user_profile;
    public $session_id;
    public $last_activity;
    public $inUse;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_user_profile = NULL;
            $this->session_id = '';
            $this->last_activity = NULL;
            $this->inUse = 0;
        }
    }
}