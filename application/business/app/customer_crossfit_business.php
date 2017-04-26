<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Customer_Crossfit
{
    static public function listCustomerCrossfit($txt_filter, $limit, $offset)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCustomer Customer_Model */
        $mCustomer =& $MY->mCustomer;
        
        $eCustomers = array();
        $ePersons   = array();
        $eCiudades  = array(); 
        $count = 0;
        try
        {
            $filter = new filterCustomer();
            
            $filter->limit = $limit;
            $filter->offset = $offset;
            $filter->text = $txt_filter;
        
            $mCustomer->filter($filter, $eCustomers/*REF*/, $ePersons/*REF*/, $eCiudades/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eCustomers'    => $eCustomers,
            'ePersons'      => $ePersons,
            'eCiudades'     => $eCiudades,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    static public function loadCustomer( $id_customer )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mCustomer Customer_Model */
        $mCustomer =& $MY->mCustomer;
        
        $eCustomer = new eCustomer();
        try
        {
            /* @var $eCustomer eCustomer  */
            $eCustomer = $mCustomer->load($id_customer);
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array(
            'eCustomer' => $eCustomer
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
    
    static public function saveCustomer(eCustomer $eCustomer, ePerson $ePerson, eUser $eUser, eUserProfile $eUserProfile, $eUserProfile_CompanyBranches)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCustomer Customer_Model */
        $mCustomer =& $MY->mCustomer;
        
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
                if(!Business_App_Person::isValidDocument($ePerson->document))
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
            
            if(empty($eUser->id))
            {
                $eUser->username =  $ePerson->document;
                $eUser->password = md5($ePerson->document);
            }
            
            $mPerson->save($ePerson);
            $eUser->id_person = $ePerson->id;
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
            
            $eCustomerT = $mCustomer->load($ePerson->id, 'id_person', $eCustomer->id);
            
            if( !$eCustomerT->isEmpty() )
            {
                throw new Exception('Cliente Crossfitero Existente!');
            }
            
            $eCustomer->id_person = $ePerson->id;
            $eCustomer->registration_date = empty($eCustomer->id) ? date('Y-m-d H:i:s') : $eCustomer->registration_date;
            $mCustomer->save($eCustomer);
            
            
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
    
    /*________________________________________________________*/
    //control imc
    static public function listControlIMC($txt_filter, $limit, $offset, $id_customer)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mControlIMC Control_IMC_Model */
        $mControlIMC =& $MY->mControlIMC;
        
        $eControlIMCs = array();
        $count = 0;
        try
        {
            $filter = new filterControlIMC();
            
            $filter->limit          = $limit;
            $filter->offset         = $offset;
            $filter->text           = $txt_filter;
            $filter->id_customer    = $id_customer;
        
            $mControlIMC->filter($filter, $eControlIMCs/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eControlIMCs'    => $eControlIMCs,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    static public function saveControlIMC(eControlIMC $eControlIMC)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mControlIMC Control_IMC_Model */
        $mControlIMC =& $MY->mControlIMC;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            $mControlIMC->save($eControlIMC);
            
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
