<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Person
{
    static public function isValidDocument( $document, $useFake=TRUE )
    {
        
        $arr = array('0000000000','0999999999');
        
        if( $useFake )
        {
            $arr[] = '0000000001';
        }
        
        return !in_array($document, $arr) && !empty($document);
    }
    
    static public function loadByDocument( $document )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mPerson Person_Model */
        $mPerson =& $MY->mPerson;
        
        $ePerson = new ePerson();
        try
        {
            /* @var $ePerson ePerson  */
            $ePerson = $mPerson->loadByDocument($document);
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array(
            'ePerson' => $ePerson
        ));
        
        return $oBus;
    }
    
    static public function loadByPersonId( $id_person )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mPerson Person_Model */
        $mPerson =& $MY->mPerson;
        
        $ePerson = new ePerson();
        try
        {
            /* @var $ePerson ePerson  */
            $ePerson = $mPerson->load($id_person);
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array(
            'ePerson' => $ePerson
        ));
        
        return $oBus;
    }
    
    static public function savePerson( ePerson $ePerson )
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
}
