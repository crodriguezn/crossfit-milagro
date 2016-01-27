<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Advanced extends MY_Controller
{
    protected $name_key = 'login_advanced';
    
    public $browser;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        
        
        if( !Helper_App_Session::isLogin() )
        {
            $this->redirect('app/login');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->redirect('app/login');
            return;
        }
        $this->browser = Helper_App_Session::isIExplorer();
        
    }

	public function index()
	{

            $login_title = 'INGRESO AL SISTEMA';
            
            $MY =& MY_Controller::get_instance();
        
            /* @var $mCompany Company_Model */
            $mCompany =& $MY->mCompany;     

            /* @var $mProfile Profile_Model */
            $mProfile =& $MY->mProfile;

            /* @var $mUser User_Model */
            $mUser =& $MY->mUser;

            /* @var $mPerson Person_Model */
            $mPerson =& $MY->mPerson;
            
            /* @var $mAppVersion App_Version_Model */
            $mAppVersion =& $MY->mAppVersion;
            
            $id_company = Helper_App_Session::getCompanyId();
            $id_profile = Helper_App_Session::getProfileId();
            $id_user = Helper_App_Session::getUserId();
            $id_person = Helper_App_Session::getPersonId();
            

            /* @var $eCompany eCompany */
            $eCompany = $mCompany->load($id_company);

            /* @var $eProfile eProfile */
            $eProfile = $mProfile->load( $id_profile );

            /* @var $eUser eUser */
            $eUser   = $mUser->load( $id_user );

            /* @var $ePerson ePerson */
            $ePerson = $mPerson->load( $id_person );
            
            /* @var $eAppVersion eAppVersion  */
            $eAppVersion = $mAppVersion->loadArray( array( 'isActive' => 1, 'isProject' => 1 ) );
            
            $params_view = array(
            'login_title'       => $login_title,
            'browser_message'   => $this->browser['isSuccess'] ? $this->browser['message'] : '',
            'ePerson'           => $ePerson,
            'eProfile'          => $eProfile,
            'eUser'             => $eUser,
            'eCompany'          => $eCompany,
            'eAppVersion'       => $eAppVersion
        );
        
        Helper_App_View::view('app/html/pages/login/advanced', $params_view);
    }
    
    public function mvcjs()
    {
        $js_path = 'login_advanced';
        
        $params = array(
        );
        
        Helper_App_JS::showMVC($js_path, $params);
    }
    
}