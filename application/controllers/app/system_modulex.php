<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_ModuleX extends MY_Controller
{
    protected $name_key = 'system_module';
    
    /* @var $permission System_Module_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/system/module/permission.php');
        $this->permission = new System_Module_Permission( $this->name_key );
        
    }
    
    public function process( $action )
    {
                
        if( !Helper_App_Session::isLogin() )
        {
            $this->noaction('Fuera de sesión');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->noaction('Fuera de sesión por Inactividad');
            return;
        }
        
        if( Helper_App_Session::isBlock() )
        {
            $this->noaction('Fuera de session por Bloqueo');
            return;
        }
        
        if( !$this->permission->access )
        {
            $this->noaction('Acceso no permitido');
            return;
        }

        switch( $action )
        {
            case 'list-modules-submodules':
                $this->listModulesSubmodules();
                break;
            case 'listmodule':
                $this->listModule();
                break;
            case 'load-module':
                $this->loadModule();
                break;
            case 'save-module':
                $this->saveModule();
                break;
            case 'load-components-modal-module':
                $this->loadComponentsModalModule();
                break;
            case 'save-order-modules':
                $this->saveOrderModules();
                break;
            default:
                $this->noaction($action);
                break;
        }
    }
    
    private function noaction($action)
    {
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess(FALSE);
        $resAjax->message("No found action: $action");
        
        echo $resAjax->toJsonEncode();
    }
    
    private function listModulesSubmodules()
    {
        $this->load->file('application/modules/app/system/module/data/modules_submodules_data.php');
        
        $resAjax = new Response_Ajax();
        
        $data_modules_submodules = new Data_App_Module_Modules_Submodules();
        
        try
        {
            $oBus = Business_App_Module::listModulesAndSubmodules();
            $data = $oBus->data();
        
            $modules_submodules   = $data['modules_submodules'];
            
            if( !empty($modules_submodules) )
            {
                foreach( $modules_submodules as $module_submodules )
                {
                    /* @var $eModule_Parent eModule */
                    $eModule_Parent   = $module_submodules['eModule_Parent'];
                    $eModule_Children = $module_submodules['eModule_Children'];

                    $data_modules_submodules->addModuleSubmodules($eModule_Parent, $eModule_Children);
                }
            }

            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        '_modules_submodules' => $data_modules_submodules->_modules_submodules
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    
    private function loadComponentsModalModule()
    {
        $resAjax = new Response_Ajax();
        
        $id_company = Helper_App_Session::getCompanyId();
        $combo_modules = array(array('id'=>0, 'name'=>'<< --MÓDULO PADRE-- >>'));

        try
        {
            $oBus = Business_App_Module::listModules(NULL);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $data = $oBus->data();
            $eModules = $data['eModules'];
            
            $combo_modules2  = Helper_Array::entitiesToIdText($eModules, 'id', 'name', 'id', 'name');
            $combo_modules = array_merge($combo_modules, $combo_modules2);
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'combo-modules' => $combo_modules
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    
    private function loadModule()
    {
        $this->load->file('application/modules/app/system/module/data/module_data.php');
        
        $resAjax = new Response_Ajax();
        
        $id_module = $this->input->post('id_module');
        
        $form_data = new Data_App_Module_Module();
        
        try
        {
            $oBus = Business_App_Module::loadModulePermissions($id_module);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $data           = $oBus->data();
            $eModule        = $data['eModule'];
            $ePermissions   = $data['ePermissions'];
            
            $form_data->setModuleEntity($eModule);
            $form_data->setPermissionEntities($ePermissions);
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message( $ex->getMessage() );
        }
        
        $resAjax->data(array( 'module' => $form_data->toArray() ));
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveModule()
    {
        $this->load->file('application/modules/app/system/module/data/module_data.php');
        
        $resAjax = new Response_Ajax();
        
        $form_data = new Data_App_Module_Module(TRUE);
        $dataError = NULL;
        
        try
        {
            if( !$form_data->isValid( $dataError ) )
            {
                $resAjax->data(array('module_error' => $dataError->toArray()));
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $eModule        = $form_data->getModuleEntity();
            $ePermissions   = $form_data->getPermissionEntities();
            
            $oBus = Business_App_Module::save($eModule, $ePermissions);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $form_data->reset();
            
            $resAjax->isSuccess(TRUE);
            $resAjax->message('Guardado exitosamente');
        }
        catch( Exception $e )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message( $e->getMessage() );
        }
        
        echo $resAjax->toJsonEncode();
    }
   
    private function saveOrderModules()
    {
        $resAjax = new Response_Ajax();
        
        $data = $this->input->post('data');
        
        $eModules = array();
        foreach( $data as $dt )
        {
            $eModule = new eModule(FALSE);
            $eModule->id = $dt['id_module'];
            $eModule->num_order = $dt['order'];
            
            $eModules[] = $eModule;
        }
        
        $oBus = Business_App_Module::saveOrderModules($eModules);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        
        echo $resAjax->toJsonEncode();
    }
    
}