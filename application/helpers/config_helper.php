<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Config
{
    static public function getCompanyId()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('company');
        
        return $config['id_company'];
    }
    
    static public function getSystemId()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('system');
        
        return $config['id_system'];
    }
    
    static public function getBinaryJava()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('binary');
        
        return $config['java_bin'];
    }
    
    static public function getJasperStarterFirebirdTT()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('jasperstarter');
        
        return $config['firebird']['terminal_terrestre'];
    }
    
    static public function getJasperStarterPostgresTT()
    {
        $MY =& MY_Controller::get_instance();
        
        $config = $MY->config->item('jasperstarter');
        
        return $config['postgres']['terminal_terrestre'];
    }
    
    
}