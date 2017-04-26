<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Class_Scheduling extends MY_Form
{
    public $id_schedule;
    public $name;
    public $start_day;
    public $isActive;
    public $arrData;
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->id_schedule      = 0;
        $this->name             = 'Clase';
        $this->start_day        = '';
        $this->isActive         = 1;
        $this->arrData          = array();
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->id_schedule      = $MY->input->post('id_schedule');
        $this->name             = $MY->input->post('name');
        $this->start_day        = $MY->input->post('start_day');
        $this->isActive         = $MY->input->post('isActive');
        $this->arrData          = $MY->input->post('arrData');
        $this->id_form          = $MY->input->post('id_form');
        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->name) )
        {
            $this->addError('name', 'Campo no debe estar vacío');
        }
        
        if (empty($this->start_day)) 
        {
            $this->addError('start_day', 'Campo no debe estar vacío');
        }
        else
        {
            if(Helper_Fecha::validar_fecha($this->start_day) === false)
            {
                $this->addError('start_day', 'Ingrese una fecha válida');
            }
        }     
        
        return $this->isErrorEmpty();
    }
    
       
    public function getClassDateEntity()
    {
        $eClassDate = new eClassDate(FALSE);
        
        $eClassDate->start_day = $this->start_day;
        $eClassDate->name   = $this->name;
        
        return $eClassDate;
    }
        
    public function setClassDateEntity(eClassDate $eClassDate)
    {
        $this->start_day = $eClassDate->start_day;
        $this->name =$eClassDate->name;
    }
    
    public function getClassSchedulingEntities()
    {
        $eClassSchedulings = array();
                  
        if( !empty($this->arrData) )
        {
            foreach( $this->arrData as $data ) 
            {

                $eClassScheduling                   = new eClassScheduling(FALSE);
                $eClassScheduling->id_class_hour    = $data['id_hour'];
                $eClassScheduling->isActive         = $data['isActive'];
                $eClassScheduling->id_employee      = $data['id_coach'];

                $eClassSchedulings[]=$eClassScheduling;
            }
        }
        
        return $eClassSchedulings;
    }  
    
    public function setClassSchedulingEntities( $eClassSchedulings )
    {
        if( !empty($eClassSchedulings) )
        {
            /* @var $eClassScheduling eClassScheduling */
            foreach( $eClassSchedulings as $eClassScheduling )
            {
                $this->arrData[] = array( 
                                            'id_hour' => $eClassScheduling->id_class_hour,
                                            'id_coach'=> $eClassScheduling->id_employee,
                                            'isActive'=> $eClassScheduling->isActive
                                    );
            }
        }
    }
    
    
    
    
}
