<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Log
{
    const LOG_DEFAULT = 0;
    const LOG_APP = 1;
    const LOG_DB = 2;
    const LOG_PROCESS = 3;
    const LOG_PUBLIC = 4;
    
    static public function write( $var, $LOG_TYPE=self::LOG_DEFAULT )
    {
        $MY =& MY_Controller::get_instance();
        
        $folder = '';
        if( $LOG_TYPE == self::LOG_DEFAULT ){  }
        if( $LOG_TYPE == self::LOG_APP ){ $folder = 'app'; }
        if( $LOG_TYPE == self::LOG_DB ){ $folder = 'db'; }
        if( $LOG_TYPE == self::LOG_PROCESS ){ $folder = 'process'; }
        if( $LOG_TYPE == self::LOG_PUBLIC ){ $folder = 'public'; }
        
        $path = BASEPATH."../application/logs".( empty($folder)?'':"/$folder" )."/";

        if( !file_exists($path) )
        {
                mkdir($path, 0777);
        }
	
        if( is_array($var) || is_object($var) )
        {
            $var = print_r($var,TRUE);
        }
        
        $path .= date('Y').'/'.date('m').'/'.date('d');
        if( !file_exists($path) )
        {
            mkdir($path, 0777, TRUE);
        }
        
        $file = $path."/".( date("H.i.s") ).'.txt';

        $template =
            "========================".date("Y-m-d H:i:s")."========================\n\n".
            $var."\n\n".
            "Desde la IP: ".$MY->input->ip_address()."\n\n".
            "=======================================================================\n\n";

        write_file( $file, $template, FOPEN_READ_WRITE_CREATE);
        chmod($file, 0777);
    }
    
    static public function getAllDirectory( $path /*$LOG_TYPE=self::LOG_DEFAULT*/ )
    {
        /*$folder = '';
        if( $LOG_TYPE == self::LOG_DEFAULT ){  }
        if( $LOG_TYPE == self::LOG_APP ){ $folder = 'app'; }
        if( $LOG_TYPE == self::LOG_DB ){ $folder = 'db'; }
        if( $LOG_TYPE == self::LOG_PROCESS ){ $folder = 'process'; }
        if( $LOG_TYPE == self::LOG_PUBLIC ){ $folder = 'public'; }
        
        $path = BASEPATH."../application/logs".( empty($folder)?'':"/$folder" )."/";
        */
        //$map = directory_map( $path, TRUE, TRUE );
        
        //Helper_Log::write($map);
        
        $map = directory_map( $path, TRUE, TRUE );
        
        return $map;
    }
    
    
    
}
