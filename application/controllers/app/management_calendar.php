<?php

/*
 * @autor Carlos Luis Rodriguez Nieto (taylorluis93@gmail.com)
 * @date 17-abr-2017
 * @time 22:26:10
 * @link http://luis-rodriguez-ec.herokuapp.com/site/index
 */

class Management_Calendar extends MY_Controller
{
    protected $name_key = 'management_calendar';
    
    /* @var $permission Management_Calendar_Permission */
    protected $permission;
    
    function __construct() 
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/management/calendar/permission.php');
        $this->permission = new Management_Calendar_Permission( $this->name_key );
        
        $this->permission->view = Helper_App_Session::isPermissionForModule($this->name_key,'view');
        
        if( !Helper_App_Session::isLogin() )
        {
            $this->redirect('app/login');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->redirect('app/login_advanced');
            return;
        }
               
        if( Helper_App_Session::isBlock() )
        {
            $this->redirect('app/login_advanced');
            return;
        }
        
        if( !$this->permission->access )
        {
            Helper_App_Log::write("Management Calendar: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }
    
    public function index()
    {
        Helper_App_View::layout('app/html/pages/management/calendar/page');
    }
    
    public function mvcjs()
    {
        //$this->load->file('application/modules/app/security/binnacle/form/binnacle_form.php');
        //$frm = new Form_App_Security_Binnacle();
        //start: '2017-04-12T10:30:00', end: '2017-04-12T12:30:00'
        /*$data = array(
            array('title' => 'All Day Event', 'start' => '2017-04-18 06:00:00', 'end'=> '2017-04-18 07:00:00'),
        );*/
        
        /*$data = array(
                        array(
                            'url' => 'app/management_calendar/events/1',
                            'color' => 'black',
                            'textColor' => 'yellow'
                            ),
                        array(
                            'url' => 'app/management_calendar/events/2',
                            'color' => 'yellow',
                            'textColor' => 'black'
                            ),
                );*/
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'calendar_form_default' => NULL,//$frm->toArray()
            'data' => array('app/management_calendar/events/1')
        );
        
        Helper_App_JS::showMVC('management/calendar', $params);
    }
}