<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Class_Date
{
    static public function listClassDate($txt_filter, $limit, $offset, $start=null, $end=null)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mClassDate Class_Date_Model */
        $mClassDate =& $MY->mClassDate;
        
        $eClassDates = array();
        $count = 0;
        try
        {
            $filter = new filterClassDate();
            
            $filter->limit      = $limit;
            $filter->offset     = $offset;
            $filter->text       = $txt_filter;
            $filter->start      = Helper_Fecha::getDateTime_By_Milliseconds($start, 'Y-m-d');
            $filter->end        = Helper_Fecha::getDateTime_By_Milliseconds($end, 'Y-m-d');
        
            $mClassDate->filter($filter, $eClassDates/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eClassDates'    => $eClassDates,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    static public function loadClassHour( $id_schedule )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mClassHour Class_Hour_Model */
        $mClassHour =& $MY->mClassHour;
        
        $eClassHour = new eClassHour();
        try
        {
            /* @var $eClassHour eClassHour  */
            $eClassHour = $mClassHour->load($id_schedule);
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array(
            'eClassHour' => $eClassHour
        ));
        
        return $oBus;
    }

    static public function saveClassHour(eClassHour $eClassHour )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mClassHour Class_Hour_Model */
        $mClassHour =& $MY->mClassHour;
        
        /* @var $mClassScheduling Class_Scheduling_Model */
        $mClassScheduling =& $MY->mClassScheduling;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            
            $eClassHourT = $mClassHour->loadArray(array('start_hour'=>$eClassHour->start_hour, 'final_hour'=>$eClassHour->final_hour), $eClassHour->id);
            
            if( !$eClassHourT->isEmpty() )
            {
                throw new Exception('Horario de Clase Existente');
            }
            if($eClassHour->isActive==FALSE)
            {
                $mClassScheduling->updateIsActiveByIDClassHour($eClassHour->id, $eClassHour->isActive, date('Y-m-d'));
            }
            
            
            $mClassHour->save($eClassHour);
            
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
