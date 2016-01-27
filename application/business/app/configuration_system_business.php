<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Configuration_System
{
    static public function loadConfigurationSystem( $id_config )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mConfigurationSystem Configuration_System_Model */
        $mConfigurationSystem =& $MY->mConfigurationSystem;
        
        /* @var $eConfigurationSystem eConfigurationSystem */
        $eConfigurationSystem = $mConfigurationSystem->load( $id_config );
        
        $oBus->isSuccess( !$eConfigurationSystem->isEmpty() );
        $oBus->message( $eConfigurationSystem->isEmpty() ? 'Nada de Información que mostrar' : '' );
        $oBus->data(array(
            'eConfigurationSystem' => $eConfigurationSystem
        ));
        
        return $oBus;
    }
    
    
    static public function saveConfigurationSystem( eConfigurationSystem $eConfigurationSystem )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();

        /* @var $mConfigurationSystem Configuration_System_Model */
        $mConfigurationSystem =& $MY->mConfigurationSystem;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            
            $mConfigurationSystem->save($eConfigurationSystem);
            
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
    
    static public function uploadLogo( $id_system, $field_name_post='logo' )
    {
        $oBus = new Response_Business();
        $MY = & MY_Controller::get_instance();
        
        /* @var $upload CI_Upload */
        $upload =& $MY->upload;
        
        try
        {
            $path_system = BASEPATH . '../resources/uploads/system/logo';

            $path = "$path_system/$id_system";
            
            
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
                'file_name'     => 'logo',
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
    
    static public function loadLogo( $id_system=NULL )
    {
        $oBus = new Response_Business();
        
        $uri = '';
        try
        {
            if( empty($id_system) )
            {
                throw new Exception('Logo por defecto');
            }
            
            $uri = "resources/uploads/system/logo/$id_system/logo.png";
            if( !file_exists( BASEPATH . '../' .$uri ) )
            {
                throw new Exception('Logo por defecto');
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
    
}