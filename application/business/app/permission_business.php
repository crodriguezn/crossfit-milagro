<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Permission
{
    static public function loadPermission( $id_permission )
    {
        
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mPermission Permission_Model */
        $mPermission =& $MY->mPermission;
        
        /* @var $ePermission ePermission */
        $ePermission = $mPermission->load( $id_permission );
        
        $oBus->isSuccess( !$ePermission->isEmpty() );
        $oBus->data(array(
            'ePermission' => $ePermission
        ));
        
        return $oBus;
    }
    
    static public function listPermission($txt_filter, $limit, $offset)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mPermission Permission_Model */
        $mPermission =& $MY->mPermission;
        
        $ePermissions = array();
        $count = 0;
        try
        {
            $filter = new filterPermission();
            
            $filter->limit = $limit;
            $filter->offset = $offset;
            $filter->text = $txt_filter;
        
            $mPermission->filter($filter, $ePermissions/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'ePermissions' => $ePermissions,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    
    static public function savePermission(ePermission $ePermission)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mPermission Permission_Model */
        $mPermission =& $MY->mPermission;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        try
        {
            
            $mPermission->save($ePermission);
            
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