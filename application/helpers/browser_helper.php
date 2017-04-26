<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Browser
{

    static public function getBrowser( $isInit = TRUE )
    {
        $MY =& MY_Controller::get_instance();
        
        //$browser_message=array('isSuccess'=>FALSE);
        
        $navegador = ($isInit) ? get_browser() : $MY->libbrowscap->get_browser_local();
        
        return $navegador;
    }
    
    static public function isIExplorer( $isInit = TRUE)
    {
        $MY =& MY_Controller::get_instance();
        
        $browser_message = array('isSuccess'=>FALSE);
        
        $navegador = ($isInit) ? get_browser() : $MY->libbrowscap->get_browser_local();
        if($navegador->browser == 'IE')
        {
            $browser_message['isSuccess']   = TRUE;
            $browser_message['message']     = 'Este sitio web esta recomendado para trabajar con <a target="_blank" href="https://www.mozilla.org/es-ES/firefox/new/">Firefox</a> o <a target="_blank" href="https://www.google.com.mx/chrome/browser/desktop/">Chrome</a>.';
        }
        else
        {
            $browser_message['isSuccess']   = FALSE;
            $browser_message['message']     = '';
        }
        
        return $browser_message;
    }
    
}
