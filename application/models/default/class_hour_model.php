<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Class_Hour_Model extends MY_Model
{
    protected $table = 'class_hour';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eClassHour = new eClassHour();
        $eClassHour->parseRow($row);
        
        return $eClassHour;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id') 
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eClassHour = new eClassHour();
        $eClassHour->parseRow($row);
        
        return $eClassHour;
    }
    
    
    function save(eClassHour &$eClassHour)
    {
        try
        {
            if( empty($eClassHour->id) )
            {
                $eClassHour->id = $this->genId();
                $this->insert($eClassHour->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eClassHour->toData(FALSE), $eClassHour->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    function filter(filterClassHour $filter, &$eClassHours, &$count=NULL )
    {
        $eClassHours = array();
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
                $eClassHour = new eClassHour();
                
                $eClassHour->parseRow($row, 'ch_');
                
                $eClassHours[] = $eClassHour;
            }
        }        
        
    }

    function filterQuery(filterClassHour $filter, $useCounter=FALSE )
    {
        
        $select_chour = $this->buildSelectFields('ch_', 'ch', $this->table);
        
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select_chour )."
            FROM \"".( $this->table )."\" AS \"ch\"
            WHERE 1=1
                AND 
                (
                    UPPER(\"ch\".\"start_hour\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"ch\".\"final_hour\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
                " .( is_null($filter->isActive) ? "" : "AND (\"ch\".\"isActive\"=".($filter->isActive).") " ). "
            " . ( $useCounter ? '' : " ORDER BY \"ch\".\"start_hour\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        return $sql;
    }
    
    
    
}

class eClassHour extends MY_Entity
{
    public $start_hour;
    public $final_hour;
    public $isActive;


    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->start_hour   = '00:00:00';
            $this->final_hour   = '00:00:00';
            $this->isActive     = 1;
        }
    }
}

class filterClassHour extends MY_Entity_Filter
{
    public $isActive;
    public function __construct()
    {
        parent::__construct();
        $this->isActive = NULL;
    }
    
}