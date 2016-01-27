<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ReporteX extends MY_Controller
{
    protected $name_key = 'reporte';
    
    
    function __construct()
    {
        parent::__construct(MY_Controller::SYSTEM_PUBLIC);

        
    }

    public function process($action) 
    {
        
        switch( $action )
        {
            case 'download-reports':
                $this->downloadReports();
                break;
            default:
                $this->noaction("No existe accion: $action");
                break;
        }
    }

    private function noaction($message)
    {
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess(FALSE);
        $resAjax->message($message);
        
        echo $resAjax->toJsonEncode();
    }
    
    private function downloadReports()
    {
        $resAjax = new Response_Ajax();
        $this->load->library('library_jasperstarter');

        $java_bin = Helper_Config::getBinaryJava();
        
        $this->library_jasperstarter->setPathFolderOutput( BASEPATH . '../application/temp' );
        $this->library_jasperstarter->setPathJavaBin( $java_bin );
        $this->library_jasperstarter->dbGeneric(
            'org.firebirdsql.jdbc.FBDriver',
            'jdbc:firebirdsql://localhost:3050/C:\FireBird\FTT\DIGIFORTDB.FDB',
            'SYSDBA', 'masterkey'
        );
        
        //$MY =& MY_Controller::get_instance();
        
        $date_begin = $this->input->post('date_begin');
        $date_end = $this->input->post('date_end');
        $rpte_tipo = $this->input->post('rpte_tipo');
        $rpte_grupo = $this->input->post('rpte_grupo');
        
        try 
        {
            $condicion =' AND 1=1 ';

            if($rpte_tipo=='RPTE_CAMARAS_GENERAL')
            {
                $path_file_jasper = BASEPATH . "../application/reports/camaras_general/report.jasper";
                $file_name_download = "CAMARA_EN_GENERAL";
                $file_name_output   = 'camaras_general_' . ( uniqid() );
            }
            else if($rpte_tipo=='RPTE_GRUPOS_CAMARAS')
            {
                $path_file_jasper = BASEPATH . "../application/reports/grupos_general/rpte_grupos_general.jasper";
                $file_name_download = "CAMARA_EN_GENERAL";
                $file_name_output   = 'camaras_general_' . ( uniqid() );
                //$condicion.=' AND 1=1';
                foreach ($rpte_grupo as $key => $value)
                {
                    $condicion.= "AND ( GRUPO_CAMARA = '".($value)."' )";
                }
            }
            else
            {
                throw new Exception('ERROR DE EJECCIÓN<br/> COMANDO: Tipo de reporte no encontrado');
            }
            $arrParameter = array
                (
                    'fecha_inicio' => $date_begin, 
                    'fecha_fin' => $date_end,
                    'condicion' => $condicion
                );
            
            /* @var $oReport oReport */
            $oReport = $this->library_jasperstarter->buildReport($path_file_jasper, $file_name_output, $arrParameter, 'xls');
            if( !$oReport->isSuccess() )
            {
                throw new Exception('ERROR DE EJECCIÓN<br/> COMANDO: '.$oReport->cmd());
            }
            //$data = file_get_contents( $oReport->filePath() ); // Read the file's contents
            //force_download($file_name_output, $data);

            $mime = get_mime_by_extension( $oReport->fileExtension() );
            //$mime = "application/pdf";

            ob_clean();
            header("Content-Type: application/force-download");
            //header("Content-Disposition: attachment; filename=$file_name_download.xls");
            header("Content-Transfer-Encoding: binary");
            //header("Content-Length: " . $size);
            header("Content-disposition: attachment; filename=$file_name_download.xls");
            header("Content-type: $mime");
            readfile( $oReport->filePath() );           
        } 
        catch (Exception $err)
        {
           echo $err->getMessage();
        }

        //echo $resAjax->toJsonEncode();
    }
}
