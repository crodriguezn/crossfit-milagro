<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_Customer_CrossfitX extends MY_Controller
{
    protected $name_key = 'setting_customer_crossfit';
    
    /* @var $permission Setting_Customer_Crossfit_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/setting/customer_crossfit/permission.php');
        $this->permission = new Setting_Customer_Crossfit_Permission( $this->name_key );
        $this->permission->create = Helper_App_Session::isPermissionForModule($this->name_key,'create');
        $this->permission->update = Helper_App_Session::isPermissionForModule($this->name_key,'update');
        $this->permission->access_imc = Helper_App_Session::isPermissionForModule($this->name_key,'access_imc');
        $this->permission->create_imc = Helper_App_Session::isPermissionForModule($this->name_key,'create_imc');
        
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
            case 'list-customer-crossfit':
                $this->listCustomerCrossfit();
                break;
            case 'list-control-imc':
                $this->listControlIMC();
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
            case 'load-customer-crossfit':
                $this->loadCustomerCrossfit();
                break;
            case 'load-person-by-document':
                $this->loadPersonByDocument();
                break;
            case 'save-customer-crossfit':
                $this->saveCustomerCrossfit();
                break;
            case 'save-control-imc':
                $this->saveControlIMC();
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
    
    private function listCustomerCrossfit()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter = $this->input->get('sSearch');
        $limit      = $this->input->get('iDisplayLength');
        $offset     = $this->input->get('iDisplayStart');
        
        $oBus = Business_App_Customer_Crossfit::listCustomerCrossfit($txt_filter, $limit, $offset);
        $data = $oBus->data();

        $eCustomers = $data['eCustomers'];
        $ePersons   = $data['ePersons'];
        $eCiudades  = $data['eCiudades'];
        $count      = $data['count'];
        
        $aaData = array();
        
        if( !empty($eCustomers) )
        {
            
            /* @var $eCustomer eCustomer */
            foreach( $eCustomers as $num => $eCustomer )
            {
                $oBusU = Business_App_User::loadUserByIdPerson($ePersons[$num]->id);
                $dataU = $oBusU->data();
                $eUser = $dataU['eUser'];
                
                $oBusP = Business_App_User_Profile::loadPictureProfile($eUser->id);
                
                $dataP = $oBusP->data();
                $path = $dataP['uri'];
                
                if(!$oBusP->isSuccess())
                {
                    if($ePersons[$num]->gender=='GENDER_MALE')
                    {
                        $path = "resources/img/crossfit_men.png";
                    }
                    else
                    {
                        $path = "resources/img/crossfit_women.png";
                    }
                }
                
                $aaData[] = array( 
                        array( 
                                'path' => $path, 
                                'title' => (trim($ePersons[$num]->surname).' '.trim($ePersons[$num]->name)) 
                            ),
                        trim($eCustomer->code), 
                        trim($ePersons[$num]->document), 
                        (trim($ePersons[$num]->surname).' '.trim($ePersons[$num]->name)), 
                        array(
                                'birthday'          => Helper_Fecha::setFomratDate($ePersons[$num]->birthday),
                                'registration_date' => Helper_Fecha::setFomratDate($eCustomer->registration_date), 
                                'location'          => $eCiudades[$num]->nombre
                            ), 
                        //trim($eCustomer->id) 
                        array(
                                'person'    => (trim($ePersons[$num]->surname).' '.trim($ePersons[$num]->name)),
                                'id'        => $eCustomer->id
                            )
                    );
            }
        }
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
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
            
            $oBus1 = Business_App_Profile::listProfile('', NULL, NULL);
            
            $dataCatalogo = $oBus->data();
            $eCatalogs = $dataCatalogo['eCatalogs'];
            $dataProfile = $oBus1->data();
            $eProfiles = $dataProfile['eProfiles'];
            $eProfiles = Helper_Array::entitiesToIdText($eProfiles, 'id', 'name', 'value', 'text');
            
            $oBus2 = Business_App_Company_Branch::listByCompany(Helper_App_Session::getCompanyId(), 1);
            $dataCompanyBranch = $oBus2->data();
            $eCompanyBranches = $dataCompanyBranch['eCompanyBranchs'];
            $eCompanyBranches = Helper_Array::entitiesToIdText($eCompanyBranches, 'id', 'name', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(array('eCatalogs'=>$eCatalogs,'eProfiles'=>$eProfiles,'eCompanyBranches'=>$eCompanyBranches));
        
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
    
    private function loadCustomerCrossfit()
    {
        $this->load->file('application/modules/app/setting/customer_crossfit/form/customer_crossfit_form.php');
        
        $frm_data = new Form_App_Setting_Customer_Crossfit();
        
        $resAjax = new Response_Ajax();
        
        $frm_data->setIdForm(0);
        
        $id_customer = $this->input->post('id_customer');
        
        try 
        {
            /*____________________________________________________________*/
            //CUSTOMER
            $oBusCustomer = Business_App_Customer_Crossfit::loadCustomer($id_customer);
            if(!$oBusCustomer->isSuccess())
            {
                throw new Exception($oBusUser->message());
            }
            
            $dataCustomer = $oBusCustomer->data();

            /* @var $eCustomer eCustomer  */
            $eCustomer   = $dataCustomer['eCustomer'];
            
            /*____________________________________________________________*/
            //PERSON
            $oBusPerson = Business_App_Person::loadByPersonId($eCustomer->id_person);

            if(!$oBusPerson->isSuccess())
            {
                throw new Exception($oBusPerson->message());
            }
            
            $dataPerson = $oBusPerson->data();

            /* @var $ePerson ePerson  */
            $ePerson   = $dataPerson['ePerson'];
            
            /*____________________________________________________________*/
            //USER
            $oBusUser = Business_App_User::loadUserByIdPerson( $ePerson->id );
            if(!$oBusUser->isSuccess())
            {
                throw new Exception($oBusUser->message());
            }
            
            $dataUser = $oBusUser->data();

            /* @var $eUser eUser  */
            $eUser   = $dataUser['eUser'];
            
            /*____________________________________________________________*/
            //USER_PROFILE
            $oBusUserProfile = Business_App_User_Profile::loadUserProfileByIDUser_IDProfile($eUser->id, 2);
            
            if(!$oBusUserProfile->isSuccess())
            {
                throw new Exception($oBusUserProfile->message());
            }
            
            $dataUserProfile = $oBusUserProfile->data();

            /* @var $eUserProfile eUserProfile  */
            $eUserProfile   = $dataUserProfile['eUserProfile'];
            
            //COMPANY_BRANCH
            $oBusCompanyBranch = Business_App_Customer_Crossfit::listCompanyBranchsByUserProfile($eUserProfile->id_user, $eUserProfile->id_profile);
            
            if(!$oBusCompanyBranch->isSuccess())
            {
                throw new Exception($oBusCompanyBranch->message());
            }
            
            $dataCompanyBranchs = $oBusCompanyBranch->data();

            $eCompanyBranchs   = $dataCompanyBranchs['eCompanyBranchs'];
            
            /*____________________________________________________________*/
            //PROFILE PICTURE
            $oBusIMG = Business_App_User_Profile::loadPictureProfile($eUser->id);
            $dataPicture = $oBusIMG->data();

            $pathPicture   = $dataPicture['uri'];
            
            $frm_data->setCustomer($eCustomer);
            $frm_data->setUserEntity($eUser);
            $frm_data->setPersonEntity($ePerson);
            $frm_data->setUserProfileEntity($eUserProfile);
            $frm_data->setUserProfile_CompanyBranchEntity($eCompanyBranchs);
            $frm_data->setPath($pathPicture);
            $resAjax->isSuccess( TRUE );
        
        } 
        catch (Exception $exc) 
        {
            $resAjax->isSuccess( FALSE );
            $resAjax->message( $exc->getMessage() );
        }

        $resAjax->form('customer', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveCustomerCrossfit()
    {
        $this->load->file('application/modules/app/setting/customer_crossfit/form/customer_crossfit_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_Setting_Customer_Crossfit(TRUE);
        $id_form = Helper_Encrypt::decode($frm_data->id_form);
        try
        {
            
            if(empty($id_form) &&( !$this->permission->create ))
            {
                throw new Exception('No tiene permisos para crear/nuevo');
            }
            elseif(!empty($id_form)&&( !$this->permission->update ))
            {
                throw new Exception('No tiene permisos para editar/actualizar');
            } 
            
            if( !$frm_data->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $eCustomer = $frm_data->getCustomer();
            $ePerson = $frm_data->getPersonEntity();
            $eUser = $frm_data->getUserEntity();
            $eUserProfile = $frm_data->getUserProfileEntity();
            $eUserProfile_CompanyBranches = $frm_data->getUserProfile_CompanyBranchEntity();

            $oBus = Business_App_Customer_Crossfit::saveCustomer($eCustomer, $ePerson, $eUser, $eUserProfile, $eUserProfile_CompanyBranches);
            
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
            $resAjax->form('customer', $frm_data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadPersonByDocument()
    {
        $this->load->file('application/modules/app/setting/customer_crossfit/form/customer_crossfit_form.php');
        
        $frm_data = new Form_App_Setting_Customer_Crossfit();
        
        $resAjax = new Response_Ajax();
        
        $document = $this->input->post('document');
        try 
        {
            
            //PERSON
            $oBusPerson = Business_App_Person::loadByDocument($document);

            if(!$oBusPerson->isSuccess())
            {
                throw new Exception($oBusPerson->message());
            }
            
            $dataPerson = $oBusPerson->data();

            /* @var $ePerson ePerson  */
            $ePerson   = $dataPerson['ePerson'];
            
            
            //USER
            $oBusUser = Business_App_User::loadUserByIdPerson($ePerson->id);
            if(!$oBusUser->isSuccess())
            {
                throw new Exception($oBusUser->message());
            }
            
            $dataUser = $oBusUser->data();

            /* @var $eUser eUser  */
            $eUser   = $dataUser['eUser'];
            
            $frm_data->setUserEntity($eUser);
            $frm_data->setPersonEntity($ePerson);
            
            if(!$eUser->isEmpty())
            {
                //USER_PROFILE
                $oBusUserProfile = Business_App_User_Profile::loadUserProfile($eUser->id);

                if(!$oBusUserProfile->isSuccess())
                {
                    throw new Exception($oBusUserProfile->message());
                }

                $dataUserProfile = $oBusUserProfile->data();

                /* @var $eUserProfile eUserProfile  */
                $eUserProfile   = $dataUserProfile['eUserProfile'];

                //COMPANY_BRANCH
                $oBusCompanyBranch = Business_App_User_Settings::listCompanyBranchsByUserProfile($eUserProfile->id_user, $eUserProfile->id_profile);

                if(!$oBusCompanyBranch->isSuccess())
                {
                    throw new Exception($oBusCompanyBranch->message());
                }

                $dataCompanyBranchs = $oBusCompanyBranch->data();

                $eCompanyBranchs   = $dataCompanyBranchs['eCompanyBranchs'];
                
                $frm_data->setUserProfileEntity($eUserProfile);
                $frm_data->setUserProfile_CompanyBranchEntity($eCompanyBranchs);
            }
            
            $resAjax->isSuccess( TRUE );
        }
        catch (Exception $exc)
        {
            $resAjax->isSuccess( FALSE );
            $resAjax->message( $exc->getMessage() );
        }
        
        $resAjax->form('person', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    

    /*______________________________________________________________*/
    //CONTROL IMC
    private function listControlIMC()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter     = $this->input->get('sSearch');
        $limit          = $this->input->get('iDisplayLength');
        $offset         = $this->input->get('iDisplayStart');
        $id_customer    = $this->input->get('id_customer');
        
        $oBus = Business_App_Customer_Crossfit::listControlIMC($txt_filter, $limit, $offset, $id_customer);
        $data = $oBus->data();

        $eControlIMCs   = $data['eControlIMCs'];
        $count          = $data['count'];
        
        $aaData = array();
        
        if( !empty($eControlIMCs) )
        {
            
            /* @var $eControlIMC eControlIMC */
            foreach( $eControlIMCs as $num => $eControlIMC )
            {
                $estado = '';
                $observacion = '';
                $altura = ($eControlIMC->height/100) * ($eControlIMC->height/100);
                $imc = round( ( ( $eControlIMC->weight ) / ( $altura ) ), 2);
                
                if( $imc < 18.5)
                {
                    $estado = '<span class="label label-info">Peso insuficiente</span>';
                    $observacion = 'Te recomendamos que visites a tu dietista-nutricionista o a tu médico.';
                }
                else
                {
                    if( $imc <= 24.9 )
                    {
                        $estado = '<span class="label label-success">Normopeso</span>';
                        $observacion = '';
                    }
                    else
                    {
                        if( $imc <= 29.9 )
                        {
                            $estado = '<span class="label label-warning">Sobrepeso</span>';
                            $observacion = 'Te recomendamos que visites a tu dietista-nutricionista o a tu médico.';
                        }
                        else
                        {
                            if( $imc <= 39.9 )
                            {
                                $estado = '<span class="label label-primary">Obesidad grado I</span>';
                                $observacion = 'Te recomendamos que visites a tu dietista-nutricionista o a tu médico.';
                            }
                            else
                            {
                                if( $imc >= 40 )
                                {
                                    $estado = '<span class="label label-danger">Obesidad grado II</span>';
                                    $observacion = 'Te recomendamos que visites a tu dietista-nutricionista o a tu médico.';
                                }
                            }
                        }
                    }
                }
                
                
                $aaData[] = array( 
                    Helper_Fecha::setFomratDate($eControlIMC->update_date),
                        $eControlIMC->height,
                        $eControlIMC->weight,
                        $imc,
                        $estado,
                        $observacion
                    );
            }
        }
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveControlIMC()
    {
        $this->load->file('application/modules/app/setting/customer_crossfit/form/control_imc_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_Control_IMC(TRUE);
        
        try
        {
            
            if( !$this->permission->create_imc )
            {
                throw new Exception('No tiene permisos para crear/nuevo');
            }
            
            if( !$frm_data->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $eControlIMC = $frm_data->getControlIMC();

            $oBus = Business_App_Customer_Crossfit::saveControlIMC($eControlIMC);
            
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
            $resAjax->form('control', $frm_data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
}