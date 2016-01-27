<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_App_View
{
    static private $htmlTitle = "Sistema de Control del WOD (Workout Of the Day)";
    //private $resources_path = 'resources/assets';

    static function view( $view, $arrParams=array(), $return=FALSE )
    {
        
        $MY =& MY_Controller::get_instance();
        
        $arrParamsLayoutDefault = array(
            'layout_title'=>self::$htmlTitle,
        );
        
        if( $return )
        {
            return $MY->load->view($view, array_merge($arrParamsLayoutDefault,$arrParams), TRUE);
        }
        
        $MY->load->view($view, array_merge($arrParamsLayoutDefault,$arrParams));
        
    }

    static function layout( $view/* string OR array strings */, $arrParams=array(), $arrParamsLayout=array(), $useIframe=FALSE)
    {
        $MY =& MY_Controller::get_instance();
        
        /* @var $mConfigurationSystem Configuration_System_Model */
        $mConfigurationSystem =& $MY->mConfigurationSystem;
        
        /* @var $mCompany Company_Model */
        $mCompany =& $MY->mCompany;     
      
        /* @var $mCompanyBranch Company_Branch_Model */
        $mCompanyBranch =& $MY->mCompanyBranch;
        
        /* @var $mProfile profile_Model */
        $mProfile =& $MY->mProfile;
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        /* @var $mPerson Person_Model */
        $mPerson =& $MY->mPerson;
        
        /* @var $mUserProfile User_Profile_Model*/
        $mUserProfile =& $MY->mUserProfile;
        
        /* @var $mUserProfileCompanyBranch User_Profile_Company_Branch_Model */
        $mUserProfileCompanyBranch =& $MY->mUserProfileCompanyBranch;
        
        /* @var $mAppVersion App_Version_Model */
        $mAppVersion =& $MY->mAppVersion;
        
        $id_system = Helper_Config::getSystemId();
        $id_company = Helper_App_Session::getCompanyId();
        $id_company_branch = Helper_App_Session::getCompanyBranchId();
        $id_profile = Helper_App_Session::getProfileId();
        $id_user = Helper_App_Session::getUserId();
        
        /* @var $eConfigurationSystem eConfigurationSystem */
        $eConfigurationSystem = $mConfigurationSystem->load($id_system);
        
        /* @var $eCompany eCompany */
        $eCompany = $mCompany->load($id_company);
        
        /* @var $eProfile eProfile */
        $eProfile = $mProfile->load( $id_profile );
        
        /* @var $eUser eUser */
        $eUser   = $mUser->load( $id_user );
        
        /* @var $ePerson ePerson */
        $ePerson = $mPerson->load( $eUser->id_person );
        
        /* @var $eAppVersion eAppVersion  */
        $eAppVersion = $mAppVersion->loadArray( array( 'isActive' => 1, 'isProject' => 1 ) );
            
        $resources_path = 'resources/assets/app';
        
        $arrMenu = Helper_App_Permission::getMenu();
        
        $controller_current = $MY->uri->rsegment(1);
        $function_current   = $MY->uri->rsegment(2);
        
        // ================================================================
        // ================================================================
        
        $eProfiles = $mUserProfile->listProfilesByUser($id_user, 1);
        $show_combo_perfiles = TRUE;
        $combo_perfiles = Helper_Array::entitiesToIdText($eProfiles, 'id', 'name', 'value', 'text', $id_profile);
        // ================================================================
        // ================================================================
        
        if(empty($eProfiles))
        {
            $flash = new Response_Flash();
            $flash->message('Ningun Perfil disponible!');
            $flash->flashType( Response_Flash::FLASH_ERROR );
            Helper_App_Flash::set($flash);
            $show_combo_perfiles = FALSE;
            $useIframe = TRUE;
            $view = 'app/html/error/403';
        }
        
        // ================================================================
        // ================================================================
        
        $eCompanyBranches = Helper_App_Session::isSuperAdminProfile() || Helper_App_Session::isAdminProfile()
            ? $mCompanyBranch->listByCompany($id_company)
            : $mUserProfileCompanyBranch->listCompanyBranchsByUserProfile($id_user, $id_profile);
      
        $show_combo_sedes = TRUE;
        $combo_sedes = Helper_Array::entitiesToIdText($eCompanyBranches, 'id', 'name', 'value', 'text', $id_company_branch);
        
        if(empty($eCompanyBranches))
        {
            $flash = new Response_Flash();
            $flash->message('Ninguna Sucursal disponible!');
            $flash->flashType( Response_Flash::FLASH_ERROR );
            Helper_App_Flash::set($flash);
            $show_combo_sedes = FALSE;
            $useIframe = TRUE;
            $view = 'app/html/error/403';
        }
        
        
        $content = '';
        if( is_array($view) )
        {
            foreach( $view as $v )
            {
                $content .= $MY->load->view($v, $arrParams, true);
            }
        }
        else
        {
            $content = $MY->load->view($view, $arrParams, true);
        }
        
        $browser = Helper_App_Session::isIExplorer();
        
        $arrParamsLayoutDefault = array(
            'useIframe'             => $useIframe,
            'resources_path'        => $resources_path,
            'content'               => $content,
            'arrMenu'               => $arrMenu,
            //CONTROLLER
            'controller_current'    => $controller_current,
            'function_current'      => $function_current,
            //NAVEGADOR
            'navegador'             => $browser,
            //DATA
            'eConfigurationSystem'  => $eConfigurationSystem,
            'eCompany'              => $eCompany,
            'eProfile'              => $eProfile,
            'ePerson'               => $ePerson,
            'eUser'                 => $eUser,
            'eAppVersion'           => $eAppVersion,
            //COMBOS
            'show_combo_perfiles'   => $show_combo_perfiles,
            'combo_perfiles'        => $combo_perfiles,
            'show_combo_sedes'      => $show_combo_sedes,
            'combo_sedes'           => $combo_sedes,
        );
        

        $MY->load->view('app/html/layout/layout', array_merge( $arrParamsLayoutDefault, $arrParamsLayout));
    }
}