<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Log_Model extends MY_Model
{
    protected $table = 'user_log';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eUserLog = new eUserLog();
        $eUserLog->parseRow($row);
        
        return $eUserLog;
    }

    function save(eUserLog &$eUserLog)
    {
        try
        {
            if( empty($eUserLog->id) )
            {
                $eUserLog->id = $this->genId();
                $this->insert($eUserLog->toData());
            }
            else
            {
                $this->update($eUserLog->toData(FALSE), $eUserLog->id);
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    function filter( filterUserLog $filter, &$eUserLogs, &$eUsers, &$count )
    {
        $eUserLogs  = array();
        $eUsers     = array();
        $count = 0;
        
        $queryR = $this->db->query($this->filterQuery($filter));
        if( $queryR === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $queryC = $this->db->query($this->filterQuery($filter,TRUE));
        if( $queryC === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $row = $queryC->row_array();
        
        $count = $row['count'];
        
        $rows = $queryR->result_array();
        
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eUserLog = new eUserLog();
                $eUserLog->parseRow($row, 'ul_');

                $eUserLogs[] = $eUserLog;
                
                $eUser = new eUser();
                $eUser->parseRow($row, 'u_');

                $eUsers[] = $eUser;
                
            }
        }
        
    }

    function filterQuery( filterUserLog $filter, $useCounter=FALSE )
    {
        $select_user = $this->buildSelectFields('u_', 'u', 'user');
        $select_user_log = $this->buildSelectFields('ul_', 'ul', $this->table);
        $select = $select_user.','.$select_user_log;
        $buscarAccion = $filter->action('ul', 'action');
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"ul\"
                INNER JOIN \"user\" AS \"u\" ON \"u\".\"id\"=\"ul\".\"id_user\" 
            WHERE 1=1
                AND (
                    UPPER(\"username\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') 
                )
            " . ( is_null($filter->date_begin) || is_null($filter->date_end) ? '': ' AND "ul"."date_time" BETWEEN \''.$filter->date_begin." 00:00:00".'\' AND \''.$filter->date_end." 23:59:59".'\'' ) . "
            " . ( empty($buscarAccion) ? ' AND 1!=1' : ' AND ('.$buscarAccion.')' ) . "
            " . ( $useCounter ? '' : " ORDER BY \"date_time\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        
        return $sql;
    }

    
}

class eUserLog extends MY_Entity
{
    public $id_user;
    public $info;
    public $date_time;
    public $url;
    public $ip;
    public $action;
    public $browser;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_user = NULL;
            $this->info = '';
            $this->date_time = NULL;
            $this->url = '';
            $this->ip = '';
            $this->action = '';
            $this->browser = '';
        }
    }
}

class filterUserLog extends MY_Entity_Filter
{
    public $action;
    public $date_begin;
    public $date_end;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->action       = array();
        $this->date_begin   = NULL;
        $this->date_end     = NULL;
    }
    
    
    public function action($prefix, $field='action')
    {
        $action = NULL;
        
        if( is_array($this->action) && !empty($this->action) )
        {
            $count = count($this->action);
            
            foreach( $this->action as $num => $result )
            {
                if(!empty($result))
                {
                    $action .= ' "'.($prefix).'"."'.($field).'" LIKE \'%'.($result).'%\'';
                }
                
                if($count > $num+1)
                {
                    $action .= ' OR ';
                }
            }
        }
        return $action;
    }
}