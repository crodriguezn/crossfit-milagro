<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_Class_Hour extends MY_Controller
{
    protected $name_key = 'setting_class_hour';
    
    /* @var $permission Setting_Class_Hour_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/setting/class_hour/permission.php');
        $this->permission = new Setting_Class_Hour_Permission( $this->name_key );
        
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
            Helper_App_Log::write("Mantenimiento Horas Clases: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/setting/class_hour/page');
    }
    
    public function mvcjs()
    {
        
        $this->load->file('application/modules/app/setting/class_hour/form/class_hour_form.php');
        $data_form= new Form_App_Setting_Class_Hour();
      
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'schedule_class_form_default' => $data_form->toArray()
        );
        
        Helper_App_JS::showMVC('setting/class_hour', $params);
    }
}