<?php

class PHP_JasperStarter
{
    protected $jasperstarter_file_jar;
    protected $path_folder_output;
    
    protected $path_java_bin;
    
    protected $db_type;
    protected $db_host;
    protected $db_port;
    protected $db_name;
    protected $db_user;
    protected $db_pass;
    protected $db_driver;
    protected $db_url;
    
    protected $jdbc_dir;
    
    protected $data_file;
    protected $xml_xpath;
    
    public function __construct()
    {
        $this->jasperstarter_file_jar = dirname(__FILE__)."/../lib/jasperstarter.jar";
        $this->path_folder_output = dirname(__FILE__).'/../output';
        $this->path_java_bin = '';
        
        $this->clearConnection();
    }
    
    public function clearConnection()
    {
        $this->db_type   = '';
        $this->db_host   = '';
        $this->db_port   = '';
        $this->db_name   = '';
        $this->db_user   = '';
        $this->db_pass   = '';
        $this->db_driver = '';
        $this->db_url    = '';
        $this->data_file = '';
        $this->xml_xpath = '';
    }
    
    public function dbConnection($db_host, $db_name, $db_user, $db_pass, $db_port='', $db_type='mysql')
    {
        $this->db_type   = $db_type;
        $this->db_host   = $db_host;
        $this->db_port   = $db_port;
        $this->db_name   = $db_name;
        $this->db_user   = $db_user;
        $this->db_pass   = $db_pass;
        $this->db_driver = ''; // 
        $this->db_url    = '';
        $this->data_file = '';
        $this->xml_xpath = '';
        $this->jdbc_dir  = '';
    }
    
    public function dbGeneric($db_driver, $db_url, $db_user, $db_pass, $jdbc_dir="")
    {
        $this->db_type   = 'generic';
        $this->db_host   = '';
        $this->db_port   = '';
        $this->db_name   = '';
        $this->db_user   = $db_user;
        $this->db_pass   = $db_pass;
        $this->db_driver = $db_driver;
        $this->db_url    = $db_url;
        $this->data_file = '';
        $this->xml_xpath = '';
        $this->jdbc_dir = $jdbc_dir;
    }
    
    public function dbXML( $data_file, $xml_xpath )
    {
        $this->db_type   = 'xml';
        $this->db_host   = '';
        $this->db_port   = '';
        $this->db_name   = '';
        $this->db_user   = '';
        $this->db_pass   = '';
        $this->db_driver = '';
        $this->db_url    = '';
        $this->data_file = $data_file;
        $this->xml_xpath = $xml_xpath;
        $this->jdbc_dir = '';
    }
    
    public function setJarJasperStarter( $jasperstarter_file_jar )
    {
        $this->jasperstarter_file_jar = $jasperstarter_file_jar;
    }
    
    public function setPathJavaBin( $path_java_bin )
    {
        $this->path_java_bin = $path_java_bin;
    }
    
    public function setPathFolderOutput( $path_folder_output )
    {
        $this->path_folder_output = $path_folder_output;
    }
    
    //**************************************************************************************************************
    //**************************************************************************************************************
    
