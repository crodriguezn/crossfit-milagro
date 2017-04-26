<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Rol
{
    static public function loadRol( $id_rol )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mRol Rol_Model */
        $mRol =& $MY->mRol;
        
        /* @var $eRol eRol  */
        $eRol = $mRol->load( $id_rol );
        
        $oBus->isSuccess( !$eRol->isEmpty() );
        $oBus->data(array(
            'eRol' => $eRol
        ));
        
        return $oBus;
    }
    
    static public function listRol($txt_filter, $limit, $offset)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mRol Rol_Model */
        $mRol =& $MY->mRol;
        
        $eRols = array();
        $count = 0;
        try
        {
            $filter = new filterRol();
            
            $filter->limit = $limit;
            $filter->offset = $offset;
            $filter->text = $txt_filter;
            $filter->isEditable = Helper_App_Session::isSuperAdminProfile() ? NULL : 1;
        
            $mRol->filter($filter, $eRols/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eRols' => $eRols,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    
    static public function saveRolModule( eRol $eRol, $eRolesModules)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mRol Rol_Model */
        $mRol =& $MY->mRol;
        
        /* @var $mRolModule Rol_Module_Model */
        $mRolModule =& $MY->mRolModule;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            $isEditable = TRUE;
           
            if( !$eRol->isEmpty() )
            {
                $eRolT = $mRol->load( $eRol->id );
                
                if( !Helper_App_Session::isSuperAdminProfile())
                {
                    if( $eRolT->isEditable == 0 )
                    {
                        throw new Exception("Prohibido editar éste Rol");
                    }
                }
                
                $isEditable = $eRolT->isEditable == 1;
                
            }
            
            if( $isEditable )
            {
                $mRol->save($eRol);
            }
            
            $mRolModule->deleteByRol($eRol->id);
            if( !empty($eRolesModules) )
            {
                /* @var $eRolModule eRolModule */
                foreach( $eRolesModules as $eRolModule )
                {
                    $eRolModule->id_rol = $eRol->id; 
                    $mRolModule->save($eRolModule);
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
    
    static public function listRolesAndModulesAByRol( $id_rol )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mRolModule Rol_Module_Model */
        $mRolModule =& $MY->mRolModule;
        
        $eRolesModules = array();
        try
        {
           
            $eRolesModules = $mRolModule->listRolesAndModulesByRol($id_rol);
                    
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eRolesModules'  => $eRolesModules
        ));
        
        return $oBus;
    }
    
}