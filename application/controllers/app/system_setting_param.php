<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Setting_Param extends MY_Controller
{
    protected $name_key = 'system_setting_param';
    
    /* @var $permission System_Setting_Param_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/system_setting_param/permission.php');
        $this->permission = new System_Setting_Param_Permission( $this->name_key );
        
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
            Helper_App_Log::write("System Setting Param: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        $arrTimePar = Helper_Fecha::getArrayTime();
        //Helper_Log::write($arrTimePar);
        Helper_App_View::layout('app/html/pages/system_setting_param/page',array('arrTime'=>$arrTimePar));
    }
    
    public function mvcjs()
    {
        $this->load->file('application/modules/app/system_setting_param/form/setting_param_form.php');
        
        $data = new Form_App_System_Setting_Param();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'data_setting_param_default' => $data->toArray()
        );
        
        Helper_App_JS::showMVC('system_setting_param', $params);
    }
}