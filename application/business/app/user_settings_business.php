<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_User_Settings
{
    static public function listAcounts($txt_filter, $limit, $offset)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        $eUsers = array();
        $ePersons = array();
        $count = 0;
        try
        {
            $filter = new filterUser();
            
            $filter->limit = $limit;
            $filter->offset = $offset;
            $filter->text = $txt_filter;
            $filter->id_company_branch = ( Helper_App_Session::isSuperAdminProfile() || Helper_App_Session::isAdminProfile() )? NULL : Helper_App_Session::getCompanyBranchId();
        
            $mUser->filter($filter, $eUsers/*REF*/, $ePersons/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eUsers' => $eUsers,
            'ePersons' => $ePersons,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    static public function listCompanyBranchsByUserProfile( $id_user, $id_profile)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mUserProfileCompanyBranch User_Profile_Company_Branch_Model */
        $mUserProfileCompanyBranch =& $MY->mUserProfileCompanyBranch;
        
        $eCompanyBranchs = $mUserProfileCompanyBranch->listCompanyBranchsByUserProfile($id_user, $id_profile);
        
        $oBus->isSuccess( !empty($eCompanyBranchs) );
        $oBus->message( empty($eCompanyBranchs) ? 'Usuario no tiene asociado ninguna Sede.' : '' );
        $oBus->data(array(
            'eCompanyBranchs' => $eCompanyBranchs
        ));
        
        return $oBus;
    }
    
    static public function saveAcount(ePerson $ePerson, eUser $eUser, eUserProfile $eUserProfile, $eUserProfile_CompanyBranches)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mPerson Person_Model */
        $mPerson =& $MY->mPerson;
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        /* @var $mUserProfile User_Profile_Model */
        $mUserProfile =& $MY->mUserProfile;
        
        /* @var $mUserProfileCompanyBranch User_Profile_Company_Branch_Model */
        $mUserProfileCompanyBranch =& $MY->mUserProfileCompanyBranch;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            if(!Helper_App_Session::isAdminProfile() || !Helper_App_Session::isSuperAdminProfile())
            {
                if(Business_App_Person::isValidDocument($ePerson->document))
                {
                    throw new Exception('Documento Invalido, No permitido');
                }
            }
            $ePersonT = $mPerson->loadByDocument($ePerson->document, $ePerson->id );
            
            if( !$ePersonT->isEmpty() )
            {
                throw new Exception('Persona Existente');
            }
            
            $eUserT = $mUser->load($eUser->username, 'username', $eUser->id);
            
            if( !$eUserT->isEmpty() )
            {
                throw new Exception('Usuario Existente');
            }
            
            $mPerson->save($ePerson);
            $mUser->save($eUser);
            
            $eUserProfileT = $mUserProfile->loadArray(array('id_user'=>$eUser->id, 'id_profile'=>$eUserProfile->id_profile));
            $eUserProfile->id_user = $eUser->id;
            $eUserProfile->id = $eUserProfileT->id;
            
            $mUserProfile->save($eUserProfile);
            
            $mUserProfileCompanyBranch->deleteByUserProfile($eUserProfile->id);
            
            if( !empty($eUserProfile_CompanyBranches) )
            {
                /* @var $eUserProfileCompanyBranch eUserProfileCompanyBranch */
                foreach( $eUserProfile_CompanyBranches as $eUserProfileCompanyBranch )
                {
                    $eUserProfileCompanyBranch->id_user_profile = $eUserProfile->id; 
                    $mUserProfileCompanyBranch->save($eUserProfileCompanyBranch);
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
