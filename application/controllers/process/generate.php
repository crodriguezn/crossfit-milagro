<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generate extends MY_Controller
{
   
    function __construct()
    {
        parent::__construct( self::SYSTEM_PROCESS );
    }

    public function index()
    {
        $this->_init();
    }
    
    public function _init()
    {
        $DateTime_ProcesoTotal_Begin = date('Y-m-d H:i:s');
        $arrDataProcess = array();
        
        $this->_camera_general();
        $this->_access_terminal();
        $this->_banio();
        $this->_patio_comida();
        $this->_escalera_ascensor();
        $this->_torniquete();
        $this->_resumen_camera();
        
        $arrDataProcess['Proceso'] = array(
            'timestamp'=>Helper_Fecha::getDiff_DateTime($DateTime_ProcesoTotal_Begin)
        );
        
        Helper_Log::write($arrDataProcess);
        //print_r($arrDataProcess);
        
    }
    
    public function _camera_general()
    {
        $dateBegin = NULL;
        $dateEnd = date('Y-m-d').' 00:00:00';
        
        $arrDataProcess = array();
        /*
         * Inicio del proceso de Camara en General
         */
        $DateTime_CameraGeneral_Begin = date('Y-m-d H:i:s');
        $cont_P_CameraGeneral = 0;
        while($cont_P_CameraGeneral < 2)
        {
            $oRes = Business_Process_Generate::loadCameraGeneral($dateEnd, $dateBegin);
            if($oRes->isSuccess()) { break; }
            $cont_P_CameraGeneral++;
        }
        if(!$oRes->isSuccess())
        {
            Helper_Process_Log::write($oRes->message());
        }
        
        $arrDataProcess[Helper_Config::getFTTProcessCameraGeneral()] = array(
            'isSuccess'=>$oRes->isSuccess(), 
            'message'=>$oRes->message(), 
            'timestamp'=>Helper_Fecha::getDiff_DateTime($DateTime_CameraGeneral_Begin)
        );
        /*-----------------------------------------------------------------*/
        Helper_Log::write($arrDataProcess);
        //print_r($arrDataProcess);
        
    }
    
    public function _access_terminal()
    {
        $dateBegin = NULL;
        $dateEnd = date('Y-m-d').' 00:00:00';
        
        $arrDataProcess = array();
        
        /*
         * Inicio del proceso de Grupo de Camaras (ACCESO TERMINAL)
         */
        $DateTime_Begin = date('Y-m-d H:i:s');
        $cont_process = 0;
        while($cont_process < 2)
        {
            $oRes = Business_Process_Generate::loadAccessTerminal($dateEnd, $dateBegin);
            if($oRes->isSuccess()) { break; }
            $cont_process++;
        }
        if(!$oRes->isSuccess())
        {
            Helper_Process_Log::write($oRes->message());
        }
        
        $arrDataProcess[Helper_Config::getFTTProcessAccessTerminal()] = array(
            'isSuccess'=>$oRes->isSuccess(), 
            'message'=>$oRes->message(), 
            'timestamp'=>Helper_Fecha::getDiff_DateTime($DateTime_Begin)
        );
        /*-----------------------------------------------------------------*/
        Helper_Log::write($arrDataProcess);
        //print_r($arrDataProcess);
    }
    
    public function _banio()
    {
        $dateBegin = NULL;
        $dateEnd = date('Y-m-d').' 00:00:00';
        
        $arrDataProcess = array();
        
        /*
         * Inicio del proceso de Grupo de Camaras (BAÑOS)
         */
        $DateTime_Begin = date('Y-m-d H:i:s');
        $cont_process = 0;
        while($cont_process < 2)
        {
            $oRes = Business_Process_Generate::loadBanios($dateEnd, $dateBegin);
            if($oRes->isSuccess()) { break; }
            $cont_process++;
        }
        if(!$oRes->isSuccess())
        {
            Helper_Process_Log::write($oRes->message());
        }
        
        $arrDataProcess[Helper_Config::getFTTProcessBanio()] = array(
            'isSuccess'=>$oRes->isSuccess(), 
            'message'=>$oRes->message(), 
            'timestamp'=>Helper_Fecha::getDiff_DateTime($DateTime_Begin)
        );
        /*-----------------------------------------------------------------*/
        Helper_Log::write($arrDataProcess);
        //print_r($arrDataProcess);
    }
    
    public function _patio_comida()
    {
        $dateBegin = NULL;
        $dateEnd = date('Y-m-d').' 00:00:00';
        
        $arrDataProcess = array();
        
        /*
         * Inicio del proceso de Grupo de Camaras (PATIOS DE COMIDA)
         */
        $DateTime_Begin = date('Y-m-d H:i:s');
        $cont_process = 0;
        while($cont_process < 2)
        {
            $oRes = Business_Process_Generate::loadPatioComida($dateEnd, $dateBegin);
            if($oRes->isSuccess()) { break; }
            $cont_process++;
        }
        if(!$oRes->isSuccess())
        {
            Helper_Process_Log::write($oRes->message());
        }
        
        $arrDataProcess[Helper_Config::getFTTProcessPatioComida()] = array(
            'isSuccess'=>$oRes->isSuccess(), 
            'message'=>$oRes->message(), 
            'timestamp'=>Helper_Fecha::getDiff_DateTime($DateTime_Begin)
        );
        /*-----------------------------------------------------------------*/
        Helper_Log::write($arrDataProcess);
        //print_r($arrDataProcess);
    }
    
    public function _escalera_ascensor()
    {
        $dateBegin = NULL;
        $dateEnd = date('Y-m-d').' 00:00:00';
        
        $arrDataProcess = array();
        
        /*
         * Inicio del proceso de Grupo de Camaras (ESCALERAS Y ASCENSORES)
         */
        $DateTime_Begin = date('Y-m-d H:i:s');
        $cont_process = 0;
        while($cont_process < 2)
        {
            $oRes = Business_Process_Generate::loadEscalera_Ascensor($dateEnd, $dateBegin);
            if($oRes->isSuccess()) { break; }
            $cont_process++;
        }
        if(!$oRes->isSuccess())
        {
            Helper_Process_Log::write($oRes->message());
        }
        
        $arrDataProcess[Helper_Config::getFTTProcessEscaleraAscensor()] = array(
            'isSuccess'=>$oRes->isSuccess(), 
            'message'=>$oRes->message(), 
            'timestamp'=>Helper_Fecha::getDiff_DateTime($DateTime_Begin)
        );
        /*-----------------------------------------------------------------*/
        Helper_Log::write($arrDataProcess);
        //print_r($arrDataProcess);
    }
    
    public function _torniquete()
    {
        $dateBegin = NULL;
        $dateEnd = date('Y-m-d').' 00:00:00';
        
        $arrDataProcess = array();
        
        /*
         * Inicio del proceso de Grupo de Camaras (TORNIQUETE)
         */
        $DateTime_Begin = date('Y-m-d H:i:s');
        $cont_process = 0;
        while($cont_process < 2)
        {
            $oRes = Business_Process_Generate::loadTorniquete($dateEnd, $dateBegin);
            if($oRes->isSuccess()) { break; }
            $cont_process++;
        }
        if(!$oRes->isSuccess())
        {
            Helper_Process_Log::write($oRes->message());
        }
        
        $arrDataProcess[Helper_Config::getFTTProcessTorniquete()] = array(
            'isSuccess'=>$oRes->isSuccess(), 
            'message'=>$oRes->message(), 
            'timestamp'=>Helper_Fecha::getDiff_DateTime($DateTime_Begin)
        );
        /*-----------------------------------------------------------------*/
        Helper_Log::write($arrDataProcess);
        //print_r($arrDataProcess);
    }
    
    public function _resumen_camera()
    {
        $dateBegin = NULL;
        $dateEnd = date('Y-m-d').' 00:00:00';
        
        $arrDataProcess = array();
        
        /*
         * Inicio del proceso de Resumen de Camaras
         */
        $DateTime_ResumenCamera_Begin = date('Y-m-d H:i:s');
        $cont_P_ResumenCamera = 0;
        while($cont_P_ResumenCamera < 2)
        {
            $oRes = Business_Process_Generate::loadResumenCamera($dateEnd, $dateBegin);
            if($oRes->isSuccess()) { break; }
            $cont_P_ResumenCamera++;
        }
        if(!$oRes->isSuccess())
        {
            Helper_Process_Log::write($oRes->message());
        }
        
        $arrDataProcess[Helper_Config::getFTTProcessResumenCamera()] = array(
            'isSuccess'=>$oRes->isSuccess(), 
            'message'=>$oRes->message(), 
            'timestamp'=>Helper_Fecha::getDiff_DateTime($DateTime_ResumenCamera_Begin)
        );
        /*-----------------------------------------------------------------*/
        Helper_Log::write($arrDataProcess);
        //print_r($arrDataProcess);
    }
}