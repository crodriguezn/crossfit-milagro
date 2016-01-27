<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_Process_Torniquete 
{
    static public function listAll(&$eT_ANALYTICS) 
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mP_TAnalytics T_Analytics_Model  */
        $mP_TAnalytics = $MY->mP_TAnalytics;

        $eT_ANALYTICS = $mP_TAnalytics->loadAll();
        
        $oBus->isSuccess(TRUE);
       
        return $oBus;
    }

}
