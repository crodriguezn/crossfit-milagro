<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Ciudad
{
    static public function listCiudad($id_provincia,&$eCiudades/*REF*/)
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mCiudad Ciudad_Model  */
        $mCiudad = $MY->mCiudad;

        $eCiudades = $mCiudad->listCiudadxProvincia($id_provincia);
        
        $oBus->isSuccess(TRUE);
       
        return $oBus;
    }
    
    static public function loadCiudad($id_ciudad, &$eCiudad/*REF*/)
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mCiudad Ciudad_Model  */
        $mCiudad = $MY->mCiudad;

        $eCiudad = $mCiudad->load($id_ciudad);
        
        $oBus->isSuccess(TRUE);
       
        return $oBus;
    }
    
}
