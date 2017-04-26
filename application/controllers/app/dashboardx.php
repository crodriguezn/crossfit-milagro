<?php 
/*
 * @author Carlos Luis Rodriguez Nieto <taylorluis93@gmail.com>
 * @date 15-oct-2016
 * @time 23:15:58
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashboardX extends MY_Controller
{
    protected $name_key = 'dashboard';
    
    function __construct()
    {
        parent::__construct(MY_Controller::SYSTEM_APP);
    }

    public function index()
    {
        $this->process(NULL);
    }

    public function process($action)
    {
        switch( $action )
        {
            case 'last-activity':
                $this->lastActivity();
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

    private function lastActivity()
    {
        
        $resAjax = new Response_Ajax();
        
        $MY =& MY_Controller::get_instance();
        $isAdmin = FALSE;
        if(Helper_App_Session::isSuperAdminProfile())
        {
            $isAdmin = TRUE;
        }
        elseif (Helper_App_Session::isAdminProfile())
        {
            $isAdmin = TRUE;
        }
        
        /* @var $mUserLog User_Log_Model */
        $mUserLog =& $MY->mUserLog;
        $filter = new filterUserLog();
        $filter->limit = 5;
        $filter->isAdmin = $isAdmin;
        $filter->id_user = Helper_App_Session::getUserId();
        
        $mUserLog->lastActivity( $filter, $eUserLogs/*REF*/, $eUsers/*REF*/, $ePersons/*REF*/ );
        
        $resAjax->isSuccess( !empty($eUserLogs) );
        $resAjax->message( empty($eUserLogs) ? 'No existe actividad':'' );
        
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
                
                $oBus = Business_App_User_Profile::loadPictureProfile( $eUsers[$num]->id );
                
                $dataP = $oBus->data();
                
                $uri = $dataP['uri'];
                if(!$oBus->isSuccess())
                {
                    if($ePersons[$num]->gender=='GENDER_MALE')
                    {
                        $uri = 'resources/img/crossfit_men.png';
                    }
                    if($ePersons[$num]->gender=='GENDER_FEMALE')
                    {
                        $uri = 'resources/img/crossfit_women.png';
                    }
                    
                }
                
                
                $aaData[] = array(
                    'user'    => strtoupper(trim($ePersons[$num]->name).' '.trim($ePersons[$num]->surname)),
                    'action'    => $action,
                    'url'       => $eUserLog->url,
                    'ip'        => $eUserLog->ip,
                    'time'      => Helper_Fecha::getIntervalDate( $eUserLog->date_time ),
                    'picture'   => $uri,
                    'browser'   => $eUserLog->browser
                    );
            }
        }
        
        
        $resAjax->data(array('activity' => $aaData));
        
        echo $resAjax->toJsonEncode();
    }
}