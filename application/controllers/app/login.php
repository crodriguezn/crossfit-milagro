<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller
{
    protected $name_key = 'login';
    
    public $browser_message;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        $this->browser_message = Helper_App_Browser::isIExplorer();
        if( Helper_App_Session::isLogin() )
        {
            $this->redirect('app/dashboard');
            return;
        }
        
    }

	public function index()
	{
            
            $MY =& MY_Controller::get_instance();
            
            $login_title = 'INGRESO AL SISTEMA';
            
            /* @var $mAppVersion App_Version_Model */
            $mAppVersion =& $MY->mAppVersion;
            
            /* @var $eAppVersion eAppVersion  */
            $eAppVersion = $mAppVersion->loadArray( array( 'isActive' => 1, 'isProject' => 1 ) );
        
            $params_view = array(
            'login_title'        => $login_title,
            'browser_message'    => $this->browser_message['isSuccess'] ? $this->browser_message['message'] : '',
            'eAppVersion'        => $eAppVersion
        );
        
        Helper_App_View::view('app/html/pages/login/form', $params_view);
    }
    
    public function mvcjs()
    {
        $js_path = 'login';
        
        $params = array(
        );
        
        Helper_App_JS::showMVC($js_path, $params);
    }
    
    public function image_captcha( $rand='' )
    {
        unset($rand);
        Helper_Captcha::show($this->name_key);
    }
}