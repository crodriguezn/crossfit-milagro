<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Provincia 
{

    static public function listProvincia($id_pais, &$eProvincias/*REF*/)
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mProvincia Provincia_Model  */
        $mProvincia = $MY->mProvincia;

        $eProvincias = $mProvincia->listProvinciaxPais($id_pais);
        
        $oBus->isSuccess(TRUE);
       
        return $oBus;
    }

}
