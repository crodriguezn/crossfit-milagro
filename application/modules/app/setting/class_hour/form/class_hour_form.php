<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Setting_Class_Hour extends MY_Form
{
    public $id_schedule;
    public $start_hour;
    public $final_hour;
    public $isActive;
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->id_schedule  = 0;
        $this->start_hour   = '';
        $this->final_hour   = '';
        $this->isActive     = 1;
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();

        $this->id_schedule      = $MY->input->post('id_schedule');
        $this->start_hour       = trim($MY->input->post('start_hour'));
        $this->final_hour       = trim($MY->input->post('final_hour'));
        $this->isActive         = $MY->input->post('isActive');
        $this->id_form          = $MY->input->post('id_form');
        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->start_hour) )
        {
            $this->addError('start_hour', 'Campo no debe estar vacío');
        }
        else
        {
            if(!Helper_Fecha::isValidHour($this->start_hour))
            {
                $this->addError('start_hour', 'Formato de Hora no valida (hh:ii)');
            }
        }
        
        if( empty($this->final_hour) )
        {
            $this->addError('final_hour', 'Campo no debe estar vacío');
        }    
        else
        {
            if(!Helper_Fecha::isValidHour($this->final_hour))
            {
                $this->addError('final_hour', 'Formato de Hora no valida (hh:ii)');
            }
        }
        
        
        return $this->isErrorEmpty();
    }
    
    public function getScheduleEntity()
    {
        $eClassHour = new eClassHour(FALSE);
        
        $eClassHour->id          = $this->id_schedule;
        $eClassHour->start_hour  = $this->start_hour;
        $eClassHour->final_hour  = $this->final_hour;
        $eClassHour->isActive    = $this->isActive;
        
        return $eClassHour;
    }
    
    public function setScheduleEntity(eClassHour $eClassHour )
    {
        $this->id_schedule  = empty($eClassHour->id) ? 0 : $eClassHour->id;
        $this->start_hour   = $eClassHour->start_hour;
        $this->final_hour   = $eClassHour->final_hour;
        $this->isActive     = $eClassHour->isActive;
    }   
   
}
