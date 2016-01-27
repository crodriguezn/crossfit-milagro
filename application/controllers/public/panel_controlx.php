<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Panel_ControlX extends MY_Controller
{
    protected $name_key = 'panel_control';
    
    
    function __construct()
    {
        parent::__construct(MY_Controller::SYSTEM_PUBLIC);

        
    }

    public function process($action) 
    {
        
        switch( $action )
        {
            case 'load-day':
                $this->loadDay();
                break;
            default:
                $this->noaction("No existe accion: $action");
                break;
        }
    }

    private function noaction($message)
    {
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess(FALSE);
        $resAjax->message($message);
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadDay()
    {
        $resAjax = new Response_Ajax();
        
        //$MY =& MY_Controller::get_instance();
      
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $resAjax->data('day', Helper_Fecha::getArrayDay($year, $month));
        
        echo $resAjax->toJsonEncode();
    }
}
