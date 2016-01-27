<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_App_Permission
{
    // modulos y submodulos
    static public function getMenu()
    {
        $MY =& MY_Controller::get_instance();
        
        /* @var $mModule Module_Model */
        $mModule =& $MY->mModule;
        
        $isSuperAdminProfile = Helper_App_Session::isSuperAdminProfile();
        
        $eModules = $mModule->listModules(NULL, Module_Model::ORDER_BY_ORDER, $isSuperAdminProfile, 1);
        //Helper_Log::write( $eModules );
        
        $sessionPermissionsProfile = Helper_App_Session::getPermissions();
        //Helper_Log::write( $sessionPermissionsRol );
        
        /* @var $eModule eModule */
        foreach( $eModules as $num => $eModule )
        {
            if( !isset( $sessionPermissionsProfile[ $eModule->name_key ] ) )
            {
                unset( $eModules[$num] );
                continue;
            }
            
            $permissions = $sessionPermissionsProfile[ $eModule->name_key ];
            if( !in_array('access', $permissions) )
            {
                unset( $eModules[$num] );
                continue;
            }
            
            $eModulesSub  = $mModule->listModules( $eModule->id, Module_Model::ORDER_BY_ORDER, $isSuperAdminProfile,1 );
            //Helper_Log::write( $eModulesSub );
            
            if( !empty($eModulesSub) )
            {
                
                /* @var $eModuleSub $eModule */
                foreach( $eModulesSub as $num2 => $eModuleSub )
                {
                    if( !isset( $sessionPermissionsProfile[ $eModuleSub->name_key ] ) )
                    {
                        unset( $eModulesSub[$num2] );
                        continue;
                    }
                    
                    $permissions2 = $sessionPermissionsProfile[ $eModuleSub->name_key ];
                    if( !in_array('access', $permissions2) )
                    {
                        unset( $eModulesSub[$num2] );
                        continue;
                    }
                }
            }
            
            if( empty($eModulesSub) )
            {
                unset( $eModules[$num] );
                continue;
            }
            
            $eModules[$num]->{'_submodules'} = $eModulesSub;
            
        }
        
        //Helper_Log::write( $eModules );
        
        return $eModules;
    }
    
    static public function getMenu2()
    {
        $MY =& MY_Controller::get_instance();
        
        /* @var $mModule Module_Model */
        $mModule =& $MY->mModule;
        
        /* @var $mPermission Permission_Model */
        $mPermission =& $MY->mPermission;
        
        $arrModule = $mModule->listModules(NULL, Module_Model::ORDER_BY_ORDER, Helper_App_Session::isSuperAdminProfile(), 1  );
        
        foreach( $arrModule as $num => $module )
        {
            $arrModule[$num]->{'_permissions'} = $mPermission->listByModule( $module->id );
            $arrModule[$num]->{'_submodules'}  = $mModule->listModules( $module->id, Module_Model::ORDER_BY_ORDER, Helper_App_Session::isSuperAdminProfile(), 1 );
            
            if( isset($arrModule[$num]->{'_submodules'}) && !empty($arrModule[$num]->{'_submodules'}) )
            {
                foreach( $arrModule[$num]->{'_submodules'} as $num2 => $submodule )
                {
                    $arrModule[$num]->{'_submodules'}[$num2]->{'_permissions'} = $mPermission->listByModule( $submodule->id );
                }
            }
        }
        
        return $arrModule;
    }
}
