<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_User
{
    
    static public function login($username, $password)
    {
        $MY =& MY_Controller::get_instance();
        
        $oBus = new Response_Business();
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        /* @var $mUserProfile User_Profile_Model */
        $mUserProfile =& $MY->mUserProfile;
        
        try
        {
            $eUser = $mUser->login($username, $password);
            
            if( $eUser->isEmpty() )
            {
                throw new Exception("Usuario y/o Contraseña invalido");
            }
                   
            $eProfiles = $mUserProfile->listProfilesByUser($eUser->id, 1);
            
            if(empty($eProfiles))
            {
                throw new Exception("Usuario y/o Contraseña invalido");
            }
            
            $oBus->isSuccess(TRUE);
            
            $oBus->data(array('eUser' => $eUser));
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            
            $oBus->message( $e->getMessage() );
        }
        
        return $oBus;
    }
    
    static public function checkPassword( $id_user, $password )
    {
        $MY =& MY_Controller::get_instance();
        
        $oBus = new Response_Business();
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        $isValid = FALSE;
        try
        {
            $isValid = $mUser->checkPassword( $id_user, $password );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $exc )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $exc->getMessage() );
        }

        $oBus->data(array('isValid' => $isValid));
        
        return $oBus;
    }
    
    static public function updatePassword( $id_user, $password )
    {
        $MY =& MY_Controller::get_instance();
        
        $oBus = new Response_Business();
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        /* @var $mPerson Person_Model */
        $mPerson =& $MY->mPerson;
        
        $changed = FALSE;
        try
        {
            $eUser = $mUser->load($id_user, 'id');
            
            $ePerson = $mPerson->load( $eUser->id_person, 'id' );
            
            $mUser->updatePassword($id_user, $password);
            
            $changed = TRUE;
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array('changed'=>$changed));
        
        return $oBus;
    }
    
    static public function loadUser( $id_user )
    {
        $MY =& MY_Controller::get_instance();
        
        $oBus = new Response_Business();
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        try
        {
            /* @var $eUser eUser  */
            $eUser = $mUser->load($id_user);
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array(
            'eUser' => $eUser
        ));
        
        return $oBus;
        
        
    }
    
    static public function loadUserByIdPerson( $id_person )
    {
        $MY =& MY_Controller::get_instance();
        
        $oBus = new Response_Business();
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        try
        {
            /* @var $eUser eUser  */
            $eUser = $mUser->load($id_person, 'id_person');
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array(
            'eUser' => $eUser
        ));
        
        return $oBus;
        
        
    }
    
}