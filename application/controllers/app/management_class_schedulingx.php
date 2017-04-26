<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management_Class_SchedulingX extends MY_Controller
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
            case 'list-programacion-clases':
                $this->listProgramacionClases();
                break;
            case 'load-programacion-clases':
                $this->loadProgramacionClases();
                break;
            case 'save-programacion-clases':
                $this->saveProgramacionClases();
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
    
    private function listProgramacionClases()
    {
        
        $resAjax = new Response_Ajax();
        
        $txt_filter     = NULL;
        $limit          = NULL;
        $offset         = NULL;
        $id_employee    = NULL;
        $start          = $this->input->get('start');
        $end            = $this->input->get('end')-86400000; /*86400000 representa un dia en milisegundos*/
        $isActive       = 1;
        $viewEvent      = $this->input->get('viewEvent');
        
        
        $aaData = array();
        if($viewEvent=='month')
        {
            $oBus = Business_App_Class_Date::listClassDate($txt_filter, $limit, $offset, $start, $end);
            
            $data = $oBus->data();

            $eClassDates        = $data['eClassDates'];
            $count              = $data['count'];
            
            if( !empty($eClassDates) )
            {
                /* @var $eClassDate eClassDate */
                foreach( $eClassDates as $num => $eClassDate )
                {
                    $aaData[] = array(
                                        'id'            => $eClassDate->id,
                                        'title'         => ($eClassDate->start_day < date('Y-m-d')) ? 'Clase Cerrada' : 'Clase Abierta', 
                                        'start'         => date('Y-m-d',strtotime($eClassDate->start_day)), 
                                        'end'           => date('Y-m-d',strtotime($eClassDate->start_day)), 
                                        'allDay'        => true
                                );
                }
            }
        }
        else
        {
            $oBus = Business_App_Class_Scheduling::listProgrammingClass( $txt_filter, $limit, $offset, $start, $end, $id_employee, $isActive );
            $data = $oBus->data();

            $eClassSchedulings  = $data['eClassSchedulings'];
            $eClassHours        = $data['eClassHours'];
            $eClassDates        = $data['eClassDates'];
            $eEmployees         = $data['eEmployees'];
            $ePersons           = $data['ePersons'];
            $count              = $data['count'];
            
            if( !empty($eClassSchedulings) )
            {
                /* @var $eClassScheduling eClassScheduling */
                foreach( $eClassSchedulings as $num => $eClassScheduling )
                {
                    $aaData[] = array(
                                        'id'            => $eClassScheduling->id,
                                        //'title'         => 'Clase '.$eClassHours[$num]->start_hour.'-'.$eClassHours[$num]->final_hour, 
                                        'title'         => 'Clase', 
                                        'start'         => $eClassDates[$num]->start_day.' '.$eClassHours[$num]->start_hour.':00', 
                                        'end'           => $eClassDates[$num]->start_day.' '.$eClassHours[$num]->final_hour.':00', 
                                        'entrenador'    => $ePersons[$num]->name.' '.$ePersons[$num]->surname,
                                        'fecha'         => $eClassDates[$num]->start_day,
                                        'inicio'        => $eClassHours[$num]->start_hour.':00',
                                        'fin'           => $eClassHours[$num]->final_hour.':00',
                                        'allDay'        => false
                                );
                }
            }
       }
        //echo json_encode($aaData);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
        
    }
    
    private function loadProgramacionClases()
    {
        $this->load->file('application/modules/app/management/class_scheduling/form/class_scheduling_form.php');
        
        $resAjax = new Response_Ajax();
        
        $frm_data = new Form_App_Class_Scheduling();
        
        $start_day = $this->input->post('start_day');
        
        try 
        {

            $oBus = Business_App_Class_Scheduling::loadClassScheduling($start_day);
            if(!$oBus->isSuccess())
            {
                throw new Exception($oBus->message());
            }
            
            $data = $oBus->data();

            /* @var $eClassDate eClassDate  */
            $eClassDate   = $data['eClassDate'];
            $eClassSchedulings  = $data['eClassSchedulings'];
            
            $frm_data->setIdForm(1);
        
            $frm_data->setClassDateEntity($eClassDate);
            $frm_data->setClassSchedulingEntities($eClassSchedulings);
            
            $resAjax->isSuccess( TRUE );
        
        } 
        catch (Exception $exc) 
        {
            $resAjax->isSuccess( FALSE );
            $resAjax->message( $exc->getMessage() );
        }

        
        $resAjax->form('programacion_clases', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveProgramacionClases()
    {
        $this->load->file('application/modules/app/management/class_scheduling/form/class_scheduling_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_Class_Scheduling(TRUE);
        $id_form = Helper_Encrypt::decode($frm_data->id_form);
        try
        {
            
            if(empty($id_form) &&( !$this->permission->create ))
            {
                throw new Exception('No tiene permisos para crear/nuevo');
            }
            elseif(!empty($id_form)&&( !$this->permission->update ))
            {
                throw new Exception('No tiene permisos para editar/actualizar');
            } 
            
            if( !$frm_data->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            if($frm_data->start_day < date('Y-m-d'))
            {
                throw new Exception('No puede crear/actualizar datos menor a la fecha actual');
            }
            
            $eClassDate = $frm_data->getClassDateEntity();
            $eClassSchedulings = $frm_data->getClassSchedulingEntities();

            $oBus = Business_App_Class_Scheduling::saveClassScheduling( $eClassDate, $eClassSchedulings );
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }

            $resAjax->isSuccess(TRUE);
            $resAjax->message($oBus->message());
        }
        catch( Exception $ex )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message($ex->getMessage());
            $resAjax->form('programacion_clases', $frm_data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
}