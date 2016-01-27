<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permissions extends MY_Controller
{
    protected $name_key = 'security_profile';
    
    /* @var $permission Security_Profile_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/security_profile/permission.php');
        $this->permission = new Security_Profile_Permission( $this->name_key );
        
        $this->permission->view_permission      = Helper_App_Session::isPermissionForModule($this->name_key,'view_permissions');
        $this->permission->update_permission    = Helper_App_Session::isPermissionForModule($this->name_key,'update_permissions');
        
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
        
        if( !$this->permission->view_permission )
        {
            Helper_App_Log::write("Permission: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index(  )
    {
        $this->redirect('app/listing');
    }
    
    public function listing( $id_profile=0 )
    {
        $arrModules = array();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mRolModule Rol_Module_Model */
        $mRolModule =& $MY->mRolModule;
        
        /* @var $mPermission Permission_Model */
        $mPermission =& $MY->mPermission;
        
        /* @var $mProfile Profile_Model */
        $mProfile =& $MY->mProfile;
        
        /* @var $mProfilePermission Profile_Permission_Model */
        $mProfilePermission =& $MY->mProfilePermission;
        
        /* @var $eProfile eProfile */
        $eProfile = $mProfile->load($id_profile);
        
        $arrModules = $mRolModule->listModulesByRol( $eProfile->id_rol, NULL );
            
        /* @var $module eModule */
        foreach ( $arrModules AS $num => $module)
        {
            $arrModules[$num]->{'_permissions'} = $mPermission->listByModule( $module->id );
            $arrModules[$num]->{'_submodules'}  = $mRolModule->listModulesByRol( $eProfile->id_rol, $module->id );

            if( isset($arrModules[$num]->{'_submodules'}) && !empty($arrModules[$num]->{'_submodules'}) )
            {
                foreach( $arrModules[$num]->{'_submodules'} AS $num2 => $submodule )
                {
                    $arrModules[$num]->{'_submodules'}[$num2]->{'_permissions'} = $mPermission->listByModule( $submodule->id );
                }
            }
        }
        $arrProfilePermissionResult = array();
        $arrProfilePermission = $mProfilePermission->listByProfile( $id_profile );
        
        if( !empty($arrProfilePermission) ) 
        {
            foreach( $arrProfilePermission as $profile_permission )
            {
                $arrProfilePermissionResult[] = $profile_permission["id_permission"];
            }
        }
        
        Helper_App_View::layout('app/html/pages/security_profile/listing', array(
            //'arrProfile' => $arrProfile, 
            'arrModuleResult' => $arrModules,
            'eProfile' => $eProfile,
            'arrProfilePermissionResult' => $arrProfilePermissionResult,
            'save'=>$this->permission->update_permission
        ) );
    }
    
    public function mvcjs()
    {
        $this->load->file('application/modules/app/security_profile/form/profile_form.php');
        $frm_data = new Form_App_Security_Profile();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'profile_form_default' => $frm_data->toArray()
        );
        
        Helper_App_JS::showMVC('security_profile/listing', $params);
    }
    
}
