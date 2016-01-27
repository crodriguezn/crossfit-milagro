<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Db_Back_UpX extends MY_Controller
{
    protected $name_key = 'system_db_back_up';
    
    /* @var $permission System_BackUp_DB_Permission */
    protected $permission;

    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        $this->load->file('application/modules/app/system_db_backup/permission.php');
        $this->permission = new System_BackUp_DB_Permission( $this->name_key );
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
            case 'backup':
                $this->backup();
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
    
    
    public function backup()
    {
        
        $resAjax = new Response_Ajax();
        
        // ================================================
        Helper_Database::backup( Helper_Database::DB_DEFAULT );
        // ================================================
        
        $resAjax->isSuccess(TRUE);
        $resAjax->message('BackUP Generado Exitosamente');
        
        echo $resAjax->toJsonEncode();
    }
}