<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Db_Back_Up extends MY_Controller
{
    protected $name_key = 'system_db_back_up';
    
    /* @var $permission System_BackUp_DB_Permission */
    protected $permission;

    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/system_db_backup/permission.php');
        $this->permission = new System_BackUp_DB_Permission( $this->name_key );
        
        if( !Helper_App_Session::isLogin() )
        {
            $this->redirect('app/login');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->redirect('app/login_advanced');
            return;
        }
               
        if( Helper_App_Session::isBlock() )
        {
            $this->redirect('app/login_advanced');
            return;
        }
        
        if( !$this->permission->access )
        {
            Helper_App_Log::write("BackUp Data Base: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        $MY =& MY_Controller::get_instance();

        /* @var $mAppVersion App_Version_Model */
        $mAppVersion =& $MY->mAppVersion;
        
        /* @var $eAppVersion eAppVersion  */
        $eAppVersion = $mAppVersion->loadArray( array( 'isActive' => 1, 'isDataBase' => 1 ) );
        
        $arr = array('eAppVersion' => $eAppVersion);
        
        Helper_App_View::layout("app/html/pages/system_db_backup/page", $arr);
    }
    
    public function backup($accion='DOWNLOAD')
    {
        // ================================================
        Helper_Database::backup( Helper_Database::DB_DEFAULT, TRUE );
        // ================================================
    }
    
    public function mvcjs()
    {
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
        );
        
        Helper_App_JS::showMVC('system_db_backup', $params);
        
    }
}