<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_Binnacle extends MY_Controller
{
    protected $name_key = 'security_binnacle';
    
    /* @var $permission Security_Binnacle_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/security/binnacle/permission.php');
        $this->permission = new Security_Binnacle_Permission( $this->name_key );
        
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
            Helper_App_Log::write("Binnacle: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        $array_array = array(
                    array('id' => Helper_App_Log::LOG_DEFAULT,  'name' => 'DEFAULT' ),
                    array('id' => Helper_App_Log::LOG_LOGIN,    'name' => 'DEBUG'),
                    array('id' => Helper_App_Log::LOG_INSERT,   'name' => 'INSERT'),
                    array('id' => Helper_App_Log::LOG_UPDATE,   'name' => 'UPDATE'),
                    array('id' => Helper_App_Log::LOG_DELETE,   'name' => 'DELETE')
                );
        $combo_action = Helper_Array::toIdText($array_array, 'id', 'name');
        Helper_App_View::layout('app/html/pages/security/binnacle/page', array(
            'combo_action' => $combo_action
        ));
    }
    
    public function mvcjs()
    {
        $this->load->file('application/modules/app/security/binnacle/form/binnacle_form.php');
        $frm = new Form_App_Security_Binnacle();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'binnacle_form_default' => $frm->toArray()
        );
        
        Helper_App_JS::showMVC('security/binnacle', $params);
    }
}