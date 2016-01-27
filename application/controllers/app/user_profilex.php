<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_ProfileX extends MY_Controller
{
    protected $name_key = 'user_profile';
    
    /* @var $permission User_Profile_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/user_profile/permission.php');
        $this->permission = new User_Profile_Permission( $this->name_key );
        $this->permission->update = Helper_App_Session::isPermissionForModule($this->name_key,'update');
        
    }

    public function process( $action )
    {
        if( !Helper_App_Session::isLogin() )
        {
            $this->noaction('Fuera de sesión');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->noaction('Fuera de sesión por Inactividad');
            return;
        }
        
        if( Helper_App_Session::isBlock() )
        {
            $this->noaction('Fuera de session por Bloqueo');
            return;
        }
        
        if( !$this->permission->access )
        {
            $this->noaction('Acceso no permitido');
            return;
        }

        switch( $action )
        {
            case 'load-profile':
                $this->loadProfile();
                break;
            case 'load-components':
                $this->loadComponents();
                break;
            case 'load-pais':
                $this->loadPais();
                break;
            case 'load-provincia':
                $this->loadProvincia();
                break;
            case 'load-ciudad':
                $this->loadCiudad();
                break;
            case 'save-profile':
                $this->saveProfile();
                break;
            case 'upload-picture-profile':
                $this->uploadPictureProfile();
                break;
            case 'load-picture-profile':
                $this->loadPictureProfile();
                break;
            case 'delete-picture-profile':
                $this->deletePictureProfile();
                break;
            case 'save-user':
                $this->saveUser();
                break;
            default:
                $this->noaction($action);
                break;
        }
    }
    
    private function noaction($action)
    {
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess(FALSE);
        $resAjax->message("No found action: $action");
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadProfile()
    {
        $this->load->file('application/modules/app/user_profile/form/profile_form.php');
        
        $resAjax = new Response_Ajax();
        
        $id_person = Helper_App_Session::getPersonId();
        
        $oBus = Business_App_Person::loadByPersonId($id_person);
        
        $data = $oBus->data();
        
        /* @var $ePerson ePerson  */
        $ePerson    = $data['ePerson'];
        
        $frm_data = new Form_App_Profile();
        
        $frm_data->setPersonEntity($ePerson);
        
        /* @var $eCiudad eCiudad */
        $oBus1 = Business_App_Ciudad::loadCiudad($ePerson->id_ciudad, $eCiudad/*REF*/);
        
        $frm_data->id_provincia = $eCiudad->id_provincia;
        $frm_data->id_pais = $eCiudad->id_pais;
       
        $id_profile = Helper_App_Session::getProfileId();
        
        $oBusP = Business_App_Profile::loadProfile($id_profile);
        $dataProfile = $oBusP->data();
        $eProfile = $dataProfile['eProfile'];
        $frm_data->name_profile = $eProfile->name;
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->form('profile', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadComponents ()
    {
        $resAjax = new Response_Ajax();
        
        $arrType = array('TIPO_IDENT','ESTADO_CIVIL','GENDER', 'TIPO_DE_SANGRE');
        
        try
        {
            $oBus = Business_App_Catalog::listByType($arrType);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $eCatalogs = $oBus->data('eCatalogs');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data($eCatalogs);
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadPais()
    {
        $resAjax = new Response_Ajax();
        try
        {
            $oBus = Business_App_Pais::listPais($ePaises/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_pais = Helper_Array::entitiesToIdText($ePaises, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-pais' => $combo_pais
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadProvincia()
    {
        $resAjax = new Response_Ajax();
        
        $id_pais = $this->input->post('id_pais');
        
        try
        {
            $oBus = Business_App_Provincia::listProvincia($id_pais, $eProvincias/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_provincia = Helper_Array::entitiesToIdText($eProvincias, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-provincia' => $combo_provincia
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadCiudad()
    {
        $resAjax = new Response_Ajax();
        
        $id_provincia = $this->input->post('id_provincia');
        
        try
        {
            $oBus = Business_App_Ciudad::listCiudad($id_provincia, $eCiudades/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_ciudad = Helper_Array::entitiesToIdText($eCiudades, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-ciudad' => $combo_ciudad
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveProfile()
    {
        $this->load->file('application/modules/app/user_profile/form/profile_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_Profile(TRUE);
        
        try
        {
            
            if( !$this->permission->update )
            {
                throw new Exception('No tiene permisos para editar/actualizar');
            }
            
            if( !$frm_data->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $ePerson = $frm_data->getPersonEntity();
            $ePerson->id = Helper_App_Session::getPersonId();

            $oBus = Business_App_User_Profile::savePerson($ePerson);
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }

            $resAjax->isSuccess(TRUE);
            $resAjax->message($oBus->message());
        }
        catch( Exception $ex )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message($ex->getMessage());
            $resAjax->form('profile', $frm_data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function uploadPictureProfile()
    {
        $resAjax = new Response_Ajax();
        
        $id_user = Helper_App_Session::getUserId();
        $field_name_post = "profile";
        
        $oBus = Business_App_User_Profile::uploadPictureProfile($id_user, $field_name_post);
        $oBusLoad = Business_App_User_Profile::loadPictureProfile($id_user);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->isSuccess() ? 'Subida con Exito': $oBus->message() );
        $resAjax->data( array($oBus->data(),$oBusLoad->data()) );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadPictureProfile()
    {
        $resAjax = new Response_Ajax();
        
        $id_user = Helper_App_Session::getUserId();
        
        $oBus = Business_App_User_Profile::loadPictureProfile($id_user);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->isSuccess() ? 'Subida con Exito': $oBus->message() );
        $resAjax->data( $oBus->data() );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function deletePictureProfile()
    {
        $resAjax = new Response_Ajax();
        
        $id_user = Helper_App_Session::getUserId();
        
        $oBus = Business_App_User_Profile::unLinkPictureProfile($id_user);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->isSuccess() ? 'Imagen Eliminada con Exito': $oBus->message() );
        $resAjax->data( $oBus->data() );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveUser()
    {
        $this->load->file('application/modules/app/user_profile/form/user_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_User(TRUE);
        
        try
        {
            
            if( !$this->permission->update )
            {
                throw new Exception('No tiene permisos para editar/actualizar');
            }
            
            if( !$frm_data->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            $oBus = Business_App_User::loadUser( Helper_App_Session::getUserId() );
            $data = $oBus->data();
            $eUser = $data['eUser'];
            
            $oBus = Business_App_User::login($eUser->username, $frm_data->password_current);
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception( 'Contraseña Incorrecta' );
            }
            
            $oBus = Business_App_User::updatePassword($eUser->id, $frm_data->password_new_repeat);
            
            $resAjax->isSuccess(TRUE);
            $resAjax->message('Contraseña Actualizada');
        }
        catch( Exception $ex )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message($ex->getMessage());
            $resAjax->form('user', $frm_data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
}