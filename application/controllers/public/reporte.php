<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends MY_Controller
{
    protected $name_key = 'reporte';
    protected $permission;
    
    function __construct()
    {
        parent::__construct( self::SYSTEM_PUBLIC );
    }

    public function index()
    {
        $dataRpte = array(
            array(
                'code' => 'RPTE_CAMARAS_GENERAL',
                'name' => 'CAMARAS EN GENERAL'
            ),
            array(
                'code' => 'RPTE_GRUPOS_CAMARAS',
                'name' => 'GRUPOS DE CAMARAS'
            ),
            array(
                'code' => 'RPTE_RESUMEN_CAMARAS_GENERAL',
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

        $dataRpteGrupo = array(
            array(
                'code' => '1',
                'name' => 'Accesos al Terminal'
            ),
            array(
                'code' => '2',
                'name' => 'Baños'
            ),
            array(
                'code' => '3',
                'name' => 'Patio de Comidas'
            ),
            array(
                'code' => '4',
                'name' => 'Escaleras y Ascensores'
            ),
            array(
                'code' => '5',
                'name' => 'Torniquetes'
            )
        );
        $para = array(
            'cboReporte' => $dataRpte,
            'cboGrupo' => $dataRpteGrupo
        );
        Helper_Public_View::layout('public/html/pages/reporte/page',$para);
    }
    
    public function mvcjs( )
    {
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx
        );
        
        Helper_Public_JS::showMVC('reporte', $params);
    }
    
    public function printReport( $date_begin, $date_end, $tipo_rpte, $rpte_grupo )
    {
        $this->load->library('library_jasperstarter');

        $java_bin = Helper_Config::getBinaryJava();
        $firebird_ftt = Helper_Config::getJasperStarterFirebirdTT();
        
        $this->library_jasperstarter->setPathFolderOutput( BASEPATH . '../application/temp' );
        $this->library_jasperstarter->setPathJavaBin( $java_bin );
        $this->library_jasperstarter->dbGeneric( $firebird_ftt['db-driver'], $firebird_ftt['db-url'], $firebird_ftt['dbuser'], $firebird_ftt['dbpasswd']);
        
        $condicion =' AND 1=1 ';
        $isSuccess = FALSE;
        if($tipo_rpte=='RPTE_CAMARAS_GENERAL')
        {
            $path_file_jasper = BASEPATH . "../application/reports/camaras_general/rpte_camara_general.jasper";
            $file_name_download = "CAMARA_EN_GENERAL";
            $file_name_output   = 'camaras_general_' . ( uniqid() );
            $condicion.=' AND 1=1 ';
            $isSuccess = TRUE;
        }
        else if($tipo_rpte=='RPTE_GRUPOS_CAMARAS')
        {
            $path_file_jasper = BASEPATH . "../application/reports/grupos_general/rpte_grupos_general.jasper";
            $file_name_download = "GRUPO_DE_CAMARA";
            $file_name_output   = 'grupo_camara_' . ( uniqid() );
            $rpte_grupo = explode("-",$rpte_grupo);
            $condicion_aux = null;
            foreach ($rpte_grupo as $key => $value)
            {
                if($value=='1')
                {
                    $condicion_aux .= " A2.ID_GRUPO_CAMARA = '1' OR "
                            . "A2.ID_GRUPO_CAMARA = '2' OR "
                            . "A2.ID_GRUPO_CAMARA = '3' OR "
                            . "A2.ID_GRUPO_CAMARA = '4' OR "
                            . "A2.ID_GRUPO_CAMARA = '5' OR "
                            . "A2.ID_GRUPO_CAMARA = '6' OR ";
                }
                elseif ($value=='2') 
                {
                    $condicion_aux .= " A2.ID_GRUPO_CAMARA = '9' OR "
                            . "A2.ID_GRUPO_CAMARA = '12' OR "
                            . "A2.ID_GRUPO_CAMARA = '15' OR ";
                }
                elseif ($value=='3') 
                {
                    $condicion_aux .= " A2.ID_GRUPO_CAMARA = '7' OR ";
                }
                elseif ($value=='4') 
                {
                    $condicion_aux .= " A2.ID_GRUPO_CAMARA = '8' OR "
                            . "A2.ID_GRUPO_CAMARA = '10' OR "
                            . "A2.ID_GRUPO_CAMARA = '11' OR "
                            . "A2.ID_GRUPO_CAMARA = '14' OR ";
                }
                elseif ($value=='5') 
                {
                    $condicion_aux .= " A2.ID_GRUPO_CAMARA = '13' OR "
                            . "A2.ID_GRUPO_CAMARA = '16' OR ";
                }
            }
            $condicion.= is_null($condicion_aux)?"AND 1=1":"AND ( ".$condicion_aux." 1!=1 )";
            
            $isSuccess = TRUE;
        }
        else if($tipo_rpte=='RPTE_RESUMEN_CAMARAS_GENERAL')
        {
            $path_file_jasper = BASEPATH . "../application/reports/resumen_camras_general/rpte_resumen_camara_general.jasper";
            $file_name_download = "RESUMEN_CAMARA_EN_GENERAL";
            $file_name_output   = 'resumen_camaras_general_' . ( uniqid() );
            $condicion.=' AND 1=1 ';
            $isSuccess = TRUE;
        }
        
        $arrParameter = array
            (
                'fecha_inicio' => $date_begin, 
                'fecha_fin' => $date_end,
                'condicion' => $condicion
            );
           
        if($isSuccess)
        {
            /* @var $oReport oReport */
            $oReport = $this->library_jasperstarter->buildReport($path_file_jasper, $file_name_output, $arrParameter, 'xls');
            if( $oReport->isSuccess() )
            {
                //$data = file_get_contents( $oReport->filePath() ); // Read the file's contents
                //force_download($file_name_output, $data);

                $mime = get_mime_by_extension( $oReport->fileExtension() );
                //$mime = "application/pdf";

                ob_clean();
                header("Content-disposition: attachment; filename=$file_name_download.xls");
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