<?php

/*
 * @autor Carlos Luis Rodriguez Nieto (taylorluis93@gmail.com)
 * @date 17-abr-2017
 * @time 22:26:10
 * @link http://luis-rodriguez-ec.herokuapp.com/site/index
 */

class Management_Class_Scheduling extends MY_Controller
{
    protected $name_key = 'management_class_scheduling';
    
    /* @var $permission Management_Class_Scheduling_Permission */
    protected $permission;
    
    function __construct() 
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/management/class_scheduling/permission.php');
        $this->permission = new Management_Class_Scheduling_Permission( $this->name_key );
        
        $this->permission->create = Helper_App_Session::isPermissionForModule($this->name_key,'create');
        $this->permission->update = Helper_App_Session::isPermissionForModule($this->name_key,'update');
        
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
            Helper_App_Log::write("Management Class Scheduling: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }
    
    public function index()
    {
        $arrData = array();
        $oBusEmployee = Business_App_Employee::listEmployee(NULL, NULL, NULL, TRUE);
        $dataEmployee = $oBusEmployee->data();

        $eEmployees = $dataEmployee['eEmployees'];
        $ePersons = $dataEmployee['ePersons'];
        
        $aaDataEmployee = array();
        
        if( !empty($eEmployees) )
        {
            
            /* @var $eEmployee eEmployee */
            foreach( $eEmployees as $num =>  $eEmployee )
            {
                $aaDataEmployee[] = array( 
                        'id_coach'  => trim($eEmployee->id),
                        'coach'     => trim($ePersons[$num]->name.' '.$ePersons[$num]->surname) 
                    );
            }
        }
        
        $arrData['coachs'] = $aaDataEmployee;
        
        $oBusHour = Business_App_Class_Hour::listClassHour(NULL, NULL, NULL, 1);
        $dataHour = $oBusHour->data();

        $eClassHours = $dataHour['eClassHours'];
        
        $aaDataHours = array();
        
        if( !empty($eClassHours) )
        {
            
            /* @var $eClassHour eClassHour */
            foreach( $eClassHours as $eClassHour )
            {
                $id_coach = 0;
                /* @var $eEmployee eEmployee */
                foreach ($eEmployees as $num => $eEmployee)
                {
                    if(!( ($eClassHour->start_hour<=$eEmployee->start_time) && ($eClassHour->final_hour<=$eEmployee->final_time)))
                    {
                        $id_coach = $eEmployee->id;
                    }
                }
                
                $aaDataHours[] = array( 
                        'id_coach'      => $id_coach,
                        'start_hour'    => trim($eClassHour->start_hour), 
                        'final_hour'    => trim($eClassHour->final_hour),
                        'id_hour'       => trim($eClassHour->id) 
                    );
            }
        }
        
        $arrData['hours'] = $aaDataHours;
        
        Helper_App_View::layout('app/html/pages/management/class_scheduling/page',$arrData);
    }
    
    public function mvcjs()
    {
        $this->load->file('application/modules/app/management/class_scheduling/form/class_scheduling_form.php');
        $frm = new Form_App_Class_Scheduling();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'class_scheduling_default' => $frm->toArray()
        );
        
        Helper_App_JS::showMVC('management/class_scheduling', $params);
    }
}