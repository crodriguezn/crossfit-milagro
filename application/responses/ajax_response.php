<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Response_Ajax extends MY_Response
{
    // for datatable
    protected $aaData;
    protected $iTotalRecords;
    protected $iTotalDisplayRecords;
    
    // for forms
    protected $forms;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->forms = array();
        
        $this->aaData = array();
        $this->iTotalRecords = 0;
        $this->iTotalDisplayRecords = 0;
    }
    
    public function form( $name_key, $arrForm = NULL )
    {
        if( !is_array($arrForm) )
        {
            return isset($this->forms[$name_key]) ? $this->forms[$name_key] : array();
        }
        
        $this->forms[$name_key] = $arrForm;
    }
    
    public function forms()
    {
        return $this->forms;
    }
    
    public function datatable( $arrData, $total_records )
    {
        $this->aaData = $arrData;
        $this->iTotalRecords = empty($total_records)? 0 : $total_records;
        $this->iTotalDisplayRecords = empty($total_records)? 0 : $total_records;
    }
    
    public function toJsonEncode()
    {
        return json_encode( $this->toArray() );
    }
}

