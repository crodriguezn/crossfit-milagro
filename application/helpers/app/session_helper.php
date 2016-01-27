<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_App_Session
{
    
    static protected $params_session = array('session_group'=>'app');
    
    static protected $msgError = 'Problemas de inicio de sesión:';

    static public function getVar( $var_name )
    {
        $MY =& MY_Controller::get_instance();
        $MY->libsession->setSessionGroup( self::$params_session['session_group'] );

        $var_value = $MY->libsession->get( $var_name );
        
        //return unserialize( $var_value );
        return $var_value;
    }
    
    static public function setVar( $var_name, $var_value )
    {
        $MY =& MY_Controller::get_instance();
        $MY->libsession->setSessionGroup( self::$params_session['session_group'] );

        //$MY->libsession->set($var_name, serialize($var_value));
        $MY->libsession->set($var_name, $var_value);
    }
    
    static public function setVars( $arrVar )
    {
        if( !empty($arrVar) )
        {
            foreach( $arrVar as $var_name => $var_value )
            {
                self::setVar( $var_name, $var_value );
            }
        }
    }
    
    static public function debugAll()
    {
        $MY =& MY_Controller::get_instance();
        $MY->libsession->setSessionGroup( self::$params_session['session_group'] );
        $info = array(self::$params_session['session_group']=>$MY->libsession->getAll());
        Helper_Log::write( print_r($info,TRUE) );
        Helper_App_Log::write( $info, TRUE, Helper_App_Log::LOG_LOGIN );
    }
    
    // =============================================================
    
    static public function init( $id_company, $id_user )
    {
        self::setVars(array(
            '__id_company'          => $id_company,
            '__id_company_branch'   => NULL,
            '__id_rol'              => NULL,
            '__id_user'             => $id_user,
            '__id_person'           => NULL,
            '__isSuperAdmin'        => FALSE,
            '__isAdmin'             => FALSE,
            '__id_profile'          => NULL,
            '__last_time'           => date('Y-m-d H:i:s'),
            '__inInactivity'        => TRUE,
            '__isBlock'             => FALSE,
            '__id_system'           => Helper_Config::getSystemId()
        ));
        self::buildData();
        self::debugAll();
    }
    
    static public function buildData()
    {
        $MY =& MY_Controller::get_instance();
        
        $MY->load->library('libsession');
        $MY->libsession->setSessionGroup( self::$params_session['session_group'] );
        
        /* @var $mUser User_Model */
        $mUser =& $MY->mUser;
        
        /* @var $mUserProfileCompanyBranch User_Profile_Company_Branch_Model */
        $mUserProfileCompanyBranch =& $MY->mUserProfileCompanyBranch;
        
        /* @var $mUserProfile User_Profile_Model */
        $mUserProfile =& $MY->mUserProfile;
        
        /* @var $mCompanyBranch Company_Branch_Model */
        $mCompanyBranch =& $MY->mCompanyBranch;
       
        /* @var $mCompany Company_Model */
        $mCompany =& $MY->mCompany;
        
        /* @var $mPerson Person_Model */
        $mPerson =& $MY->mPerson;
        
        /* @var $mProfile Profile_Model */
        $mProfile =& $MY->mProfile;
        
        /* @var $mRol Rol_Model */
        $mRol =& $MY->mRol;
        
        /* @var $mConfigurationSystem Configuration_System_Model */
        $mConfigurationSystem =& $MY->mConfigurationSystem;
        
        try
        {
            $id_company = self::getCompanyId();
            $id_user = self::getUserId();
            $id_system = self::getConfigurationSystemId();
            
            // *******************
            // CONFIGURATION SYSTEM
            // *******************
            
            $eConfigurationSystem = $mConfigurationSystem->load($id_system);
            
            if( $eConfigurationSystem->isEmpty() )
            {
                throw new Exception(self::$msgError + "SYSTEM NO FOUND");
            }
            
            //self::setConfigurationSystem($eConfigurationSystem);
            
            // *******************
            // USER
            // *******************
            
            $eUser = $mUser->load($id_user);
            if( $eUser->isEmpty() )
            {
                throw new Exception(self::$msgError + "001 --Usuario-- NO FOUND");
            }
            
            // *******************
            // PERSON
            // *******************
            
            $ePerson = $mPerson->load($eUser->id_person);
            if( $ePerson->isEmpty() )
            {
                throw new Exception(self::$msgError + "002 --Persona-- NO FOUND");
            }
            
            self::setPersonId($ePerson->id);
            
            // *******************
            // PROFILE
            // *******************
            
            $eProfiles = $mUserProfile->listProfilesByUser($id_user, 1);
            
            if( empty($eProfiles) )
            {
                throw new Exception(self::$msgError + "003 --Profile-- NO FOUND");
                //throw new Exception("Problemas de inicio de sesión: 003");
            }
            
            $id_profile = self::getProfileId();
            if( empty($id_profile) )
            {
                /* @var $eProfile eProfile */
                $eProfile = $eProfiles[0];
                $id_profile = $eProfile->id;
                self::setProfileId( $id_profile );
                //self::setProfile( $eProfile );
            }
            
            $isFound = FALSE;
            foreach( $eProfiles as $eProfile )
            {
                /* @var $eProfile eProfile */
                if( $id_profile == $eProfile->id )
                {
                    $isFound = TRUE;
                    break;
                }
            }
            
            if( !$isFound )
            {
                throw new Exception(self::$msgError + "004 --Profile-- NO FOUND");
                //throw new Exception("Problemas de inicio de sesión: 004");
            }
            
            $eProfile = $mProfile->load($id_profile);
            
            self::isSuperAdminProfile( $eProfile->isSuperAdmin == 1 );
            self::isAdminProfile( $eProfile->isAdmin == 1 );
            
            
            // *******************
            // COMPANY
            // *******************
            
            $eCompany = $mCompany->load($id_company);
            if( $eCompany->isEmpty() )
            {
                throw new Exception(self::$msgError + "005 --Company-- NO FOUND");
                //throw new Exception("Problemas de inicio de sesión: 005");
            }

            
            // *******************
            // COMPANY BRANCHES
            // *******************
            
            $eCompanyBranches = self::isSuperAdminProfile() || self::isAdminProfile()
                    ? $mCompanyBranch->listByCompany($id_company)
                    : $mUserProfileCompanyBranch->listCompanyBranchsByUserProfile($id_user, $id_profile, 1);
            
            if( empty($eCompanyBranches) )
            {
                throw new Exception(self::$msgError + "006 --Company_Branch-- NO FOUND");
                //throw new Exception("Problemas de inicio de sesión: 006");
            }
            
            $arrCompanyBranchIds = array();
            
            if( !empty($eCompanyBranches) )
            {
                /* @var $eCompanyBranchT eCompanyBranch */
                foreach( $eCompanyBranches as $eCompanyBranchT )
                {
                    $arrCompanyBranchIds[] = $eCompanyBranchT->id;
                }
            }
            self::setVar( '__id_company_branck_ids', $arrCompanyBranchIds );
            
            
            $id_company_branch = self::getCompanyBranchId();
            if( empty($id_company_branch) )
            {
                /* @var $eCompanyBranch eCompanyBranch */
                $eCompanyBranch = $eCompanyBranches[0];
                $id_company_branch = $eCompanyBranch->id;
                self::setCompanyBranchId( $id_company_branch );
            }
            
            $isFound = FALSE;
            foreach( $eCompanyBranches as $eCompanyBranch )
            {
                /* @var $eCompanyBranch eCompanyBranch */
                if( $id_company_branch == $eCompanyBranch->id )
                {
                    $isFound = TRUE;
                    break;
                }
            }
            
            if( !$isFound )
            {
                throw new Exception(self::$msgError + "007 --Company_Branch-- NO FOUND");
                //throw new Exception("Problemas de inicio de sesión: 007");
            }
            

            // *******************
            // ROLES
            // *******************
            
            /* @var $eRol eRol */
            $eRol = $mRol->load($eProfile->id_rol);
            if( empty($eRol) )
            {
                throw new Exception(self::$msgError + "008 --Rol-- NO FOUND");
            }
            
            $id_rol = self::getRolId();
            if( empty($id_rol) )
            {
                $id_rol = $eRol->id;
                self::setRolId( $id_rol );
            }
            
            self::setVar('__permissions', self::buildPermissionsByProfile());
        }
        catch( Exception $e )
        {
            self::logout();
        }
    }
    
    static public function buildPermissionsByProfile()
    {
        $MY =& MY_Controller::get_instance();

        /* @var $mPermission Permission_Model */
        $mPermission =& $MY->mPermission;
        
        /* @var $mModule Module_Model */
        $mModule =& $MY->mModule;
        
        /* @var $mRolModule Rol_Module_Model*/
        $mRolModule =& $MY->mRolModule;
        
        /* @var $mRolModule Rol_Module_Model*/
        $mRolModule =& $MY->mRolModule;
        
        /*
        [ module-name_key1 ] => array( 'access', 'new', 'edit', 'delete', 'trash', ... );
        [ module-name_key2 ] => array( 'access', 'new', 'edit', 'delete', 'trash', ... );
        [ module-name_key3 ] => array( 'access', 'new', 'edit', 'delete', 'trash', ... );
         */

        $id_company_branch = self::getCompanyBranchId();
        $id_profile = self::getProfileId();
        $isSuperAdminProfile = self::isSuperAdminProfile();
        $isAdminProfile      = self::isAdminProfile();
        
        $eModules = $mModule->listAll( $isSuperAdminProfile ? TRUE : FALSE, 1 ); // module assigned to company
        
        $arrPermissionResult = array();
        if( !empty($eModules) )
        {
            /* @var $eModule eModule */
            foreach($eModules as $eModule)
            {
                $dtPermissions = array();
                if( $isSuperAdminProfile || $isAdminProfile ) // all permission por administrator profile
                {
                    $dtPermissions = $mPermission->listByModule( $eModule->id );
                }
                else // permission assigned to rol
                {
                    $dtPermissions = $mPermission->listByProfileAndModule($id_company_branch, $eModule->id, $id_profile);
                }

                $arrTemp = array();
                if( !empty($dtPermissions) )
                {
                    /* @var $ePermission ePermission */
                    foreach( $dtPermissions as $ePermission )
                    {
                        $arrTemp[] = $ePermission->name_key;
                    }
                }

                $arrPermissionResult[ $eModule->name_key ] = $arrTemp;
            }
        }

        return $arrPermissionResult;
    }
    
    // ======================================================
    
    static public function isLogin()
    {
        return self::getUserId() !== FALSE;
    }
    
    static public function logout()
    {
        $MY =& MY_Controller::get_instance();
        $MY->load->library('libsession');
        $MY->libsession->setSessionGroup( self::$params_session['session_group'] );

        $MY->libsession->destroy();
        self::removeCache();
    }
    static public function removeCache()
    {
        $MY =& MY_Controller::get_instance();
        $MY->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $MY->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $MY->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $MY->output->set_header('Pragma: no-cache');
    }
    // ======================================================
    
    static public function setCompanyId( $id_company )
    {
        self::setVar( '__id_company', $id_company );
    }
    static public function getCompanyId()
    {
        return self::getVar('__id_company');
    }
    
    static public function getCompany()
    {
        return self::getVar('__company');
    }
    
    static public function getUserId()
    {
        return self::getVar('__id_user');
    }
    
    static public function getUser()
    {
        return self::getVar('__user');
    }
    
    static public function setCompanyBranchId( $id_company_branch )
    {
        self::setVar( '__id_company_branch', $id_company_branch );
    }
    
    static public function getCompanyBranchId()
    {
        return self::getVar('__id_company_branch');
    }
    
    static public function setCompanyBranch( eCompanyBranch $eCompanyBranch )
    {
        self::setVar( '__company_branch', $eCompanyBranch );
    }
    
    static public function getCompanyBranch()
    {
        return self::getVar('__company_branch');
    }
    
    static public function setCompanyBranchAll( $eCompanyBranches )
    {
        self::setVar( '__company_branches', $eCompanyBranches );
    }
    
    static public function getCompanyBranchAll()
    {
        return self::getVar('__company_branches');
    }
    
    static public function setRolId( $id_rol )
    {
        self::setVar( '__id_rol', $id_rol );
    }
    
    static public function getRolId()
    {
        return self::getVar('__id_rol');
    }
    
    static public function setRol( eRol $eRol )
    {
        self::setVar( '__rol', $eRol );
    }
    
    static public function getRol()
    {
        return self::getVar('__rol');
    }
    
    static public function setProfileId( $id_profile )
    {
        self::setVar( '__id_profile', $id_profile );
    }
    
    static public function getProfileId()
    {
        return self::getVar('__id_profile');
    }
    
    static public function setProfile(eProfile $eProfile )
    {
        self::setVar( '__profile', $eProfile );
    }
    
    static public function getProfile()
    {
        return self::getVar('__profile');
    }
    
    static public function setPersonId( $id_person )
    {
        self::setVar('__id_person', $id_person);
    }
    
    static public function getPersonId()
    {
        return self::getVar('__id_person');
    }

    static public function setPerson( $ePerson )
    {
        self::setVar('__person', $ePerson);
    }
    
    static public function getPerson()
    {
        return self::getVar('__person');
    }
    
    static public function getCompanyBranchIdsAccess()
    {
        return self::getVar('__id_company_branck_ids');
    }
    
    static public function getConfigurationSystemId()
    {
        return self::getVar('__id_system');
    }
    
    static public function setConfigurationSystemId( $id_system )
    {
        self::setVar('__id_system', $id_system);
    }
    
    static public function setConfigurationSystem( $eConfigurationSystem )
    {
        self::setVar('__system', $eConfigurationSystem);
    }
    
    static public function getConfigurationSystem()
    {
        return self::getVar('__system');
    }
    
    // ======================================================
    
    static public function isSuperAdminProfile( $isSuperAdminProfile=NULL )
    {
        if( !is_bool($isSuperAdminProfile) )
        {
            return self::getVar('__isSuperAdmin');
        }
        
        self::setVar('__isSuperAdmin', $isSuperAdminProfile);
    }
    
    static public function isAdminProfile( $isAdminProfile=NULL )
    {
        if( !is_bool($isAdminProfile) )
        {
            return self::getVar('__isAdmin');
        }
        
        self::setVar('__isAdmin', $isAdminProfile);
    }
    
    // ======================================================
    
    static public function getPermissions()
    {
        return self::getVar('__permissions');
    }
    
    static public function isPermissionForModule($module_name_key, $permission)
    {
        $permissions = self::getVar('__permissions');

        $isAccess = FALSE;
        if( isset($permissions[ $module_name_key ]) )
        {
            $arrPermission = $permissions[ $module_name_key ];
            $isAccess = in_array($permission, $arrPermission);
        }

        return $isAccess;
    }

    static public function isAccessToModule( $module_name_key )
    {
        return self::isPermissionForModule($module_name_key, 'access');
    }
    
    // ======================================================
    // ======================================================
    
    static public function setLastTime( $time )
    {
        self::setVar('__last_time', $time);
    }
    
    static public function getLastTime()
    {
        return self::getVar('__last_time');
    }
    
    static public function setInactivity( $inInactivity )
    {
        self::setVar('__inInactivity', $inInactivity);
    }
    
    static public function getInactivity()
    {
        return self::getVar('__inInactivity');
    }
    
    static public function setBlock( $isBlock )
    {
        self::setVar('__isBlock', $isBlock);
    }
    
    static public function getBlock()
    {
        return self::getVar('__isBlock');
    }

    static public function inInactivity()
    {
        $MY =& MY_Controller::get_instance();
        
        /* @var $mConfigurationSystem Configuration_System_Model */
        $mConfigurationSystem =& $MY->mConfigurationSystem;
        
        $id_system = Helper_Config::getSystemId();
        
        /* @var $eConfigurationSystem eConfigurationSystem */
        $eConfigurationSystem = $mConfigurationSystem->load($id_system);
        
        $lastTime = self::getLastTime();
        $now = date("Y-m-d H:i:s");
        $time = (strtotime($now)-strtotime($lastTime));
        
        $limit_min = (is_null($eConfigurationSystem->session_time_limit_min)) ? 600 : $eConfigurationSystem->session_time_limit_min;
        $limit_max = (is_null($eConfigurationSystem->session_time_limit_max)) ? 1200 : $eConfigurationSystem->session_time_limit_max;
        if(ENVIRONMENT!='development')
        {
            if($time >= $limit_max)//comparamos el tiempo transcurrido (>20 min)
            {
                self::logout();
                return FALSE;
            }
            elseif($time >= $limit_min) //comparamos el tiempo transcurrido (>10 min)
            {
                self::setInactivity(FALSE);
                self::setBlock(TRUE);
                //return FALSE;
            }
            else
            {
                self::setLastTime($now);
                self::setInactivity(TRUE);
                self::setBlock(FALSE);
                //return TRUE;
            }
        }
        return self::getInactivity();
    }

    static public function isBlock()
    {
        return self::getBlock() !== FALSE;
    }

    // ======================================================
    // ======================================================
    
    static public function getSessionID()
    {
        $MY =& MY_Controller::get_instance();
        
        return $MY->libsession->id();
    }
}
