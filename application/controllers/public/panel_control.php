<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_Control extends MY_Controller
{
    protected $name_key = 'panel_control';
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
                'code' => 'ACCESOS_GENERALES',
                'name' => 'Accesos Generales (P1, P2 & P3)'
            ),
            array(
                'code' => 'ARRIBO_PASAJEROS',
                'name' => 'Arribo de Pasajeros (PA, PB & PC)'
            ),
            array(
                'code' => 'TORNIQUETES',
                'name' => 'Torniquetes'
            ),
            array(
                'code' => 'ESCALERAS_ELECTRICAS',
                'name' => 'Escaleras Eléctricas'
            ),
            array(
                'code' => 'ASCENSORES',
                'name' => 'Ascensores'
            ),
            array(
                'code' => 'PATIO_COMIDAS',
                'name' => 'Patio de Comidas'
            ),
            array(
                'code' => 'BANIOS',
                'name' => 'Baños'
            )
        );
        
        $dataTipoInformacion = array(
            array(
                'code' => 'INFORMATION_BY_DAY',
                'name' => 'INFORMACIÓN POR DÍA'
            ),
            array(
                'code' => 'INFORMATION_BY_HOUR',
                'name' => 'INFORMACIÓN POR HORAS'
            )
        );
        $dataTipoSubInformacion = array(
            array(
                'code' => 'PROMEDIO_BY_HOUR_FROM_MONTH',
                'name' => 'Promedio por hora del mes'
            ),
            array(
                'code' => 'PROMEDIO_BY_HOUR_DAY_FROM_DAY_WEEK',
                'name' => 'Promedio por hora y por día de la semana'
            ),
            array(
                'code' => 'PROMEDIO_BY_HOUR_DATE',
                'name' => 'Promedio por hora por fecha específica'
            )
        );
        $dataDayWeek = array(
            array(
                'code' => 'Monday',
                'name' => 'Lunes'
            ),
            array(
                'code' => 'Tuesday',
                'name' => 'Martes'
            ),
            array(
                'code' => 'Wednesday',
                'name' => 'Miércoles'
            ),
            array(
                'code' => 'Thursday',
                'name' => 'Jueves'
            ),
            array(
                'code' => 'Friday',
                'name' => 'Viernes'
            ),
            array(
                'code' => 'Saturday',
                'name' => 'Sábado'
            ),
            array(
                'code' => 'Sunday',
                'name' => 'Domingo'
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
            'cboTipoInformacion' => $dataTipoInformacion,
            'cboTipoSubInformacion' => $dataTipoSubInformacion,
            'cboDayWeek' => $dataDayWeek,
            'cboYear' => Helper_Fecha::getArrayYear(0,5),
            'cboMonth' => Helper_Fecha::getArrayMonth()
        );
        Helper_Public_View::layout('public/html/pages/reporte/panel_control/page',$para);
    }
    
    public function mvcjs( )
    {
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx
        );
        
        Helper_Public_JS::showMVC('reporte/panel_control', $params);
    }
    //+ rpte_tipo_informacion + '/' + rpte_tipo_sub_informacion + '/' + year + '/' + month + '/' + day + '/' + day_week + '/' + rpte_tipo + '/' + rpte_t_descarga
    public function printReport( $tipo_informacion, $tipo_sub_informacion, $year, $month, $day, $day_week, $area, $tipo_descarga=NULL )
    {
        if(empty($tipo_descarga))
        {
            $tipo_descarga = 'xlsx';
        }
        $this->load->library('library_jasperstarter');
        
        $java_bin = Helper_Config::getBinaryJava();
        $postgres_ftt = Helper_Config::getJasperStarterPostgresTT();
        
        $this->library_jasperstarter->setPathFolderOutput( BASEPATH . '../application/temp' );
        $this->library_jasperstarter->setPathJavaBin( $java_bin );
        $this->library_jasperstarter->dbGeneric( $postgres_ftt['db-driver'], $postgres_ftt['db-url'], $postgres_ftt['dbuser'], $postgres_ftt['dbpasswd']);
        
        $isSuccess = FALSE;
        $ci_root_path = BASEPATH . '../';
        $CI_ROOT_PATH_REPORT = $ci_root_path . "/application/reports/";
        $titulo = NULL;
        $name_tabla = NULL;
        $by_where = NULL;
        $case_group_camera = NULL;
        if($tipo_informacion=='INFORMATION_BY_DAY')
        {
            $path_file_jasper = $CI_ROOT_PATH_REPORT.'panel_control/by_day/rpte_dynamic_by_day';
            $file_name_download = 'BY_DAY_'.$tipo_sub_informacion. ( uniqid() );
            $file_name_output =  strtolower('BY_DAY_'.$tipo_sub_informacion. ( uniqid() ));
            $date_begin = $year.'-'.$month.'-01';
            $date_end = $year.'-'.$month.'-'.Helper_Fecha::getLastDay_By_YearMonth($year, $month, TRUE);
            if($area=='ACCESOS_GENERALES')
            {
                $titulo = 'Accesos Generales';
                $name_tabla = 'access_terminal';
                $case_group_camera = "CASE ".
				"WHEN t_d.id_group_camera = '1' THEN ".
					"'Puerta 1' ".
				"WHEN t_d.id_group_camera = '2' THEN ".
					"'Puerta 2' ".
				"WHEN t_d.id_group_camera = '3' THEN ".
					"'Puerta 3' ".
				"ELSE ".
					"'NO FOUND' ".
				"END";
                $by_where = " AND t_d.id_group_camera BETWEEN '1' AND '3'";
            }
            elseif($area=='ARRIBO_PASAJEROS')
            {
                $titulo = 'Arribo de Pasajeros';
                $name_tabla = 'access_terminal';
                $case_group_camera = "CASE ".
				"WHEN t_d.id_group_camera = '4' THEN ".
					"'Puerta A' ".
				"WHEN t_d.id_group_camera = '5' THEN ".
					"'Puerta B' ".
				"WHEN t_d.id_group_camera = '6' THEN ".
					"'Puerta C' ".
				"ELSE ".
					"'NO FOUND' ".
				"END";
                
                $by_where = " AND t_d.id_group_camera BETWEEN '4' AND '6'";
            }
            elseif($area=='TORNIQUETES')
            {
                $path_file_jasper = $CI_ROOT_PATH_REPORT.'panel_control/by_day/rpte_toniquete_by_day';
                $titulo = 'Torniquetes';
                $name_tabla = 'torniquete';
            }
            elseif($area=='ESCALERAS_ELECTRICAS')
            {
                $titulo = 'Escaleras Electricas';
                $name_tabla = 'escalera_and_ascensor';
            }
            elseif($area=='ASCENSORES')
            {
                $titulo = 'Ascensores';
                $name_tabla = 'escalera_and_ascensor';
            }
            elseif($area=='PATIO_COMIDAS')
            {
                $titulo = 'Patio de Comidas';
                $name_tabla = 'patios_comida';
            }
            elseif($area=='BANIOS')
            {
                $titulo = 'Baños';
                $name_tabla = 'banio';
            }
            $isSuccess = TRUE;
        }
        else if($tipo_informacion=='INFORMATION_BY_HOUR')
        {
            $path_file_jasper = $CI_ROOT_PATH_REPORT.'panel_control/by_hour/'.  strtolower($tipo_sub_informacion).'/';
            $file_name_download = 'BY_HOUR_'.$tipo_sub_informacion. ( uniqid() );
            $file_name_output =  strtolower('BY_HOUR_'.$tipo_sub_informacion. ( uniqid() ));
        }
        
        
        $arrParameter = array
            (
                'titulo'            => $titulo,
                'name_table'        => $name_tabla,
                'case_group_camera' => $case_group_camera,
                'by_where'          => $by_where,
                'fecha_inicio'      => $date_begin, 
                'fecha_fin'         => $date_end,
                'ci_root_path'      => $ci_root_path
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
            echo "TIPO DE REPORTE: ".($area );
        }
    }
}