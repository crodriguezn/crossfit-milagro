<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_LogX extends MY_Controller
{
    protected $name_key = 'system_log';
    
    /* @var $permission System_Log_Permission */
    protected $permission;

    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        $this->load->file('application/modules/app/system/log/permission.php');
        $this->permission = new System_Log_Permission( $this->name_key );
    }
    
    public function process( $action )
    {
        if( !Helper_App_Session::isLogin() )
        {
            $this->noaction('Fuera de sesión');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->noaction('Fuera de sesión por Inactividad');
            return;
        }
        
        if( Helper_App_Session::isBlock() )
        {
            $this->noaction('Fuera de session por Bloqueo');
            return;
        }
        
        if( !$this->permission->access )
        {
            $this->noaction('Acceso no permitido');
            return;
        }

        switch( $action )
        {
            case 'list-file':
                $this->listFile();
                break;
            case 'load-file':
                $this->loadFile();
                break;
            case 'load-file-t':
                $this->loadFileT();
                break;
            default:
                $this->noaction($action);
                break;
        }
    }
    
    private function noaction($action)
    {
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess(FALSE);
        $resAjax->message("No found action: $action");
        
        echo $resAjax->toJsonEncode();
    }
    
    private function listFile()
    {
        $html = '';
        $dir = $this->input->post('dir');
        $root = BASEPATH."../application/logs".( empty($dir)?'/':"/$dir" );
        $path = $root;
        if( file_exists( $path ) ) 
        {
            $files = scandir($path);
            natcasesort($files);
            if( count($files) > 2 ) /* The 2 accounts for . and .. */
            { 
                $html.= "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
                // All dirs
		foreach( $files as $file )
                {
                    if( file_exists( $path . $file ) && $file != '.' && $file != '..' && is_dir( $path . $file ) ) 
                    {
                            $html.= "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities( $dir . $file ) . "/\">" . htmlentities($file) . "</a></li>";
                    }
		}
                // All files
		foreach( $files as $file )
                {
                    if( file_exists( $path . $file ) && $file != '.' && $file != '..' && !is_dir( $path . $file ) ) 
                    {
                        $ext = preg_replace('/^.*\./', '', $file);
                        $html.= "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities( $dir . $file ) . "\">" . htmlentities( $file ) . "</a></li>";
                    }
		}
                $html.= "</ul>";
            }
        }
        echo $html;
    }     
    
    private function loadFile()
    {
        $texto = '';
        $dir = $this->input->post('path');
        $root = BASEPATH."../application/logs".( empty($dir)?'/':"/$dir" );
        $path = $root;
        $resAjax = new Response_Ajax();
        if( file_exists( $path ) && $dir != '.' && $dir != '..' && !is_dir( $path ) ) 
        {
            //$fp = fopen( $path,'r' );
            //leemos el archivo
            //$texto = fread($fp, filesize($path));
            
            
            //$texto = file_get_contents($path);
            //print_r($texto);
            $name = basename($path);
            $size = filesize($path); /*bytes*/
            $size_file = Helper_File::round_size($size, 2);
            //transformamos los saltos de linea en etiquetas <br>
            //$texto = nl2br($texto);
            /*$search  = array("\r\n", "\r", "\n", " ");
            $replace = array("<br/>", "<br/>", "<br/>", "&nbsp;");
            $texto = str_replace($search, $replace, $texto);*/
            $resAjax->isSuccess(TRUE);
            $resAjax->message( '' );
        }
        else 
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message( 'Error de Archivo' );
        }
        
        $resAjax->form('file', array('name'=>$name, 'path'=>$dir, 'size'=>$size_file));
        echo $resAjax->toJsonEncode();
    }
    
    private function loadFileT()
    {
        $texto = '';
        $dir = $this->input->post('path');
        $root = BASEPATH."../application/logs".( empty($dir)?'/':"/$dir" );
        $path = $root;
        $return = NULL;
        if( file_exists( $path ) && $dir != '.' && $dir != '..' && !is_dir( $path ) ) 
        {
            //$fp = fopen( $path,'r' );
            
            $texto = file_get_contents($path);
            
            $return = print_r($texto, TRUE);
        }
        else 
        {
            $return = 'error';
        }
        
        echo $return;
    }
    
}