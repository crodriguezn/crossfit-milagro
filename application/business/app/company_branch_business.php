<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Company_Branch
{
    static public function listCompanyBranch($id_company)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCompanyBranch Company_Branch_Model */
        $mCompanyBranch =& $MY->mCompanyBranch;
       
        $filter = new filterCompanyBranch();
        $filter->id_company = $id_company;
        
        $eCompanyBranches = array();
        try
        {
            $mCompanyBranch->filter($filter, $eCompanyBranches/*REF*/);
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data('eCompanyBranches', $eCompanyBranches);
        
        return $oBus;
    }
    
    static public function filterCompanyBranch($id_company, $text, $limit, $offset)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCompanyBranch Company_Branch_Model */
        $mCompanyBranch =& $MY->mCompanyBranch;
       
        $filter = new filterCompanyBranch();
        $filter->id_company = $id_company;
        $filter->text = $text;
        $filter->limit = $limit;
        $filter->offset = $offset;
        
        $eCompanyBranches = array();
        $count = 0;
        try
        {
            $mCompanyBranch->filter($filter, $eCompanyBranches/*REF*/, $count/*REF*/);
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        $oBus->data(array(
            'eCompanyBranches' => $eCompanyBranches,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    static public function loadCompanyBranch( $id_company_branch)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCompanyBranch Company_Branch_Model */
        $mCompanyBranch =& $MY->mCompanyBranch;
        
        $eCompanyBranch = new eCompanyBranch();
        try
        {
            $eCompanyBranch = $mCompanyBranch->load($id_company_branch);
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $exc )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $exc->getMessage() );
        }
        
        $oBus->data(array('eCompanyBranch' => $eCompanyBranch));
        
        return $oBus;
    }
    
    static public function saveCompanyBranch(eCompanyBranch $eCompanyBranch)
    {
        $oBus = new Response_Business();
        $MY = & MY_Controller::get_instance();
        
        /* @var $mCompanyBranch Company_Branch_Model */
        $mCompanyBranch = & $MY->mCompanyBranch;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try 
        {
            $mCompanyBranch->save($eCompanyBranch);
            
            $oBus->isSuccess(TRUE);
            
            $oBus->message("Guardado exitosamente");
            
            $oTransaction->commit();
            
        } 
        catch (Exception $e)
        {
            $oTransaction->rollback();
            $oBus->isSuccess(FALSE);
            $oBus->message($e->getMessage());
        }
        return $oBus;
    }
    
    static public function listSedes($txt_filter, $limit, $offset, $isActive)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCompanyBranch Company_Branch_Model */        
        $mCompanyBranch =& $MY->mCompanyBranch;        
        
        $eCompanyBranch = $mCompanyBranch->listAll( $txt_filter, $limit, $offset, $isActive);
        $count = $mCompanyBranch->countAll( $txt_filter, $isActive);
        
        $oBus->isSuccess(TRUE);
        $oBus->data(array(
            'eCompanyBranch' => $eCompanyBranch,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    static public function listByCompany( $id_company, $isActive = NULL )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCompanyBranch Company_Branch_Model */
        $mCompanyBranch =& $MY->mCompanyBranch;
        
        $eCompanyBranchs = $mCompanyBranch->listByCompany($id_company, $isActive);
        
        $oBus->isSuccess( !empty($eCompanyBranchs) );
        $oBus->message( empty($eCompanyBranchs) ? 'Usuario no tiene asociado ninguna Sede.' : '' );
        $oBus->data(array(
            'eCompanyBranchs' => $eCompanyBranchs
        ));
        
        return $oBus;
    }
    
    static public function listByUserProfile( $id_user, $id_profile )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCompanyBranch Company_Branch_Model */
        $mCompanyBranch =& $MY->mCompanyBranch;
        
        $eCompanyBranchs = $mCompanyBranch->listByUserProfile($id_user, $id_profile);
        
        $oBus->isSuccess( !empty($eCompanyBranchs) );
        $oBus->message( empty($eCompanyBranchs) ? 'Usuario no tiene asociado ninguna Sede.' : '' );
        $oBus->data(array(
            'eCompanyBranchs' => $eCompanyBranchs
        ));
        
        return $oBus;
    }
}