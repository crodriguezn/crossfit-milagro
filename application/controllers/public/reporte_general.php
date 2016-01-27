<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_General extends MY_Controller
{
    protected $name_key = 'reporte_general';
    protected $permission;
    
    function __construct()
    {
        parent::__construct( self::SYSTEM_PUBLIC );
    }

    public function index()
    {
        $dataTPrint = array(
            /*array(
                'code' => 'pdf',
                'name' => 'PDF'
            ),
            array(
                'code' => 'docx',
                'name' => 'Documento de Word'
            ),
            array(
                'code' => 'html',
                'name' => 'HTML'
            ),
            array(
                'code' => 'xml',
                'name' => 'XML'
            ),*/
            array(
                'code' => 'xls',
                'name' => 'Libro de Excel 97-2003'
            )/*,
            array(
                'code' => 'xlsx',
                'name' => 'Libro de Excel'
            ),
            array(
                'code' => 'pptx',
                'name' => 'Presentación de PowerPoint'
            )*/
        );
        $dataRpte = array(
            array(
                'code' => 'RPTE_CAMARAS_GENERAL',
                'name' => 'CAMARAS EN GENERAL'
            ),
            array(
                'code' => 'RPTE_ACCESS_TERMINAL',
                'name' => 'ACCESO AL TERMINAL'
            ),
            array(
                'code' => 'RPTE_BANIOS',
                'name' => 'BAÑOS'
            ),
            array(
                'code' => 'RPTE_PATIO_COMIDA',
                'name' => 'PATIO DE COMIDAS'
            ),
            array(
                'code' => 'RPTE_ESCALERA_ASCENSOR',
                'name' => 'ESCALERAS Y ASCENSORES'
            ),
            array(
                'code' => 'RPTE_TORNIQUETE',
                'name' => 'TORNIQUETES'
            )
        );

        $para = array(
            'cboReporte' => $dataRpte,
            'cboTPrint' => $dataTPrint
        );
        Helper_Public_View::layout('public/html/pages/reporte/general/page',$para);
    }
    
    public function mvcjs( )
    {
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx
        );
        
        Helper_Public_JS::showMVC('reporte/general', $params);
    }
    
    public function printReport( $date_begin, $date_end, $tipo_rpte, $tipo_descarga=NULL )
    {
        if(empty($tipo_descarga))
        {
            $tipo_descarga = 'xlsx';
        }
        $this->load->library('library_jasperstarter');
        
        $java_bin = Helper_Config::getBinaryJava();
        //$firebird_ftt = Helper_Config::getJasperStarterFirebirdTT();
        $postgres_ftt = Helper_Config::getJasperStarterPostgresTT();
        
        $this->library_jasperstarter->setPathFolderOutput( BASEPATH . '../application/temp' );
        $this->library_jasperstarter->setPathJavaBin( $java_bin );
        //$this->library_jasperstarter->dbGeneric( $firebird_ftt['db-driver'], $firebird_ftt['db-url'], $firebird_ftt['dbuser'], $firebird_ftt['dbpasswd']);
        $this->library_jasperstarter->dbGeneric( $postgres_ftt['db-driver'], $postgres_ftt['db-url'], $postgres_ftt['dbuser'], $postgres_ftt['dbpasswd']);
        
        $condicion =' AND 1=1 ';
        $isSuccess = FALSE;
        if($tipo_rpte=='RPTE_CAMARAS_GENERAL')
        {
            $path_file_jasper = BASEPATH . "../application/reports/camera_general/rpte_camera_general.jasper";
            $file_name_download = "CAMARA_EN_GENERAL_". ( uniqid() );
            $file_name_output   = 'camaras_general_' . ( uniqid() );
            $isSuccess = TRUE;
        }
        else if($tipo_rpte=='RPTE_ACCESS_TERMINAL')
        {
            $path_file_jasper = BASEPATH . "../application/reports/acceso_terminal/rpte_access_terminal.jasper";
            $file_name_download = "ACCESO_TERMINAL". ( uniqid() );
            $file_name_output   = 'acceso_terminal_' . ( uniqid() );
            $isSuccess = TRUE;
        }
        else if($tipo_rpte=='RPTE_BANIOS')
        {
            $path_file_jasper = BASEPATH . "../application/reports/banios/rpte_banios.jasper";
            $file_name_download = "BAÑOS". ( uniqid() );
            $file_name_output   = 'baños_' . ( uniqid() );
            $isSuccess = TRUE;
        }
        else if($tipo_rpte=='RPTE_PATIO_COMIDA')
        {
            $path_file_jasper = BASEPATH . "../application/reports/patio_comida/rpte_patio_comida.jasper";
            $file_name_download = "PATIOS_DE_COMIDAS". ( uniqid() );
            $file_name_output   = 'patios_de_comidas_' . ( uniqid() );
            $isSuccess = TRUE;
        }
        else if($tipo_rpte=='RPTE_ESCALERA_ASCENSOR')
        {
            $path_file_jasper = BASEPATH . "../application/reports/escalera_ascensor/rpte_escalera_ascensor.jasper";
            $file_name_download = "ESCALERAS_ASCENSORES". ( uniqid() );
            $file_name_output   = 'escaleras_ascensores_' . ( uniqid() );
            $isSuccess = TRUE;
        }
        else if($tipo_rpte=='RPTE_TORNIQUETE')
        {
            $path_file_jasper = BASEPATH . "../application/reports/torniquetes/rpte_torniquetes.jasper";
            $file_name_download = "TORNIQUETES". ( uniqid() );
            $file_name_output   = 'torniquetes_' . ( uniqid() );
            $isSuccess = TRUE;
        }
        
        $arrParameter = array
            (
                'fecha_inicio' => $date_begin, 
                'fecha_fin' => $date_end,
                'condicion' => $condicion,
                'ci_root_path' => BASEPATH . '../'
            );
           
        if($isSuccess)
        {
            
            /* @var $oReport oReport */
            $oReport = $this->library_jasperstarter->buildReport($path_file_jasper, $file_name_output, $arrParameter, $tipo_descarga);
            if( $oReport->isSuccess() )
            {
                //$data = file_get_contents( $oReport->filePath() ); // Read the file's contents
                //force_download($file_name_output, $data);

                $mime = get_mime_by_extension( $oReport->fileExtension() );
                //$mime = "application/pdf";

                ob_clean();
                header("Content-disposition: attachment; filename=$file_name_download.$tipo_descarga");
                header("Content-type: $mime");
                readfile( $oReport->filePath() );
            }
            else
            {
                header('Content-Type: text/html; charset=utf-8');
                echo "ERROR DE EJECCIÓN<br/>";
                echo "COMANDO: ".( $oReport->cmd() );
            }
            
            
        }
        else
        {
            header('Content-Type: text/html; charset=utf-8');
            echo "ERROR DE EJECCIÓN<br/>";
            echo "TIPO DE REPORTE: ".($tipo_rpte );
        }
    }
}