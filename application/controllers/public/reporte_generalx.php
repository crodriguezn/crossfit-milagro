<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_GeneralX extends MY_Controller
{
    protected $name_key = 'reporte_general';
    
    
    function __construct()
    {
        parent::__construct(MY_Controller::SYSTEM_PUBLIC);

        
    }

    public function process($action) 
    {
        
        switch( $action )
        {
            case 'load-grupo':
                $this->loadGrupo();
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
    
    private function loadGrupo()
    {
        $resAjax = new Response_Ajax();
        
        //$MY =& MY_Controller::get_instance();
      
        $id_rpte = $this->input->post('id_rpte');
        $dataRpteGrupo = array();
        if($id_rpte=='RPTE_GRUPOS_CAMARAS')
        {
            $dataRpteGrupo = array(
                array(
                    'code' => '1',
                    'name' => 'Accesos al Terminal'
                ),
                array(
                    'code' => '2',
                    'name' => 'Baños'
                ),
                array(
                    'code' => '3',
                    'name' => 'Patio de Comidas'
                ),
                array(
                    'code' => '4',
                    'name' => 'Escaleras y Ascensores'
                ),
                array(
                    'code' => '5',
                    'name' => 'Torniquetes'
                )
            );
        }
        else
        {
            $dataRpteGrupo = array();
        }
        
        $resAjax->data('combo', $dataRpteGrupo);
        echo $resAjax->toJsonEncode();
    }
}
