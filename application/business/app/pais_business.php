<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Pais 
{
   
    static public function listPais( &$ePaises/*REF*/ ) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mPais Pais_Model  */
        $mPais = $MY->mPais;

        $ePaises = $mPais->listAll('', NULL, NULL);
        
        $oBus->isSuccess(TRUE);
       
        return $oBus;
    }

}
