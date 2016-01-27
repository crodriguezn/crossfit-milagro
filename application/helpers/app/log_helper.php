<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_App_Log
{
    const LOG_DEFAULT   = 0;
    const LOG_LOGIN     = 1;
    const LOG_INSERT    = 2;
    const LOG_UPDATE    = 3;
    const LOG_DELETE    = 4;
    
    
    static public function write( $var, $isEncode = FALSE , $LOG_TYPE = self::LOG_DEFAULT )
    {
        $MY =& MY_Controller::get_instance();
        
        /* @var $mUserLog User_Log_Model */
        $mUserLog =& $MY->mUserLog;
        
        /* @var $mConfigurationSystem Configuration_System_Model */
        $mConfigurationSystem =& $MY->mConfigurationSystem;
        
        $id_system = Helper_App_Session::getConfigurationSystemId();
            
        // *******************
        // CONFIGURATION SYSTEM
        // *******************

        $eConfigurationSystem = $mConfigurationSystem->load($id_system);
        
        $id_user = Helper_App_Session::getUserId();
        $navegador = Helper_App_Browser::getBrowser();
        $action = '';
        
        if( $LOG_TYPE == self::LOG_DEFAULT )    { $action = 'ACTION_DEFAULT'; }
        if( $LOG_TYPE == self::LOG_LOGIN )      { $action = 'ACTION_LOGIN'; }
        if( $LOG_TYPE == self::LOG_INSERT )     { $action = 'ACTION_INSERT'; }
        if( $LOG_TYPE == self::LOG_UPDATE )     { $action = 'ACTION_UPDATE'; }
        if( $LOG_TYPE == self::LOG_DELETE )     { $action = 'ACTION_DELETE'; }
        
        Helper_Log::write( print_r( $var, true ), Helper_Log::LOG_APP );
        
        if(!empty($eConfigurationSystem->isSaveBinnacle))
        {
            if( !empty( $id_user ) )
            {

                $eUserLog               = new eUserLog();
                $eUserLog->id_user      = $id_user;
                $eUserLog->date_time    = date('Y-m-d H:i:s');
                $eUserLog->info         = ($isEncode) ? json_encode( $var ) : $var;
                $eUserLog->action       = $action;
                $eUserLog->url          = current_url();
                $eUserLog->browser      = ($navegador->browser.' '.$navegador->device_type.' '.$navegador->platform_maker.' '.$navegador->platform_description.' de '.$navegador->platform_bits);
                $eUserLog->ip           = $MY->input->ip_address();

                $mUserLog->save($eUserLog);

            }
        }
        
    }
}