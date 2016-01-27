<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Module
{

    static public function listModulesAndSubmodules()
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mModule Module_Model */
        $mModule =& $MY->mModule;
        
        $modules_submodules = array();
        
        try
        {
            $eModule_Parents = $mModule->listModules(NULL, Module_Model::ORDER_BY_ORDER, Helper_App_Session::isAdminProfile());
            
            if( !empty($eModule_Parents) )
            {
                /* @var $eModule_Parent eModule */
                foreach( $eModule_Parents as $eModule_Parent )
                {
                    // submodulos
                    $eModule_Children = $mModule->listModules( $eModule_Parent->id, Module_Model::ORDER_BY_ORDER, Helper_App_Session::isAdminProfile() );

                    $modules_submodules[] = array(
                        'eModule_Parent'   => $eModule_Parent,  // modulo
                        'eModule_Children' => $eModule_Children // submodulos
                    );
                }
            }
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->isSuccess( $ex->getMessage() );
        }
            
        $oBus->data(array(
            'modules_submodules' => $modules_submodules
        ));
        
        
        return $oBus;
    }
    
    
    static public function listModules( $id_parent = NULL )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mModule Module_Model */
        $mModule =& $MY->mModule;
        
        $eModules = array();
        try
        {
            $eModules = $mModule->listModules($id_parent, Module_Model::ORDER_BY_NAME, Helper_App_Session::isSuperAdminProfile());
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array('eModules' => $eModules));
               
        return $oBus;
    }
    
    
    static public function loadModulePermissions( $id_module )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mModule Module_Model */
        $mModule =& $MY->mModule;
        /* @var $mPermission Permission_Model */
        $mPermission =& $MY->mPermission;
        /* @var $mRol Rol_Model */
        $mRol =& $MY->mRol;

        $eModule = new eModule();
        $ePermissions = array();
        
        try
        {
            /* @var $eModule eModule  */
            $eModule = $mModule->load($id_module);
            $ePermissions = $mPermission->listByModule( $eModule->id );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
            
        $oBus->data(array('eModule' => $eModule, 'ePermissions' => $ePermissions));
        
        return $oBus;
    }
    
    
    static public function save(eModule $eModule, $ePermissions)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mModule Module_Model */
        $mModule =& $MY->mModule;
        
        /* @var $mPermission Permission_Model */
        $mPermission =& $MY->mPermission;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        try
        {
            if( empty($eModule->id) )
            {
                $eModule->isAdmin = 0;
                $eModule->num_order = 0;
            }
            
            $mModule->save($eModule);
            
            
            // PERMISSIONS
            
            if( !empty($ePermissions) )
            {
                /* @var $ePermission ePermission */
                foreach( $ePermissions as $ePermission )
                {
                    
                    $ePermission->id_module = $eModule->id; 
                    $mPermission->save($ePermission);
                    
                }
            }

            $oTransaction->commit();
            
            $oBus->isSuccess(TRUE);
            $oBus->message("Guardado exitosamente");
        }
        catch( Exception $e )
        {
            $oTransaction->rollback();
            
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        return $oBus;
    }
    
    static public function saveOrderModules( $eModules )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mModule Module_Model */
        $mModule =& $MY->mModule;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        try
        {
            if( !empty($eModules) )
            {
                foreach( $eModules as $eModule )
                {
                    $mModule->saveOrder( $eModule );
                }
            }

            $oTransaction->commit();
            
            $oBus->isSuccess(TRUE);
            $oBus->message("Guardado exitosamente");
        }
        catch( Exception $e )
        {
            $oTransaction->rollback();
            
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
              
        return $oBus;
    }
    
}