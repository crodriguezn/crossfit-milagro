<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Database
{
    const DB_DEFAULT = 0;
    
    static public function backup( $DB_TYPE, $readfile = false )
    {

        $MY =& MY_Controller::get_instance();
        
        $db = NULL;
        switch( $DB_TYPE )
        {
            case self::DB_DEFAULT:
                $db =& $MY->db;
                break;
        }
        
        $folder = BASEPATH . '..\application\logs\db_backup\\'.( date('Y') ).'\\'.( date('m') ).'\\'.( date('d') );
        if( !file_exists($folder) )
        {
            mkdir($folder, 0777, TRUE);
        }
        
        if( empty($db) ) { exit("DATABASE BACKUP: No hay seleccionado base de datos"); }
        
        if( $db->dbdriver == 'postgre' )
        {
            $db_host = preg_split('/:/', $db->hostname) ;
            $db_host = $db_host[0];
            
            //Helper_Log::write( $MY->db );
            //exit(0);
            putenv('PGHOST=' . $db_host);
            putenv('PGPORT=' . $db->port);
            putenv('PGDATABASE=' . $db->database);
            putenv('PGUSER=' . $db->username);
            putenv("PGPASSWORD=" . $db->password);
            $file_name_output = ( $db->database )."-".( date("Y.m.d_H.i.s") );
            exec("\"".( $db->bin_dump )."\" --inserts -i > \"$folder\\".( $file_name_output ).".sql\"");
            if($readfile)
            {
                if (is_file("$folder\\".$file_name_output.'.sql'))
                {
                    $size = filesize("$folder\\".$file_name_output.'.sql');
                    if (function_exists('mime_content_type'))
                    {
                        $type = mime_content_type("$folder\\".$file_name_output.'.sql');
                    } 
                    elseif (function_exists('finfo_file'))
                    {
                        $info = finfo_open(FILEINFO_MIME);
                        $type = finfo_file($info, "$folder\\".$file_name_output.'.sql');
                        finfo_close($info);
                    }
                    if ($type == '')
                    {
                        $type = "application/force-download";
                    }
                    ob_clean();
                    header("Content-Type: $type");
                    header("Content-Disposition: attachment; filename=$file_name_output.sql");
                    header("Content-Transfer-Encoding: binary");
                    header("Content-Length: " . $size);
                    readfile("$folder\\".$file_name_output.'.sql');
                } 
                else
                {
                    die("El archivo no existe.");
                }
            }
        }
    }
}