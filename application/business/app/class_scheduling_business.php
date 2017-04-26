<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Class_Scheduling
{
    static public function loadClassScheduling( $start_day )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mClassScheduling Class_Scheduling_Model */
        $mClassScheduling =& $MY->mClassScheduling;
        
        /* @var $mClassDate Class_Date_Model */
        $mClassDate =& $MY->mClassDate;
        
        try
        {
            $eClassDate = $mClassDate->load($start_day, 'start_day');
            $mClassScheduling->listClassProgramation_By_IdClassDate($eClassDate->isEmpty() ? 0:$eClassDate->id, $eClassSchedulings/*REF*/);
        
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array(
            'eClassDate' => $eClassDate,
            'eClassSchedulings' => $eClassSchedulings
        ));
        
        return $oBus;
        
    }
    
    static public function listProgrammingClass($txt_filter, $limit, $offset, $start=null, $end=null, $id_employee=NULL, $isActive=NULL)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mClassScheduling Class_Scheduling_Model */
        $mClassScheduling =& $MY->mClassScheduling;
        
        $eClassSchedulings  = array();
        $eClassHours        = array();
        $eClassDates        = array();
        $eEmployees         = array();
        $ePersons           = array();
        $count = 0;
        try
        {
            $filter = new filterClassScheduling();
            
            $filter->limit = $limit;
            $filter->offset = $offset;
            $filter->text = $txt_filter;
            $filter->start = Helper_Fecha::getDateTime_By_Milliseconds($start, 'Y-m-d');
            $filter->end = Helper_Fecha::getDateTime_By_Milliseconds($end, 'Y-m-d');
            $filter->id_employee = $id_employee;
            $filter->isActive = $isActive;
        
            $mClassScheduling->filter($filter, $eClassSchedulings/*REF*/, $eClassHours/*REF*/, $eClassDates/*REF*/, $eEmployees/*REF*/, $ePersons/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(
                    array(
                            'eClassSchedulings' => $eClassSchedulings,
                            'eClassHours'       => $eClassHours,
                            'eClassDates'       => $eClassDates,
                            'eEmployees'        => $eEmployees,
                            'ePersons'          => $ePersons,
                            'count'             => $count
                    )
                );
        
        return $oBus;
    }
    
    static public function saveClassScheduling(eClassDate $eClassDate, $eClassSchedulings )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mClassDate Class_Date_Model */
        $mClassDate =& $MY->mClassDate;
        
        /* @var $mClassScheduling Class_Scheduling_Model */
        $mClassScheduling =& $MY->mClassScheduling;
        
        /* @var $mClassHour Class_Hour_Model */
        $mClassHour =& $MY->mClassHour;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            
            $eClassDateT = $mClassDate->load($eClassDate->start_day, 'start_day');
            
            /*if( !$eClassDateT->isEmpty() )
            {
                throw new Exception('Clase Existente');
            }*/
            $eClassDate->id = $eClassDateT->id;
            $mClassDate->save($eClassDate);
            
            $mClassScheduling->updateIsActiveByIDClassDate($eClassDate->id, 0);
            
            if( !empty($eClassSchedulings) )
            {
                /* @var $eClassScheduling eClassScheduling */
                foreach( $eClassSchedulings as $eClassScheduling )
                {
                    
                    $eClassSchedulingT = $mClassScheduling->loadArray(array('id_class_date' => $eClassDate->id, 'id_class_hour' =>$eClassScheduling->id_class_hour));
                    
                    if($eClassSchedulingT->isEmpty())
                    {
                        $eClassScheduling->id_class_date = $eClassDate->id;
                        $mClassScheduling->save($eClassScheduling);
                    }
                    else 
                    {
                        $eClassSchedulingT->isActive = $eClassScheduling->isActive;
                        $eClassSchedulingT->id_employee = $eClassScheduling->id_employee;
                        $mClassScheduling->save($eClassSchedulingT);
                    }
                }
            }
            
            
            $oTransaction->commit();
            
            $oBus->isSuccess(TRUE);
            $oBus->message("Guardado exitosamente");
        }
        catch( Exception $e )
        {
            $oTransaction->rollback();
            
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        return $oBus;
    } 
}