    /*
     * $type_report: view,print,jrprint,pdf,rtf,docx,odt,html,xml,xls,xlsx,csv,ods,pptx,xhtml
     */
    public function buildReport( $path_file_jasper, $file_name_output, $arrParameter=array(), $type_report='pdf' )
    {
        $file_output = $this->path_folder_output . '/' . $file_name_output;

        //************************************************************************************
        //************************************************************************************
        
        $cmd_java = ( empty($this->path_java_bin) ? "java" : "\"".$this->path_java_bin."\"" ) . " -Djava.awt.headless=true -jar \"".( $this->jasperstarter_file_jar )."\"";
        
        $cmd_driver = "-t \"".( $this->db_type )."\"";
        if( !empty($this->db_type) )
        {
            $cmd_driver_pass =  empty($this->db_pass) ? '' : "-p \"".( $this->db_pass )."\"";
            
            if( strcmp($this->db_type, 'generic') == 0 )
            {
                $cmd_driver .= " --db-driver \"".( $this->db_driver )."\" --db-url \"".( $this->db_url )."\" -u \"".( $this->db_user )."\" $cmd_driver_pass";
            }
            else if( strcmp($this->db_type, 'xml') == 0 )
            {
                $cmd_driver .= " --data-file \"".( $this->data_file )."\" --xml-xpath \"".( $this->xml_xpath )."\" ";
            }
            else
            {
                $cmd_driver .= " -H ".( $this->db_host )." -n ".( $this->db_name )." -u ".( $this->db_user )." $cmd_driver_pass";
                
                if( !empty($this->db_port) )
                {
                    $cmd_driver .= " --db-port \"".( $this->db_port )."\"";
                }
            }
        }
        
        if( !empty($this->jdbc_dir) )
        {
            $cmd_driver .= " --jdbc-dir \"".( $this->jdbc_dir )."\"";
        }
        
        $cmd_params = '';
        if( !empty($arrParameter) )
        {
            foreach( $arrParameter as $parameter => $value )
            {
                $cmd_params .= ( empty($cmd_params) ? '' : ' ' ) . "$parameter=\"$value\"";
            }
        }
        
        if( !empty($cmd_params) ){ $cmd_params = "-P $cmd_params"; }
        
        // $cmd = "java -jar $path_jasper_starter pr $path_file_jasper -t mysql -u $db_user -f $type_report -H $db_host -n $db_name -o $file_output $db_pass $cmd_params";
        // $cmd = "java -jar $path_jasper_starter pr $report_jasper -t generic -f $type_report -o $file_output -u $db_user $db_pass $cmd_params --db-driver net.sourceforge.jtds.jdbc.Driver --db-url jdbc:jtds:sqlserver://127.0.0.1/ITCORP_DB_OPERACIONES";
        $cmd = "$cmd_java pr \"$path_file_jasper\" $cmd_driver $cmd_params -f $type_report -o \"$file_output\"";
        
        //Helper_Log::write($cmd);
        $res = exec("$cmd", $output/*REF*/, $err/*REF*/);
        //exec("$cmd > /dev/null &", $output, $err);
        
        $file_path = $file_output.'.'.$type_report;
        
        if( file_exists($file_path) )
        {
            chmod($file_path, 0777);
        }
        
        $oRep = new oReport();
        $oRep->isSuccess( empty($err) );
        $oRep->fileName( $file_name_output );
        $oRep->filePath( $file_output.'.'.$type_report );
        $oRep->fileExtension( $type_report );
        $oRep->cmd($cmd);
        
        return $oRep;
    }
    
    /*
     * $type_report: view,print,jrprint,pdf,rtf,docx,odt,html,xml,xls,xlsx,csv,ods,pptx,xhtml
     */
    public function downloadReport( $path_file_jasper, $file_name_output, $arrParameter=array(), $type_report='pdf' )
    {
        $oRep = $this->buildReport( $path_file_jasper, $file_name_output, $arrParameter, $type_report );
        
        //$path_file = $result['path_file'];
        if( !$oRep->isSuccess() )
        {
            header('Content-Type: text/html; charset=utf-8');
            echo "Error al ejecutar el comando:<br/>".( $oRep->cmd() );
            return;
        }
        
        $mime = get_mime_by_extension( $type_report );
        //$mime = "application/pdf";
        
        ob_clean();
        header("Content-disposition: attachment; filename=$file_name_output.$type_report");
        header("Content-type: $mime");
        readfile( $oRep->filePath() );
    }
}

class oReport
{
    protected $isSuccess;
    protected $file_name;
    protected $file_path;
    protected $file_extension;
    protected $cmd;
    
    public function __construct()
    {
        $this->isSuccess = FALSE;
        $this->file_path = '';
        $this->cmd = '';
    }
    
    public function isSuccess( $isSuccess = NULL )
    {
        if( !is_bool($isSuccess) )
        {
            return $this->isSuccess;
        }
        
        $this->isSuccess = $isSuccess;
    }
    
    public function fileName( $file_name = NULL )
    {
        if( !is_string($file_name) )
        {
            return $this->file_name;
        }
            
        $this->file_name = $file_name;
    }
    
    public function filePath( $file_path = NULL )
    {
        if( !is_string($file_path) )
        {
            return $this->file_path;
        }
            
        $this->file_path = $file_path;
    }
    
    public function fileExtension( $file_extension = NULL )
    {
        if( !is_string($file_extension) )
        {
            return $this->file_extension;
        }
            
        $this->file_extension = $file_extension;
    }
    
    public function cmd( $cmd = NULL )
    {
        if( !is_string($cmd) )
        {
            return $this->cmd;
        }
            
        $this->cmd = $cmd;
    }
}