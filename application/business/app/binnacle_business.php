<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Binnacle
{
    static public function loadBinnacle( $id_binnacle )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mUserLog User_Log_Model */
        $mUserLog =& $MY->mUserLog;
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        /* @var $eUserLog eUserLog  */
        $eUserLog = $mUserLog->load( $id_binnacle );
        
        /* @var $eUserLog eUserLog  */
        $eUser = $mUser->load( $eUserLog->id_user );
        
        $oBus->isSuccess( !$eUserLog->isEmpty() );
        $oBus->data(array(
            'eUserLog'  => $eUserLog,
            'eUser'     => $eUser
        ));
        
        return $oBus;
    }
    
    static public function listBinnacle( $txt_filter, $limit, $offset, $arrTxtAction, $dateBegin, $dateEnd )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mUserLog User_Log_Model */
        $mUserLog =& $MY->mUserLog;
        
        $eUsers = array();
        $eUserLogs = array();
        $count = 0;
        try
        {
            $filter = new filterUserLog();
            
            $filter->limit      = $limit;
            $filter->offset     = $offset;
            $filter->text       = $txt_filter;
            $filter->action     = $arrTxtAction;
            $filter->date_begin = $dateBegin;
            $filter->date_end   = $dateEnd;
            
            $mUserLog->filter($filter, $eUserLogs/*REF*/, $eUsers/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eUserLogs' => $eUserLogs,
            'eUsers'    => $eUsers,
            'count'     => $count
        ));
        
        return $oBus;
    }
    
}