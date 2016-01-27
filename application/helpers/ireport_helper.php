<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_iReport
{
    /*
     * $type_report: view,print,jrprint,pdf,rtf,docx,odt,html,xml,xls,xlsx,csv,ods,pptx,xhtml
     */
    static public function buildReport( $name_file_jasper, $arrParameter=array(), $type_report='pdf' )
    {
        $MY =& MY_Controller::get_instance();
        
        $java = Helper_Config::getBinaryJava();
        
        $path_jasper_starter = BASEPATH . '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'third_party' . DIRECTORY_SEPARATOR . 'jasperstarter' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'jasperstarter.jar';
        $report_jasper = BASEPATH . '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . $name_file_jasper.".jasper";
        $nombre_temp = preg_split("/[\/]+/", $name_file_jasper); 
        $nombre_jasper = $nombre_temp[ sizeof($nombre_temp) - 1 ];
        //Helper_Log::write($nombre_jasper);
        $file_output = BASEPATH . '..' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . ( $nombre_jasper . microtime(true) );
        
        //$db_host = $MY->db->hostname;
        $db_host = preg_split('/:/', $MY->db->hostname) ;
        $db_host = $db_host[0];
        $db_name = $MY->db->database;
        $db_user = $MY->db->username;
        $db_pass = $MY->db->password;
        $db_port = $MY->db->port;
        
        // ------------------------------------------------------
        // DEFAULT, deben tener todos los reportes --------------
        // ------------------------------------------------------
        $arrParameter['ci_root_path']  = BASEPATH.'../';
        // ------------------------------------------------------
        // ------------------------------------------------------
        
        $str_parametros = '';
        if( !empty($arrParameter) )
        {
            foreach( $arrParameter as $parameter => $value ) {
                $str_parametros .= ( empty($str_parametros) ? '' : ' ' ) . "$parameter=\"$value\"";
            }
        }
        
        if( !empty($db_pass) ){ $db_pass = "-p $db_pass"; }
        if( !empty($str_parametros) ){ $str_parametros = "-P $str_parametros"; }
        
        $cmd = "\"$java\" -Djava.awt.headless=true -jar  $path_jasper_starter pr $report_jasper -t mysql -u $db_user -f $type_report -H $db_host --db-port $db_port -n $db_name -o $file_output $db_pass $str_parametros";
        
        Helper_Log::write( $cmd );
        exec($cmd, $output, $err);
        
        if( !empty($err) ) {
            echo "Error de envio: $cmd";
            return NULL;
        }
        
        return $file_output.'.'.$type_report;
    }
    
    /*
     * $type_report: view,print,jrprint,pdf,rtf,docx,odt,html,xml,xls,xlsx,csv,ods,pptx,xhtml
     */
    static public function downloadReport( $name_file_jasper, $arrParameter=array(), $name_pdf_output='file', $type_report='pdf' )
    {
        $file_output = self::buildReport( $name_file_jasper, $arrParameter, $type_report );
        
        if( empty($file_output) ) {
            echo "Error al Generar PDF";
            exit();
        }
        
        ob_clean();
        
        $mime = get_mime_by_extension( $type_report );
        
        header("Content-disposition: attachment; filename=$name_pdf_output.$type_report");
        header("Content-type: $mime");
        readfile("$file_output");
    }
}