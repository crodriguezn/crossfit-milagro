<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_Class_HourX extends MY_Controller
{
    protected $name_key = 'setting_class_hour';
    
    /* @var $permission Setting_Class_Hour_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/setting/class_hour/permission.php');
        $this->permission = new Setting_Class_Hour_Permission( $this->name_key );
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
            case 'list-hour-class':
                $this->listClassHour();
                break;
            case 'load-hour-class':
                $this->loadClassHour();
                break;
            case 'save-hour-class':
                $this->saveClassHour();
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
    
    private function listClassHour()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter = $this->input->get('sSearch');
        $limit      = $this->input->get('iDisplayLength');
        $offset     = $this->input->get('iDisplayStart');
        
        $oBus = Business_App_Class_Hour::listClassHour($txt_filter, $limit, $offset);
        $data = $oBus->data();

        $eClassHours = $data['eClassHours'];
        $count      = $data['count'];
        
        $aaData = array();
        
        if( !empty($eClassHours) )
        {
            
            /* @var $eClassHour eClassHour */
            foreach( $eClassHours as $eClassHour )
            {
                
                $aaData[] = array( 
                        trim($eClassHour->start_hour), 
                        trim($eClassHour->final_hour), 
                        trim($eClassHour->isActive), 
                        trim($eClassHour->id) 
                    );
            }
        }
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadClassHour()
    {
        $this->load->file('application/modules/app/setting/class_hour/form/class_hour_form.php');
        
        $frm_data = new Form_App_Setting_Class_Hour();
        
        $resAjax = new Response_Ajax();
        
        $frm_data->setIdForm(0);
        
        $id_schedule = $this->input->post('id_schedule');
        
        try 
        {

            $oBus = Business_App_Class_Hour::loadClassHour($id_schedule);
            if(!$oBus->isSuccess())
            {
                throw new Exception($oBus->message());
            }
            
            $data = $oBus->data();

            /* @var $eClassSchedule eClassHour  */
            $eClassHour   = $data['eClassHour'];
            
            $frm_data->setScheduleEntity($eClassHour);
            
            $resAjax->isSuccess( TRUE );
        
        } 
        catch (Exception $exc) 
        {
            $resAjax->isSuccess( FALSE );
            $resAjax->message( $exc->getMessage() );
        }

        $resAjax->form('schedule', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveClassHour()
    {
        $this->load->file('application/modules/app/setting/class_hour/form/class_hour_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_Setting_Class_Hour(TRUE);
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
            
            $eClassHour = $frm_data->getScheduleEntity();

            $oBus = Business_App_Class_Hour::saveClassHour( $eClassHour );
            
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
            $resAjax->form('schedule', $frm_data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
}