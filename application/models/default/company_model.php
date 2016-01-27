<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company_Model extends MY_Model 
{
    protected $table = 'company';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eCompany = new eCompany();
        
        $eCompany->parseRow($row);
        
        return $eCompany;
    }
    
    function save(eCompany &$eCompany)
    {
        try
        {
            if (empty($eCompany->id)) 
            {
                $eCompany->id = $this->genId();
                 
                $this->insert($eCompany->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eCompany->toData(TRUE), $eCompany->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    
}

class eCompany extends MY_Entity
{
    public $name;
    public $name_key;
    public $description;
    public $phone;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->name_key = '';
            $this->description = NULL;
            $this->phone = NULL;
        }
    }
}