<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management_CalendarX extends MY_Controller
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
    }
    
    public function process( $action )
    {
        if( !Helper_App_Session::isLogin() )
        {
            $this->noaction('Fuera de sesión');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->noaction('Fuera de sesión por Inactividad');
            return;
        }
        
        if( Helper_App_Session::isBlock() )
        {
            $this->noaction('Fuera de session por Bloqueo');
            return;
        }
        
        if( !$this->permission->access )
        {
            $this->noaction('Acceso no permitido');
            return;
        }

        switch( $action )
        {
            case 'load-cliente-crossfit':
                $this->loadClienteCrossfit();
                break;
            case 'load-programacion-clases':
                $this->loadProgramacionClases();
                break;
            default:
                $this->noaction($action);
                break;
        }
    }
    
    private function noaction($action)
    {
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess(FALSE);
        $resAjax->message("No found action: $action");
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadClienteCrossfit()
    {
        
        $data = 
                array(
                    array(
                            'id'            => 1,
                            'title'         => 'Carlos Rodriguez', 
                            'start'         => '2017-04-18 06:00:00', 
                            'end'           => '2017-04-18 07:00:00',
                            'entrenador'    => 'Coach Diego Alvarado',
                            'fecha'         => '2017-04-18',
                            'inicio'        => '06:00:00',
                            'fin'           => '07:00:00',
                            'allDay'        => false
                    ),
                    array(
                            'id'            => 2,
                            'title'         => 'Maria Heredia', 
                            'start'         => '2017-04-19 07:00:00', 
                            'end'           => '2017-04-19 08:00:00',
                            'entrenador'    => 'Coach Diego Alvarado',
                            'fecha'         => '2017-04-19',
                            'inicio'        => '07:00:00',
                            'fin'           => '08:00:00',
                            'allDay'        => false
                    )
                );
        
        echo json_encode($data);
    }
    
    private function loadProgramacionClases()
    {
        
        /*$data = 
                array(
                    array(
                            'id'            => 1,
                            'title'         => 'Clase 06-07', 
                            'start'         => '2017-04-18 06:00:00', 
                            'end'           => '2017-04-18 07:00:00',
                            'entrenador'    => 'Coach Diego Alvarado',
                            'fecha'         => '2017-04-18',
                            'inicio'        => '06:00:00',
                            'fin'           => '07:00:00',
                            'allDay'        => false
                    ),
                    array(
                            'id'            => 2,
                            'title'         => 'Clase 19-20', 
                            'start'         => '2017-04-18 19:00:00', 
                            'end'           => '2017-04-18 20:00:00',
                            'entrenador'    => 'Coach Josuap.....',
                            'fecha'         => '2017-04-18',
                            'inicio'        => '19:00:00',
                            'fin'           => '20:00:00',
                            'allDay'        => false
                    )
                );
        echo json_encode($data);*/
        
        $resAjax = new Response_Ajax();
        
        $txt_filter     = NULL;
        $limit          = NULL;
        $offset         = NULL;
        $id_employee    = NULL;
        
        
        $oBus = Business_App_Class_Scheduling::listProgrammingClass( $txt_filter, $limit, $offset, $id_employee );
        $data = $oBus->data();
        /*
            'eClassSchedulings' => $eClassSchedulings,
            'eClassHours'       => $eClassHours,
            'eClassDates'       => $eClassDates,
            'eEmployees'        => $eEmployees,
            'ePersons'          => $ePersons,
            'count'             => $count
        */
        $eClassSchedulings  = $data['eClassSchedulings'];
        $eClassHours        = $data['eClassHours'];
        $eClassDates        = $data['eClassDates'];
        $eEmployees         = $data['eEmployees'];
        $ePersons           = $data['ePersons'];
        $count              = $data['count'];
        
        $aaData = array();
        
        if( !empty($eClassSchedulings) )
        {
            /* @var $eClassScheduling eClassScheduling */
            foreach( $eClassSchedulings as $num => $eClassScheduling )
            {
                
                //$aaData[] = array( trim($action), trim($eUsers[$num]->username), trim($eUserLog->date_time), trim($eUserLog->ip), trim($eUserLog->id) );
                $aaData[] = array(
                                    'id'            => $eClassScheduling->id,
                                    //'title'         => 'Clase '.$eClassHours[$num]->start_hour.'-'.$eClassHours[$num]->final_hour, 
                                    'title'         => 'Clase', 
                                    'start'         => $eClassDates[$num]->day.' '.$eClassHours[$num]->start_hour.':00', 
                                    'end'           => $eClassDates[$num]->day.' '.$eClassHours[$num]->final_hour.':00', 
                                    'entrenador'    => $ePersons[$num]->name.' '.$ePersons[$num]->surname,
                                    'fecha'         => $eClassDates[$num]->day,
                                    'inicio'        => $eClassHours[$num]->start_hour.':00',
                                    'fin'           => $eClassHours[$num]->final_hour.':00',
                                    'allDay'        => false
                            );
            }
        }
        /*
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
        */
        echo json_encode($aaData);
    }
    
}