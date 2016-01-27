<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Public_View
{
    static private $htmlTitle = "Sistema Reporteria FTT";

    static function view( $view, $arrParams=array(), $return=FALSE )
    {
        $MY =& MY_Controller::get_instance();
        
        $arrParamsLayoutDefault = array(
            'layout_title'=>self::$htmlTitle,
        );
        
        if( $return )
        {
            return $MY->load->view($view, array_merge($arrParamsLayoutDefault,$arrParams), TRUE);
        }
        
        $MY->load->view($view, array_merge($arrParamsLayoutDefault,$arrParams));
        
    }

    static function layout( $view/* string OR array strings */, $arrParams=array(), $arrParamsLayout=array(), $useIframe=FALSE)
    {
        $MY =& MY_Controller::get_instance();
        
        $resources_path = 'resources/assets/app';
        
        $controller_current = $MY->uri->rsegment(1);
        $function_current   = $MY->uri->rsegment(2);
        
        $content = '';
        if( is_array($view) )
        {
            foreach( $view as $v )
            {
                $content .= $MY->load->view($v, $arrParams, true);
            }
        }
        else
        {
            $content = $MY->load->view($view, $arrParams, true);
        }
        
        $browser_message = Helper_App_Browser::obtener_browser();
        
        $arrParamsLayoutDefault = array(
            'useIframe' => $useIframe,
            'resources_path' => $resources_path,
            'content' => $content,
            'controller_current' => $controller_current,
            'function_current' => $function_current,
            'navegador' => $browser_message
        );

        $MY->load->view('public/html/layout/layout', array_merge( $arrParamsLayoutDefault, $arrParamsLayout));
    }
}