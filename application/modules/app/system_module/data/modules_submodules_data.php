<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_App_Module_Modules_Submodules extends MY_Data
{
    public $_modules_submodules;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_modules_submodules = array();
    }
    
    public function addModuleSubmodules(eModule $eModule, $eSubmodules)
    {
        $data_module = new Data_App_Module_Module();
        
        $data_module->setModule($eModule);
        $data_module->addSubmodules($eSubmodules);
        
        $this->_modules_submodules[] = $data_module;
    }
}

class Data_App_Module_Module extends MY_Data
{
    public $id;
    public $name;
    public $name_icon;
    public $_submodules;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->id = 0;
        $this->name = '';
        $this->name_icon = '';
        $this->_submodules = array();
    }
    
    public function setModule( eModule $eModule )
    {
        $this->id = $eModule->id;
        $this->name = $eModule->name;
        $this->name_icon = $eModule->name_icon;
    }
    
    public function addSubmodules( $eSubmodules )
    {
        if( !empty($eSubmodules) )
        {
            /* @var $eSubmodule $eModule */
            foreach( $eSubmodules as $eSubmodule )
            {
                $dataSubmodule = new Data_App_Module_Submodules();
                $dataSubmodule->setSubmodule($eSubmodule);
                
                $this->_submodules[] = $dataSubmodule;
            }
        }
    }
}

class Data_App_Module_Submodules extends MY_Data
{
    public $id;
    public $name;
    public $name_key;
    public $description;
    public $id_icon;


    public function setSubmodule( eModule $eSubmodule )
    {
        $this->id = $eSubmodule->id;
        $this->name = $eSubmodule->name;
        $this->name_key = $eSubmodule->name_key;
        $this->description = $eSubmodule->description;
        $this->id_icon = $eSubmodule->name_icon;
    }
}