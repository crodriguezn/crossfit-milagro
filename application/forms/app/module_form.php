<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Module extends MY_Form
{
    // FIELDS
    public $id_module;
    public $id_parent_module;
    public $name;
    public $name_key;
    public $description;
    public $permissions;

    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->reset();
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function reset()
    {
        $this->id_module = 0;
        $this->id_parent_module = 0;
        $this->name = '';
        $this->name_key = '';
        $this->description = '';
        $this->permissions = array();
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->id_module = $MY->input->post('id_module');
        $this->id_parent_module = $MY->input->post('id_parent_module');
        $this->name = $MY->input->post('name');
        $this->name_key = $MY->input->post('name_key');
        $this->description = $MY->input->post('description');
        
        $permissions = $MY->input->post('permissions');
        if( $permissions )
        {
            foreach( $permissions as $permission )
            {
                $frm = new Form_App_Module_Permission();
                $frm->readPost($permission);
                
                $this->permissions[] = $frm;
            }
        }
    }
    
    public function isValid( &$frm_error )
    {
        $isValid = TRUE;
        
        $frm_error = new $this();
        
        if( empty($this->name) )
        {
            $frm_error->name = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->name_key) )
        {
            $frm_error->name_key = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->description) )
        {
            $frm_error->description = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        return $isValid;
        
//        $this->clearErrors();
//        
//        if( empty($this->name) )
//        {
//            $this->addError('name', 'Campo no debe estar vacío');
//        }
//        
//        if( empty($this->name_key) )
//        {
//            $this->addError('name_key', 'Campo no debe estar vacío');
//        }
//        
//        if( empty($this->description) )
//        {
//            $this->addError('description', 'Campo no debe estar vacío');
//        }
//        
//        return $this->isErrorEmpty();
    }
    
    public function setModuleEntity( eModule $eModule )
    {
        if( $eModule->isEmpty() ) { return; }
        
        if( !empty($eModule->id) ) { $this->id_module = $eModule->id; }
        if( !empty($eModule->id_parent) ) { $this->id_parent_module = $eModule->id_parent; }
        $this->name = $eModule->name;
        $this->name_key = $eModule->name_key;
        $this->description = $eModule->description;
    }
    
    public function getModuleEntity()
    {
        $eModule = new eModule(FALSE);
        
        $eModule->id = $this->id_module;
        $eModule->id_parent = empty($this->id_parent_module) ? NULL : $this->id_parent_module;
        $eModule->name = $this->name;
        $eModule->name_key = $this->name_key;
        $eModule->description = $this->description;
        
        return $eModule;
    }
    
    public function setPermissionEntities( $ePermissions )
    {
        if( !empty($ePermissions) )
        {
            /* @var $ePermission ePermission */
            foreach( $ePermissions as $ePermission )
            {
                $frm = new Form_App_Module_Permission();
                $frm->setPermissionEntity($ePermission);
                
                $this->permissions[] = $frm;
            }
        }
    }
    
    public function getPermissionEntities()
    {
        $ePermissions = array();
        
        if( !empty($this->permissions) )
        {
            /* @var $frmPermission Form_App_Module_Permission */
            foreach( $this->permissions as $frmPermission )
            {
                $ePermission = $frmPermission->getPermissionEntity();
                
                $ePermissions[] = $ePermission;
            }
        }
        
        return $ePermissions;
    }
}

class Form_App_Module_Permission extends MY_Form
{
    public $permission_id;
    public $permission_name;
    public $permission_name_key;
    public $permission_description;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->permission_id = 0;
        $this->permission_name = '';
        $this->permission_name_key = '';
        $this->permission_description = '';
    }
    
    public function readPost( $post=array() )
    {
        $MY =& MY_Controller::get_instance();
        
        $post = empty($post) ? $MY->input->post : $post;
        
        $this->permission_id = $post['permission_id'];
        $this->permission_name = $post['permission_name'];
        $this->permission_name_key = $post['permission_name_key'];
        $this->permission_description = $post['permission_description'];
    }
    
    /* @var $ePermission ePermission */
    public function setPermissionEntity( $ePermission )
    {
        $this->permission_id = $ePermission->id;
        $this->permission_name = $ePermission->name;
        $this->permission_name_key = $ePermission->name_key;
        $this->permission_description = $ePermission->description;
    }
    
    public function getPermissionEntity()
    {
        $ePermission = new ePermission(FALSE);
                
        $ePermission->id = $this->permission_id;
        $ePermission->name = $this->permission_name;
        $ePermission->name_key = $this->permission_name_key;
        $ePermission->description = $this->permission_description;
        
        return $ePermission;
    }
}