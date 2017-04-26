<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Profile_Permission extends MY_Form
{
    public $id_profile;
    public $id_permissions;
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->id_profile = 0;
        $this->id_permissions = array();
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->id_profile       = $MY->input->post('id_profile');
        $this->id_permissions   = $MY->input->post('id_permissions');
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->id_profile) )
        {
            $this->addError('id_profile', 'Campo no debe estar vacío');
        }
        
        if( empty($this->id_permissions) )
        {
            $this->addError('id_permissions', 'Campo no debe estar vacío');
        }       
        
        return $this->isErrorEmpty();
    }
    
    public function getProfilePermissionEntities()
    {
        $eProfilesPermissions = array();
                  
        if( !empty($this->id_permissions) )
        {
            foreach( $this->id_permissions as $id_permission ) 
            {

                $eProfilePermission                 = new eProfilePermission(FALSE);
                $eProfilePermission->id_permission  = $id_permission;
                $eProfilePermission->id_profile     = $this->id_profile;

                $eProfilesPermissions[]=$eProfilePermission;
            }
        }
        
        return $eProfilesPermissions;
    }  
    
    public function setProfilePermissionEntities( $eProfilesPermissions )
    {
        if( !empty($eProfilesPermissions) )
        {
            /* @var $eProfilePermission eProfilePermission */
            foreach( $eProfilesPermissions as $eProfilePermission )
            {
                $this->id_permissions[] = $eProfilePermission->id_permission;
            }
        }
    }
    
    
    
    
}
