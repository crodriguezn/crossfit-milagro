<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_App_Module_Module extends MY_Data
{
    // FIELDS
    public $id_module;
    public $id_parent_module;
    public $name;
    public $name_key;
    public $description;
    public $id_icon;
    public $isActive;
    public $isAdmin;
    public $_permissions;

    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->reset();
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function reset( $RESET_TYPE=self::RESET_DEFAULT )
    {
        if( $RESET_TYPE == self::RESET_STRING )
        {
            $this->id_module = '';
            $this->id_parent_module = '';
            $this->name = '';
            $this->name_key = '';
            $this->description = '';
            $this->id_icon = '';
            $this->isActive = 0;
            $this->isAdmin = 0;
            $this->_permissions = '';
        }
        else
        {
            $this->id_module = 0;
            $this->id_parent_module = 0;
            $this->name = '';
            $this->name_key = '';
            $this->description = '';
            $this->id_icon = '';
            $this->isActive = 0;
            $this->isAdmin = 0;
            $this->_permissions = array();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->id_module = $MY->input->post('id_module');
        $this->id_parent_module = $MY->input->post('id_parent_module');
        $this->name = $MY->input->post('name');
        $this->name_key = $MY->input->post('name_key');
        $this->description = $MY->input->post('description');
        $this->id_icon = $MY->input->post('id_icon');
        $this->isActive = $MY->input->post('isActive');
        $this->isAdmin = $MY->input->post('isAdmin');
        $_permissions = $MY->input->post('_permissions');
        if( $_permissions )
        {
            foreach( $_permissions as $permission )
            {
                $frm = new Data_App_Module_Permission();
                $frm->readPost($permission);
                
                $this->_permissions[] = $frm;
            }
        }
    }
    
    public function isValid( &$data_error )
    {
        $isValid = TRUE;
        
        $data_error = new $this();
        $data_error->reset(self::RESET_STRING);
        
        if( empty($this->name) )
        {
            $data_error->name = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->name_key) )
        {
            $data_error->name_key = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->description) )
        {
            $data_error->description = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        return $isValid;
    }
    
    public function setModuleEntity( eModule $eModule )
    {
        if( $eModule->isEmpty() ) { return; }
        
        if( !empty($eModule->id) ) { $this->id_module = $eModule->id; }
        if( !empty($eModule->id_parent) ) { $this->id_parent_module = $eModule->id_parent; }
        $this->name = $eModule->name;
        $this->name_key = $eModule->name_key;
        $this->description = $eModule->description;
        $this->id_icon = $eModule->name_icon;
        $this->isActive = $eModule->isActive;
        $this->isAdmin = $eModule->isAdmin;
    }
    
    public function getModuleEntity()
    {
        $eModule = new eModule(FALSE);
        
        $eModule->id = $this->id_module;
        $eModule->id_parent = empty($this->id_parent_module) ? NULL : $this->id_parent_module;
        $eModule->name = $this->name;
        $eModule->name_key = $this->name_key;
        $eModule->description = $this->description;
        $eModule->name_icon = empty($this->id_parent_module) ? $this->id_icon : NULL;
        $eModule->isActive = $this->isActive;
        $eModule->isAdmin = $this->isAdmin;
        return $eModule;
    }
    
    public function setPermissionEntities( $ePermissions )
    {
        if( !empty($ePermissions) )
        {
            /* @var $ePermission ePermission */
            foreach( $ePermissions as $ePermission )
            {
                $frm = new Data_App_Module_Permission();
                $frm->setPermissionEntity($ePermission);
                
                $this->_permissions[] = $frm;
            }
        }
    }
    
    public function getPermissionEntities()
    {
        $ePermissions = array();
        
        if( !empty($this->_permissions) )
        {
            /* @var $frmPermission Data_App_Module_Permission */
            foreach( $this->_permissions as $frmPermission )
            {
                $ePermission = $frmPermission->getPermissionEntity();
                
                $ePermissions[] = $ePermission;
            }
        }
        
        return $ePermissions;
    }
}

class Data_App_Module_Permission extends MY_Data
{
    public $permission_id;
    public $permission_name;
    public $permission_name_key;
    public $permission_description;
    public $permission_id_module;


    public function __construct()
    {
        parent::__construct();
        
        $this->permission_id = 0;
        $this->permission_name = '';
        $this->permission_name_key = '';
        $this->permission_description = '';
        $this->permission_id_module = 0;
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