<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Security_Binnacle extends MY_Form
{
    public $id_binnacle;
    public $username;
    public $info;
    public $date_time;
    public $url;
    public $ip;
    public $action;
    public $browser;
    public $time;

    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->id_binnacle  = 0;
        $this->username     = '';
        $this->info         = '';
        $this->date_time    = '';
        $this->url          = '';
        $this->ip           = '';
        $this->action       = '';
        $this->browser      = '';
        $this->time         = '';
        
        if( $isReadPost )
        {
            $this->readPost();
        }
        
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->id_binnacle  = $MY->input->post('id_binnacle');
        $this->username     = $MY->input->post('username');
        $this->info         = $MY->input->post('info');
        $this->date_time    = $MY->input->post('date_time');
        $this->url          = $MY->input->post('url');
        $this->ip           = $MY->input->post('ip');
        $this->action       = $MY->input->post('action');
        $this->browser      = $MY->input->post('browser');
    }
    
    public function getBinnacleEntity()
    {
        $eUserLog = new eUserLog(FALSE);
        
        $eUserLog->id = empty($this->id_binnacle) ? NULL : $this->id_binnacle;
        
        return $eUserLog;
    }
    
    public function setBinnacleEntity(eUserLog $eUserLog )
    {
        $this->id_binnacle  = $eUserLog->id;
        $this->info         = $eUserLog->info;
        $this->date_time    = Helper_Fecha::setFomratDate($eUserLog->date_time);
        $this->url          = $eUserLog->url;
        $this->ip           = $eUserLog->ip;
        
        if( $eUserLog->action == 'ACTION_DEFAULT' )    { $this->action = Helper_App_Log::LOG_DEFAULT; }
        if( $eUserLog->action == 'ACTION_LOGIN' )      { $this->action = Helper_App_Log::LOG_LOGIN; }
        if( $eUserLog->action == 'ACTION_INSERT' )     { $this->action = Helper_App_Log::LOG_INSERT; }
        if( $eUserLog->action == 'ACTION_UPDATE' )     { $this->action = Helper_App_Log::LOG_UPDATE; }
        if( $eUserLog->action == 'ACTION_DELETE' )     { $this->action = Helper_App_Log::LOG_DELETE; }
        
        $this->browser      = $eUserLog->browser;
        $this->time         = Helper_Fecha::getIntervalDate( $eUserLog->date_time );
        
    }   
    
    public function setUserEntity(eUser $eUser )
    {
        $this->username = $eUser->username;
    }  
    
}
