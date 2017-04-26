<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Control_IMC extends MY_Form
{
    //CUSTOMER
    public $id_customer;
    
    //CONTROL DE BIOTIPO DE CUSTOMER
    public $weight;
    public $height;

    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        
        //CUSTOMER
        $this->id_customer          = 0;
        
        //CONTROL DE BIOTIPO DE CUSTOMER
        $this->weight               = 0;
        $this->height               = 0;
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        //CUSTOMER
        $this->id_customer          = $MY->input->post('id_customer');
        
        //CONTROL DE BIOTIPO DE CUSTOMER
        $this->weight               = $MY->input->post('weight');
        $this->height               = $MY->input->post('height');
        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        //CONTROL DE BIOTIPO
        if( empty($this->weight) )
        {
            $this->addError('weight', 'Campo no debe estar vacío');
        }
        else 
        {
            if(!is_numeric($this->weight) )
            {
                $this->addError('weight', 'Ingrese el peso en KG');
            }
        }
        
        if( empty($this->height) )
        {
            $this->addError('height', 'Campo no debe estar vacío');
        }
        else 
        {
            if(!is_numeric($this->height) )
            {
                $this->addError('height', 'Ingrese la altura en CM');
            }
        }
        
        return $this->isErrorEmpty();
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    //CONTROL IMC
    public function getControlIMC()
    {
        $eControlIMC = new eControlIMC(FALSE);
        
        $eControlIMC->id               = 0 ;
        $eControlIMC->id_customer      = $this->id_customer;
        $eControlIMC->weight           = $this->weight;
        $eControlIMC->height           = $this->height;
        $eControlIMC->update_date      = date('Y-m-d H:i:s');
        
        return $eControlIMC;
    }
    
    public function setControlIMC(eControlIMC $eControlIMC)
    {
        $this->id_customer      = $eControlIMC->id_customer;
        $this->weight           = $eControlIMC->weight;
        $this->height           = $eControlIMC->height;
    }
    
}
