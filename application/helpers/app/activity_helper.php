<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_App_Activity
{
    /* return eSessionActivity */
    static public function get()
    {
        $MY =& MY_Controller::get_instance();
        
        /* @var $mSessionsActivity Session_Activity_Model */
        $mSessionsActivity =& $MY->mSessionsActivity;
        
        $id_user = Helper_App_Session::getUserId();
        $session_id = Helper_App_Session::getSessionID();
        /* @var $eSessionActivity eSessionActivity */
        $eSessionActivity = $mSessionsActivity->loadArray(['id_user' => $id_user, 'inUse' => 1,'session_id' => $session_id]);
        
        return $eSessionActivity;
    }
    
    static public function set( $eSessionActivity/*REF*/ )
    {
        $MY =& MY_Controller::get_instance();
        
        /* @var $mSessionsActivity Session_Activity_Model */
        $mSessionsActivity =& $MY->mSessionsActivity;
        
        $mSessionsActivity->save($eSessionActivity);
        
    }


    /* return session_id */
    static public function getSessionId()
    {
        return self::get()->session_id;
    }
    
    /* return last_activity */
    static public function getLastActivity()
    {
        return self::get()->last_activity;
    }
    
    
    static public function logout()
    {
        $eSessionActivity = self::get();
        
        if(!$eSessionActivity->isEmpty())
        {
            $eSessionActivity->inUse = 0;
            $eSessionActivity->last_activity = date('Y-m-d H:i:s');
            self::set($eSessionActivity);
        }
    }

    static public function isLogin()
    {
        if( Helper_App_Session::isLogin())
        {
            $dateBegin = self::getLastActivity();
            $date = DateTime::createFromFormat('Y-m-d H:i:s', self::getLastActivity());
            $dateEnd = strtotime ( '+1 hour' , strtotime ( date('Y-m-d H:i:s',$date->date) ) ) ;
            $eSessionActivity = self::get();
            
            if(!$eSessionActivity->isEmpty())
            {
                Helper_Log::write($eSessionActivity);
                Helper_Log::write($dateBegin);
                Helper_Log::write($date);
                Helper_Log::write($dateEnd);
                //Helper_Log::write(date('Y-m-d H:i:s', self::getLastActivity()));
                //Helper_Log::write(DateTime::createFromFormat('Y-m-d H:i:s', self::getLastActivity()));
                /*if((self::getSessionId()==Helper_App_Session::getSessionID()) && 
                (Helper_Fecha::isValidRangeDate($dateBegin, $dateEnd, date('Y-m-d H:i:s'))) )
                {
                    $eSessionActivity->last_activity = date('Y-m-d H:i:s');
                    self::set($eSessionActivity);
                    return TRUE;
                }
                else
                {
                    $eSessionActivity->inUse = 0;
                    self::set($eSessionActivity);
                    return FALSE;
                }*/
            }
        }
        
        return FALSE;
    }

}
