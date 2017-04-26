<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_Customer_Crossfit extends MY_Controller
{
    protected $name_key = 'setting_customer_crossfit';
    
    /* @var $permission Setting_Customer_Crossfit_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/setting/customer_crossfit/permission.php');
        $this->permission = new Setting_Customer_Crossfit_Permission( $this->name_key );
        
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
            Helper_App_Log::write("Mantenimiento de Cliente: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/setting/customer_crossfit/page');
    }
    
    public function mvcjs()
    {
        
        $this->load->file('application/modules/app/setting/customer_crossfit/form/customer_crossfit_form.php');
        $this->load->file('application/modules/app/setting/customer_crossfit/form/control_imc_form.php');
        $data_form= new Form_App_Setting_Customer_Crossfit();
        $data_imc= new Form_App_Control_IMC();
        
      
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'customer_crossfit_form_default' => $data_form->toArray(),
            'control_imc_form_default'  => $data_imc->toArray()
        );
        
        Helper_App_JS::showMVC('setting/customer_crossfit', $params);
    }
}