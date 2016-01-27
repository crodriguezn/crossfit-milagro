<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Profile extends MY_Controller
{
    protected $name_key = 'user_profile';
    
    /* @var $permission User_Profile_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/user_profile/permission.php');
        $this->permission = new User_Profile_Permission( $this->name_key );
        
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
            Helper_App_Log::write("My Profile: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/user_profile/page');
    }
    
    public function mvcjs()
    {
        
        $this->load->file('application/modules/app/user_profile/form/profile_form.php');
        $this->load->file('application/modules/app/user_profile/form/user_form.php');
        $frmProfile = new Form_App_Profile();
        
        $frmUser = new Form_App_User();
        
        $oBus = Business_App_User::loadUser( Helper_App_Session::getUserId() );
        $data = $oBus->data();
        $eUser = $data['eUser'];
        
        $frmUser->username = $eUser->username;
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'profile_form_default' => $frmProfile->toArray(),
            'user_form_default' => $frmUser->toArray()
        );
        
        Helper_App_JS::showMVC('user_profile', $params);
    }
}