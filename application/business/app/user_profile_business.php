<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_User_Profile
{
    
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
                if(Business_App_Person::isValidDocument($ePerson->document))
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
    
    static public function uploadPictureProfile( $id_user, $field_name_post='profile' )
    {
        $oBus = new Response_Business();
        $MY = & MY_Controller::get_instance();
        
        /* @var $upload CI_Upload */
        $upload =& $MY->upload;
        
        try
        {
            $path_user = BASEPATH . '../resources/uploads/user';

            $path = "$path_user/$id_user";
            
            
            if( !file_exists($path) )
            {
                if( !mkdir($path, 0777, TRUE) )
                {
                    throw new Exception("Error al subir el archivo");
                }
            }
            

            $upload->initialize(array(
                'upload_path'   => $path,
                'allowed_types' => 'png',
                'max_width'     => '1080',
                'max_height'    => '1080',
                'max_size'      => '50000',
                'overwrite'     => TRUE,
                'is_image'      => TRUE,
                'file_name'     => 'profile',
                'image_width'   => '225',
                'image_height'  => '225',
                'image_type'    => 'png'
            ));

            $wasUploaded = $upload->do_upload( $field_name_post );

            if( !$wasUploaded )
            {
                throw new Exception( strip_tags( $upload->display_errors() ) );
            }
            
            $oBus->isSuccess(TRUE);
            $data = $upload->data();
            $oBus->data(array('data' => $data));
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        return $oBus;
    }
    
    static public function loadPictureProfile( $id_user=NULL )
    {
        $oBus = new Response_Business();
        
        $uri = '';
        try
        {
            if( empty($id_user) )
            {
                throw new Exception('Picture por defecto');
            }
            
            $uri = "resources/uploads/user/$id_user/profile.png";
            if( !file_exists( BASEPATH . '../' .$uri ) )
            {
                throw new Exception('Picture por defecto');
            }

            $oBus->isSuccess( TRUE );
        }
        catch( Exception $e )
        {
            $uri = "resources/img/nologo.png";
            
            $oBus->isSuccess( FALSE );
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array('uri' => $uri));
        
        return $oBus;
    }
    
    static public function unLinkPictureProfile( $id_user=NULL )
    {
        $oBus = new Response_Business();
        
        $uri = "resources/img/nologo.png";
        try
        {
            if( empty($id_user) )
            {
                throw new Exception('Ninguna Imagen a eliminar');
            }
            
            $path = BASEPATH . '../' ."resources/uploads/user/$id_user/profile.png";
            if( !file_exists($path) )
            {
                throw new Exception('Ninguna Imagen a eliminar');
            }
            
            if(!unlink($path))
            {
                throw new Exception('Ocurrio un error al tratar de eliminar la Imagen');
            }
            
            $oBus->isSuccess( TRUE );
        }
        catch( Exception $e )
        {
            $oBus->isSuccess( FALSE );
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array('uri' => $uri));
        
        return $oBus;
    }
    
    static public function loadUserProfile( $id_user )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mUserProfile User_Profile_Model */
        $mUserProfile =& $MY->mUserProfile;
        
        $eUserProfile = new eUserProfile();
        
        try
        {
            
            $eUserProfile = $mUserProfile->load($id_user, 'id_user');
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        $oBus->data(array(
            'eUserProfile' => $eUserProfile
        ));
        
        return $oBus;
    }
}
