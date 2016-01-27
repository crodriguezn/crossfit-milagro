<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Company 
{
    static public function loadCompany( $id_company )
    {
        $oBus = new Response_Business();
        
        $MY = & MY_Controller::get_instance();
        
        /* @var $mCompany Company_Model  */
        $mCompany =& $MY->mCompany;
        
        /* @var $eCompany eCompany  */
        $eCompany = $mCompany->load( $id_company );

        $oBus->isSuccess( !$eCompany->isEmpty() );
        $oBus->message( $eCompany->isEmpty() ? 'No existe informaciòn para la empresa' : '' );
        
        $oBus->data(array('eCompany'  => $eCompany));
        
        return $oBus;
        
    }

    static public function saveCompany( eCompany $eCompany )
    {
        $oBus = new Response_Business();
        
        $MY = & MY_Controller::get_instance();
        
        /* @var $mCompany Company_Model */
        $mCompany = & $MY->mCompany;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try 
        {
            $mCompany->save($eCompany);
            
            $oTransaction->commit();
            
            $oBus->isSuccess(TRUE);
            
            $oBus->message("Guardado exitosamente");
            
            
        } 
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message($e->getMessage());
            $oTransaction->rollback();
        }
        
        return $oBus;
    }

    static public function uploadLogo( $id_company, $field_name_post='logo' )
    {
        $oBus = new Response_Business();
        $MY = & MY_Controller::get_instance();
        
        /* @var $upload CI_Upload */
        $upload =& $MY->upload;
        
        try
        {
            $path_company = BASEPATH . '../resources/uploads/company';

            $path = "$path_company/$id_company";

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
    
    static public function loadLogo( $id_company=NULL )
    {
        $oBus = new Response_Business();
        
        $uri = '';
        try
        {
            if( empty($id_company) )
            {
                throw new Exception('Logo por defecto');
            }
            
            $uri = "resources/uploads/company/$id_company/logo.png";
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
