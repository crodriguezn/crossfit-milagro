<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_BinnacleX extends MY_Controller
{
    protected $name_key = 'security_binnacle';
    
    /* @var $permission Security_Binnacle_Permission */
    protected $permission;

    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        $this->load->file('application/modules/app/security_binnacle/permission.php');
        $this->permission = new Security_Binnacle_Permission( $this->name_key );
        $this->permission->view = Helper_App_Session::isPermissionForModule($this->name_key,'view');
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
            case 'list-binnacle':
                $this->listBinnacle();
                break;
            case 'load-binnacle':
                $this->loadBinnacle();
                break;
            case 'save-rol':
                $this->saveRol();
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
    
    private function listBinnacle()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter = $this->input->get('sSearch');
        $limit      = $this->input->get('iDisplayLength');
        $offset     = $this->input->get('iDisplayStart');
        $accion     = $this->input->get('accion');
        $dateB      = $this->input->get('date_begin');
        $dateE      = $this->input->get('date_end');
        
        $txtAccion  = $accion=='' ? array() : explode(",", $accion);
        $arrTxtAction = array();
        if( !empty($txtAccion) )
        {
            foreach ( $txtAccion as $num => $action )
            {
                if( $action == Helper_App_Log::LOG_DEFAULT )    { $arrTxtAction[$num] = 'ACTION_DEFAULT'; }
                if( $action == Helper_App_Log::LOG_LOGIN )      { $arrTxtAction[$num] = 'ACTION_LOGIN'; }
                if( $action == Helper_App_Log::LOG_INSERT )     { $arrTxtAction[$num] = 'ACTION_INSERT'; }
                if( $action == Helper_App_Log::LOG_UPDATE )     { $arrTxtAction[$num] = 'ACTION_UPDATE'; }
                if( $action == Helper_App_Log::LOG_DELETE )     { $arrTxtAction[$num] = 'ACTION_DELETE'; }
            }
        }
        
        
        $dateBegin  = empty($dateB) ? null : $dateB;
        $dateEnd    = empty($dateE) ? null : $dateE;
        
        $oBus = Business_App_Binnacle::listBinnacle( $txt_filter, $limit, $offset, $arrTxtAction, $dateBegin, $dateEnd );
        $data = $oBus->data();
        
        $eUserLogs  = $data['eUserLogs'];
        $eUsers     = $data['eUsers'];
        $count      = $data['count'];
        
        $aaData = array();
        
        if( !empty($eUserLogs) )
        {
            /* @var $eUserLog eUserLog */
            foreach( $eUserLogs as $num => $eUserLog )
            {
                $action = null;
                if( $eUserLog->action == 'ACTION_DEFAULT' )    { $action = Helper_App_Log::LOG_DEFAULT; }
                if( $eUserLog->action == 'ACTION_LOGIN' )      { $action = Helper_App_Log::LOG_LOGIN; }
                if( $eUserLog->action == 'ACTION_INSERT' )     { $action = Helper_App_Log::LOG_INSERT; }
                if( $eUserLog->action == 'ACTION_UPDATE' )     { $action = Helper_App_Log::LOG_UPDATE; }
                if( $eUserLog->action == 'ACTION_DELETE' )     { $action = Helper_App_Log::LOG_DELETE; }
                
                $aaData[] = array( trim($action), trim($eUsers[$num]->username), trim($eUserLog->date_time), trim($eUserLog->ip), trim($eUserLog->id) );
            }
        }
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }     
    
    
    private function loadBinnacle()
    {
        $this->load->file('application/modules/app/security_binnacle/form/binnacle_form.php');
        
        $resAjax = new Response_Ajax();
        
        $id_binnacle = $this->input->post('id_binnacle');
        
        $oBus = Business_App_Binnacle::loadBinnacle($id_binnacle);
        
        $data = $oBus->data();
        
        /* @var $eUserLog eUserLog */
        $eUserLog   = $data['eUserLog'];
        $eUser      = $data['eUser'];
        
        $frm_data = new Form_App_Security_Binnacle();
        
        $frm_data->setBinnacleEntity($eUserLog);
        $frm_data->setUserEntity($eUser);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->form('binnacle', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
}