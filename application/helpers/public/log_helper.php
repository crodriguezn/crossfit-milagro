<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Public_Log
{
    static public function write( $info )
    {
        $MY =& MY_Controller::get_instance();
        //$MY->load->model('user_log_model','mUserLog');
        
        $id_personal = Helper_App_Session::getUserId();

        Helper_Log::write($info, Helper_Log::LOG_PUBLIC);
        /*if( empty($id_personal) )
        {
            
        }
        /*
        else
        {
            $MY->mUserLog->save(array(
                'id_user'   => $id_personal,
                'date_time' => date('Y-m-d H:i:s'),
                'info'      => $info
            ));
        }*/
    }
}