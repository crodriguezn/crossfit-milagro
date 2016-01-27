<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_ResumenX extends MY_Controller
{
    protected $name_key = 'reporte_resumen';
    
    
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
        if($id_rpte=='RPTE_RESUMEN_GRUPOS_CAMARAS')
        {
            $dataRpteGrupo = array(
                array(
                    'code' => '1',
                    'name' => 'Accesos generales'
                ),
                array(
                    'code' => '2',
                    'name' => 'Viajeros arriban'
                ),
                array(
                    'code' => '3',
                    'name' => 'Corredores'
                ),
                array(
                    'code' => '4',
                    'name' => 'Escaleras Electricas'
                ),
                array(
                    'code' => '5',
                    'name' => 'Ascensores'
                ),
                array(
                    'code' => '6',
                    'name' => 'Patio de Comidas'
                ),
                array(
                    'code' => '7',
                    'name' => 'Baños'
                ),
                array(
                    'code' => '8',
                    'name' => 'Resumen de Torniquetes'
                ),
                array(
                    'code' => '9',
                    'name' => 'Resumen General'
                ),
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
