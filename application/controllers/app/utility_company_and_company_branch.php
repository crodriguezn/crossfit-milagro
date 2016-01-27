<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility_Company_And_Company_Branch extends MY_Controller
{
    protected $name_key = 'utility_company_and_company_branch';
    
    /* @var $permission Utility_Company_And_Company_Branch_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/utility_company_and_company_branch/permission.php');
        $this->permission = new Utility_Company_And_Company_Branch_Permission( $this->name_key );
        
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
            Helper_App_Log::write("Mantenimiento de Empresa y Sucursales: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/utility_company_and_company_branch/page');
    }
    
    public function mvcjs()
    {
        $this->load->file('application/modules/app/utility_company_and_company_branch/form/company_form.php');
        $this->load->file('application/modules/app/utility_company_and_company_branch/form/company_branch_form.php');
        
        $data_company = new Form_App_Company();
        $data_company_branch  = new Form_App_Company_Branch();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'data_company_default' => $data_company->toArray(),
            'data_company_branch_default' => $data_company_branch->toArray()
        );
        
        Helper_App_JS::showMVC('utility_company_and_company_branch', $params);
    }
}