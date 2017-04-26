<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Employee
{
    
    
    static public function saveEmployee( eEmployee $eEmployee )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mPerson Person_Model */
        $mPerson =& $MY->mPerson;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            
            $ePersonT = $mPerson->load($ePerson->id);
            if(!Helper_App_Session::isAdminProfile() || !Helper_App_Session::isSuperAdminProfile())
            {
                if(self::isValidDocument($ePerson->document))
                {
                    throw new Exception('Documento Invalido: ' + $ePerson->document);
                }

                if($ePersonT->tipo_documento != $ePerson->tipo_documento)
                {
                    throw new Exception('No tiene permisos para editar el tipo de documento');
                }

                if($ePersonT->document != $ePerson->document)
                {
                    throw new Exception('No tiene permisos para editar el documento');
                }
            }
            
            $ePersonDocument = $mPerson->loadByDocument($ePerson->document, $ePerson->id);
            if(!$ePersonDocument->isEmpty())
            {
                throw new Exception('Documento Existente: ' + $ePerson->document);
            }
            
            $mPerson->save($ePerson);
            
            $oBus->isSuccess(TRUE);
            
            $oBus->message("Guardado exitosamente");
            
            $oTransaction->commit();
        }
        catch( Exception $e )
        {
            $oTransaction->rollback();
            $oBus->isSuccess(FALSE);
            $oBus->message($e->getMessage());
        }
        
        return $oBus;
    }
    
    static public function loadEmployee( $id_binnacle )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mUserLog User_Log_Model */
        $mUserLog =& $MY->mUserLog;
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        /* @var $eUserLog eUserLog  */
        $eUserLog = $mUserLog->load( $id_binnacle );
        
        /* @var $eUserLog eUserLog  */
        $eUser = $mUser->load( $eUserLog->id_user );
        
        $oBus->isSuccess( !$eUserLog->isEmpty() );
        $oBus->data(array(
            'eUserLog'  => $eUserLog,
            'eUser'     => $eUser
        ));
        
        return $oBus;
    }
    
    static public function listEmployee($txt_filter, $limit, $offset, $isCoach=NULL)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mEmployee Employee_Model */
        $mEmployee =& $MY->mEmployee;
        
        $eEmployees = array();
        $ePersons = array();
        $count = 0;
        try
        {
            $filter = new filterEmployee();
            
            $filter->limit      = $limit;
            $filter->offset     = $offset;
            $filter->text       = $txt_filter;
            $filter->isCoach    = $isCoach;
        
            $mEmployee->filter($filter, $eEmployees/*REF*/, $ePersons/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eEmployees'    => $eEmployees,
            'ePersons'      => $ePersons,
            'count'         => $count
        ));
        
        return $oBus;
    }
}
