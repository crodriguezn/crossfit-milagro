<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Profile
{
    static public function loadProfile( $id_profile )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mProfile Profile_Model */
        $mProfile =& $MY->mProfile;
        
        /* @var $eProfile eProfile  */
        $eProfile = $mProfile->load( $id_profile );
        
        $oBus->isSuccess( !$eProfile->isEmpty() );
        $oBus->data(array(
            'eProfile' => $eProfile
        ));
        
        return $oBus;
    }
    
    static public function listProfile($txt_filter, $limit, $offset)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mProfile Profile_Model */
        $mProfile =& $MY->mProfile;
        
        $eProfiles = array();
        $eRoles = array();
        $count = 0;
        try
        {
            $filter = new filterProfile();
            
            $filter->limit = $limit;
            $filter->offset = $offset;
            $filter->text = $txt_filter;
            $filter->isActive = NULL;
            $filter->withSuperAdmin = Helper_App_Session::isSuperAdminProfile();
            $filter->withAdmin = Helper_App_Session::isAdminProfile();
            $filter->isEditable = Helper_App_Session::isSuperAdminProfile() ? NULL : 1;
        
            $mProfile->filter($filter, $eProfiles/*REF*/, $eRoles/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eProfiles' => $eProfiles,
            'eRoles' => $eRoles,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    
    static public function saveProfile( eProfile $eProfile )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mProfile Profile_Model */
        $mProfile =& $MY->mProfile;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {

            $isEditable = TRUE;
            if( !$eProfile->isEmpty() )
            {
                $eProfileT = $mProfile->load( $eProfile->id );
                
                if( !Helper_App_Session::isSuperAdminProfile())
                {
                    if( $eProfileT->isSuperAdmin == 1 || $eProfileT->isAdmin == 1 )
                    {
                        throw new Exception("Prohibido editar éste perfil");
                    }
                    $isEditable = $eProfileT->isEditable == 1;
                }
                
                $eProfile->isSuperAdmin = $eProfileT->isSuperAdmin;
                $eProfile->isAdmin      = $eProfileT->isAdmin;
                $eProfile->isEditable      = $eProfileT->isEditable;
                
            }
            
            if( $isEditable )
            {
                $mProfile->save($eProfile);
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
    
    static public function saveProfilePermission( $id_profile, $arr_eProfilePermissions )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mProfilePermission Profile_Permission_Model */
        $mProfilePermission =& $MY->mProfilePermission;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            
            $mProfilePermission->deleteByProfile($id_profile);
            
            /* @var $eProfilePermission eProfilePermission*/
            foreach( $arr_eProfilePermissions as $eProfilePermission )
            {
                if( !empty($eProfilePermission->id_permission) ) 
                {
                    $mProfilePermission->save($eProfilePermission);
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