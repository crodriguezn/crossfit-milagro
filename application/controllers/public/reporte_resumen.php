<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_Resumen extends MY_Controller
{
    protected $name_key = 'reporte_resumen';
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
                'code' => 'RPTE_RESUMEN_CAMARAS_GENERAL',
                'name' => 'RESUMEN CAMARAS EN GENERAL'
            ),
            array(
                'code' => 'RPTE_RESUMEN_GRUPOS_CAMARAS',
                'name' => 'RESUMEN GRUPOS DE CAMARAS'
            )
        );
        /*1. PARQUEOS PUBLICOS PUERTA
        10. ESCALERAS ELECTRICAS
        11. ASCENSORES 1er. PISO
        12. BAÑOS 1er. PISO
        13. TORNIQUETE 1er. PISO 
        14. ASCENSORES 2do. PISO
        15. BAÑOS 2do.  PISO
        16. TORNIQUETES 2do. PISO
        2. PARQUEOS PUBLICOS PUERTA
        3. LLEGADA TAXIS PUERTA # 3
        4. ARRIBOS PUERTA A 
        5. ARRIBOS PUERTA B  
        6. ARRIBOS PUERTA C        
        7. PATIO DE COMIDAS    
        8. ASCENSORES PB      
        9. BAÑOS PB ZONA A - B   */

        $para = array(
            'cboReporte' => $dataRpte,
            'cboTPrint' => $dataTPrint,
            'cboYear' => Helper_Fecha::getArrayYear(0,5),
            'cboMonth' => Helper_Fecha::getArrayMonth()
        );
        Helper_Public_View::layout('public/html/pages/reporte/resumen/page',$para);
    }
    
    public function mvcjs( )
    {
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx
        );
        
        Helper_Public_JS::showMVC('reporte/resumen', $params);
    }
    
    public function printReport( $date_begin, $date_end, $tipo_rpte, $rpte_grupo, $tipo_descarga=NULL )
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
        if($tipo_rpte=='RPTE_RESUMEN_CAMARAS_GENERAL')
        {
            $path_file_jasper = BASEPATH . "../application/reports/resumen_camras_general/rpte_resumen_camara_general.jasper";
            $file_name_download = "RESUMEN_CAMARA_EN_GENERAL_". ( uniqid() );
            $file_name_output   = 'resumen_camaras_general_' . ( uniqid() );
            $condicion.=' AND 1=1 ';
            $isSuccess = TRUE;
        }
        else if($tipo_rpte=='RPTE_RESUMEN_GRUPOS_CAMARAS')
        {
            
            if($rpte_grupo=='1')/*accesos generales*/
            {
                $path_file_jasper = BASEPATH . "../application/reports/accesos_generales/rpte_accesos_generales.jasper";
                $file_name_download = "RESUMEN_ACCESOS_GENERALES_". ( uniqid() );
                $file_name_output   = 'resumen_accesos_generales_' . ( uniqid() );
            }
            elseif($rpte_grupo=='2')/*viajeros arriban*/
            {
                $path_file_jasper = BASEPATH . "../application/reports/viajeros_arriban/rpte_viajeros_arriban.jasper";
                $file_name_download = "RESUMEN_VIAJEROS_ARRIBAN_". ( uniqid() );
                $file_name_output   = 'resumen_viajeros_arriban_' . ( uniqid() );
            }
            
            elseif($rpte_grupo=='3')/*corredores*/
            {
                $array = explode("-", $date_begin);
                $year = $array[0];
                $month = $array[1];
                $date_begin = $date_begin.'-01';
                $date_end = $date_end.'-'.Helper_Fecha::getLastDay_By_YearMonth($year,$month);
                $path_file_jasper = BASEPATH . "../application/reports/corredores/rpte_corredores.jasper";
                $file_name_download = "RESUMEN_CORREDORES_". ( uniqid() );
                $file_name_output   = 'resumen_corredores_' . ( uniqid() );
            }
            elseif($rpte_grupo=='4')/*Escaleras Electricas*/
            {
                $path_file_jasper = BASEPATH . "../application/reports/escaleras_electricas/rpte_escalera_electrica.jasper";
                $file_name_download = "RESUMEN_ESCALERAS_ELECTRICAS_". ( uniqid() );
                $file_name_output   = 'resumen_escaleras_electricas_' . ( uniqid() );
            }
            elseif($rpte_grupo=='5')/*Ascensores*/
            {
                $path_file_jasper = BASEPATH . "../application/reports/ascensores/rpte_ascensores.jasper";
                $file_name_download = "RESUMEN_ASCENSORES_". ( uniqid() );
                $file_name_output   = 'resumen_ascensores_' . ( uniqid() );
            }
            elseif($rpte_grupo=='6')/*Patio de Comidas*/
            {
                $path_file_jasper = BASEPATH . "../application/reports/resumen_patio_comida/rpte_patio_comida.jasper";
                $file_name_download = "RESUMEN_PATIO_COMIDA_". ( uniqid() );
                $file_name_output   = 'resumen_patio_comida_' . ( uniqid() );
            }
            elseif($rpte_grupo=='7')/*Baños*/
            {
                $path_file_jasper = BASEPATH . "../application/reports/resumen_banios/rpte_banios.jasper";
                $file_name_download = "RESUMEN_BAÑOS_". ( uniqid() );
                $file_name_output   = 'resumen_baños_' . ( uniqid() );
            }
            elseif($rpte_grupo=='8')/*Resumen de Torniquetes*/
            {
                $path_file_jasper = BASEPATH . "../application/reports/resumen_torniquetes/rpte_resumen_torniquetes.jasper";
                $file_name_download = "RESUMEN_TORNIQUETES_". ( uniqid() );
                $file_name_output   = 'resumen_torniquetes_' . ( uniqid() );
            }
            elseif($rpte_grupo=='9')/*resumen general*/
            {
                $path_file_jasper = BASEPATH . "../application/reports/resumen_general/rpte_resumen_general.jasper";
                $file_name_download = "RESUMEN_GENERAL". ( uniqid() );
                $file_name_output   = 'resumen_torniquetes_' . ( uniqid() );
            }
            
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