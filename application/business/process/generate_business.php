<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_Process_Generate 
{
    static public function loadCameraGeneral($dateEnd, $dateBegin) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mT_Analytics T_Analytics_Model  */
        $mT_Analytics =& $MY->mT_Analytics;
        
        /* @var $mDateTime_Generate Datetime_Generate_Model */
        $mDateTime_Generate =& $MY->mDateTime_Generate;
        
        /* @var $mCamera_General Camera_General_Model  */
        $mCamera_General =& $MY->mCamera_General;
        
        $MY->db->trans_begin();
        try
        {
            $eDatetimeGenerate = $mDateTime_Generate->load(Helper_Config::getFTTProcessCameraGeneral(),'process_name');
            if(!$eDatetimeGenerate->isEmpty())
            {
                $dateBegin = $eDatetimeGenerate->update_datetime;
            }
            
            $eDatetimeGenerate->process_name = Helper_Config::getFTTProcessCameraGeneral();
            $eDatetimeGenerate->update_datetime = $dateEnd;
            $mDateTime_Generate->save($eDatetimeGenerate);
            
            $result = $mT_Analytics->loadCameraGeneral($dateEnd, $dateBegin);
        
            $eCameraGenerals = array();
            if (!empty($result)) 
            {
                foreach ($result as $row)
                {
                    $eCameraGeneral = new eCameraGeneral(FALSE);
                    $eCameraGeneral->parseRow($row, '', true);
                    $eCameraGenerals[] = $eCameraGeneral;
                }
            }
            if(!empty($eCameraGenerals))
            {
                foreach ($eCameraGenerals as $eCameraGeneral)
                {
                    $mCamera_General->save($eCameraGeneral);
                }
            }
            
            $oBus->isSuccess(TRUE);
            $oBus->message('Guardado exitosamente: Camara General');
            $MY->db->trans_commit();
        } 
        catch (Exception $ex)
        {
            $oBus->isSuccess(FALSE);
            $oBus->message($ex->getMessage());
            $MY->db->trans_rollback();
        }
        
        return $oBus;
    }
    
    static public function loadAccessTerminal($dateEnd, $dateBegin) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mT_Analytics T_Analytics_Model  */
        $mT_Analytics = $MY->mT_Analytics;
        
        /* @var $mDateTime_Generate Datetime_Generate_Model */
        $mDateTime_Generate =& $MY->mDateTime_Generate;
        
        /* @var $mAccess_Terminal Access_Terminal_Model  */
        $mAccess_Terminal = $MY->mAccess_Terminal;
        
        $MY->db->trans_begin();
        try
        {
            $eDatetimeGenerate = $mDateTime_Generate->load(Helper_Config::getFTTProcessAccessTerminal(),'process_name');
            if(!$eDatetimeGenerate->isEmpty())
            {
                $dateBegin = $eDatetimeGenerate->update_datetime;
            }
            
            $eDatetimeGenerate->process_name = Helper_Config::getFTTProcessAccessTerminal();
            $eDatetimeGenerate->update_datetime = $dateEnd;
            $mDateTime_Generate->save($eDatetimeGenerate);
            
            $result = $mT_Analytics->loadAccessTerminal($dateEnd, $dateBegin);

            $eAccessTerminals = array();
            if (!empty($result)) 
            {
                foreach ($result as $row)
                {
                    $eAccessTerminal = new eAccessTerminal(FALSE);
                    $eAccessTerminal->parseRow($row, '', true);
                    $eAccessTerminals[] = $eAccessTerminal;
                }
            }
            if(!empty($eAccessTerminals))
            {
                foreach ($eAccessTerminals as $eAccessTerminal)
                {
                    $mAccess_Terminal->save($eAccessTerminal);
                }
            }
            $oBus->isSuccess(TRUE);
            $oBus->message('Guardado exitosamente: Acceso al Terminal');
            $MY->db->trans_commit();
        } 
        catch (Exception $ex)
        {
            $oBus->isSuccess(FALSE);
            $oBus->message($ex->getMessage());
            $MY->db->trans_rollback();
        }

        return $oBus;
    }
    
    static public function loadBanios($dateEnd, $dateBegin) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mT_Analytics T_Analytics_Model  */
        $mT_Analytics = $MY->mT_Analytics;
        
        /* @var $mDateTime_Generate Datetime_Generate_Model */
        $mDateTime_Generate =& $MY->mDateTime_Generate;
        
        /* @var $mBanio Banios_Model  */
        $mBanio = $MY->mBanio;
        
        $MY->db->trans_begin();
        try
        {
            $eDatetimeGenerate = $mDateTime_Generate->load(Helper_Config::getFTTProcessBanio(),'process_name');
            if(!$eDatetimeGenerate->isEmpty())
            {
                $dateBegin = $eDatetimeGenerate->update_datetime;
            }
            
            $eDatetimeGenerate->process_name = Helper_Config::getFTTProcessBanio();
            $eDatetimeGenerate->update_datetime = $dateEnd;
            $mDateTime_Generate->save($eDatetimeGenerate);
            
            $result = $mT_Analytics->loadBanios($dateEnd, $dateBegin);

            $eBanios = array();
            if (!empty($result)) 
            {
                foreach ($result as $row)
                {
                    $eBanio = new eBanio(FALSE);
                    $eBanio->parseRow($row, '', true);
                    $eBanios[] = $eBanio;
                }
            }
            if(!empty($eBanios))
            {
                foreach ($eBanios as $eBanio)
                {
                    $mBanio->save($eBanio);
                }
            }
            $oBus->isSuccess(TRUE);
            $oBus->message('Guardado exitosamente: Baños');
            $MY->db->trans_commit();
        } 
        catch (Exception $ex)
        {
            $oBus->isSuccess(FALSE);
            $oBus->message($ex->getMessage());
            $MY->db->trans_rollback();
        }

        return $oBus;
    }
    
    static public function loadPatioComida($dateEnd, $dateBegin) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mT_Analytics T_Analytics_Model  */
        $mT_Analytics = $MY->mT_Analytics;
        
        /* @var $mDateTime_Generate Datetime_Generate_Model */
        $mDateTime_Generate =& $MY->mDateTime_Generate;
        
        /* @var $mPatioComida Patio_Comida_Model  */
        $mPatioComida = $MY->mPatioComida;
        
        $MY->db->trans_begin();
        try
        {
            $eDatetimeGenerate = $mDateTime_Generate->load(Helper_Config::getFTTProcessPatioComida(),'process_name');
            if(!$eDatetimeGenerate->isEmpty())
            {
                $dateBegin = $eDatetimeGenerate->update_datetime;
            }
            
            $eDatetimeGenerate->process_name = Helper_Config::getFTTProcessPatioComida();
            $eDatetimeGenerate->update_datetime = $dateEnd;
            $mDateTime_Generate->save($eDatetimeGenerate);
            
            $result = $mT_Analytics->loadPatioComida($dateEnd, $dateBegin);

            $ePatioComidas = array();
            if (!empty($result)) 
            {
                foreach ($result as $row)
                {
                    $ePatioComida = new ePatioComida(FALSE);
                    $ePatioComida->parseRow($row, '', true);
                    $ePatioComidas[] = $ePatioComida;
                }
            }
            if(!empty($ePatioComidas))
            {
                foreach ($ePatioComidas as $ePatioComida)
                {
                    $mPatioComida->save($ePatioComida);
                }
            }
            $oBus->isSuccess(TRUE);
            $oBus->message('Guardado exitosamente: Patio de Comida');
            $MY->db->trans_commit();
        } 
        catch (Exception $ex)
        {
            $oBus->isSuccess(FALSE);
            $oBus->message($ex->getMessage());
            $MY->db->trans_rollback();
        }

        return $oBus;
    }
    
    static public function loadEscalera_Ascensor($dateEnd, $dateBegin) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mT_Analytics T_Analytics_Model  */
        $mT_Analytics = $MY->mT_Analytics;
        
        /* @var $mDateTime_Generate Datetime_Generate_Model */
        $mDateTime_Generate =& $MY->mDateTime_Generate;
        
        /* @var $mEscaleraAscensor Escalera_Ascensor_Model  */
        $mEscaleraAscensor = $MY->mEscaleraAscensor;
        
        $MY->db->trans_begin();
        try
        {
            $eDatetimeGenerate = $mDateTime_Generate->load(Helper_Config::getFTTProcessEscaleraAscensor(),'process_name');
            if(!$eDatetimeGenerate->isEmpty())
            {
                $dateBegin = $eDatetimeGenerate->update_datetime;
            }
            
            $eDatetimeGenerate->process_name = Helper_Config::getFTTProcessEscaleraAscensor();
            $eDatetimeGenerate->update_datetime = $dateEnd;
            $mDateTime_Generate->save($eDatetimeGenerate);
            
            $result = $mT_Analytics->loadEscaleraAscensor($dateEnd, $dateBegin);

            $eEscaleraAscensors = array();
            if (!empty($result)) 
            {
                foreach ($result as $row)
                {
                    $eEscaleraAscensor = new eEscaleraAscensor(FALSE);
                    $eEscaleraAscensor->parseRow($row, '', true);
                    $eEscaleraAscensors[] = $eEscaleraAscensor;
                }
            }
            if(!empty($eEscaleraAscensors))
            {
                foreach ($eEscaleraAscensors as $eEscaleraAscensor)
                {
                    $mEscaleraAscensor->save($eEscaleraAscensor);
                }
            }
            $oBus->isSuccess(TRUE);
            $oBus->message('Guardado exitosamente: Escaleras y Ascensores');
            $MY->db->trans_commit();
        } 
        catch (Exception $ex)
        {
            $oBus->isSuccess(FALSE);
            $oBus->message($ex->getMessage());
            $MY->db->trans_rollback();
        }
        
        return $oBus;
    }
    
    static public function loadTorniquete($dateEnd, $dateBegin) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mT_Analytics T_Analytics_Model  */
        $mT_Analytics = $MY->mT_Analytics;
        
        /* @var $mDateTime_Generate Datetime_Generate_Model */
        $mDateTime_Generate =& $MY->mDateTime_Generate;
        
        /* @var $mTorniquete Torniquete_Model  */
        $mTorniquete = $MY->mTorniquete;
        
        $MY->db->trans_begin();
        try
        {
            $eDatetimeGenerate = $mDateTime_Generate->load(Helper_Config::getFTTProcessTorniquete(),'process_name');
            if(!$eDatetimeGenerate->isEmpty())
            {
                $dateBegin = $eDatetimeGenerate->update_datetime;
            }
            
            $eDatetimeGenerate->process_name = Helper_Config::getFTTProcessTorniquete();
            $eDatetimeGenerate->update_datetime = $dateEnd;
            $mDateTime_Generate->save($eDatetimeGenerate);
            
            $result = $mT_Analytics->loadTorniquete($dateEnd, $dateBegin);

            $eTorniquetes = array();
            if (!empty($result)) 
            {
                foreach ($result as $row)
                {
                    $eTorniquete = new eTorniquete(FALSE);
                    $eTorniquete->parseRow($row, '', true);
                    $eTorniquetes[] = $eTorniquete;
                }
            }
            if(!empty($eTorniquetes))
            {
                foreach ($eTorniquetes as $eTorniquete)
                {
                    $mTorniquete->save($eTorniquete);
                }
            }
            $oBus->isSuccess(TRUE);
            $oBus->message('Guardado exitosamente: Torniquetes');
            $MY->db->trans_commit();
        } 
        catch (Exception $ex)
        {
            $oBus->isSuccess(FALSE);
            $oBus->message($ex->getMessage());
            $MY->db->trans_rollback();
        }

        return $oBus;
    }
    
    static public function loadResumenCamera($dateEnd, $dateBegin) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mT_Analytics T_Analytics_Model  */
        $mT_Analytics = $MY->mT_Analytics;
        
        /* @var $mDateTime_Generate Datetime_Generate_Model */
        $mDateTime_Generate =& $MY->mDateTime_Generate;
        
        /* @var $mResumen_Camera Resumen_Camera_Model  */
        $mResumen_Camera = $MY->mResumen_Camera;
        
        $MY->db->trans_begin();
        try
        {
            $eDatetimeGenerate = $mDateTime_Generate->load(Helper_Config::getFTTProcessResumenCamera(),'process_name');
            if(!$eDatetimeGenerate->isEmpty())
            {
                $dateBegin = $eDatetimeGenerate->update_datetime;
            }
            
            $eDatetimeGenerate->process_name = Helper_Config::getFTTProcessResumenCamera();
            $eDatetimeGenerate->update_datetime = $dateEnd;
            $mDateTime_Generate->save($eDatetimeGenerate);
            
            $result = $mT_Analytics->loadResumenCamera($dateEnd, $dateBegin);

            $eResumenCameras = array();
            if (!empty($result)) 
            {
                foreach ($result as $row)
                {
                    $eResumenCamera = new eResumenCamera(FALSE);
                    $eResumenCamera->parseRow($row, '', true);
                    $eResumenCameras[] = $eResumenCamera;
                }
            }
            if(!empty($eResumenCameras))
            {
                foreach ($eResumenCameras as $eResumenCamera)
                {
                    $mResumen_Camera->save($eResumenCamera);
                }
            }
            $oBus->isSuccess(TRUE);
            $oBus->message('Guardado exitosamente: Resumen de Camera');
            $MY->db->trans_commit();
        } 
        catch (Exception $ex)
        {
            $oBus->isSuccess(FALSE);
            $oBus->message($ex->getMessage());
            $MY->db->trans_rollback();
        }

        return $oBus;
    }

}
