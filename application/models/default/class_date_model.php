<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Class_Date_Model extends MY_Model
{
    protected $table = 'class_date';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eClassDate = new eClassDate();
        $eClassDate->parseRow($row);
        
        return $eClassDate;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id') 
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eClassDate = new eClassDate();
        $eClassDate->parseRow($row);
        
        return $eClassDate;
    }
    
    
    function save(eClassDate &$eClassDate)
    {
        try
        {
            if( empty($eClassDate->id) )
            {
                $eClassDate->id = $this->genId();
                $this->insert($eClassDate->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eClassDate->toData(FALSE), $eClassDate->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    function filter(filterClassDate $filter, &$eClassDates, &$count=NULL )
    {
        $eClassDates = array();
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
                $eClassDate = new eClassDate();
                
                $eClassDate->parseRow($row, 'cd_');
                
                $eClassDates[] = $eClassDate;
            }
        }        
        
    }

    function filterQuery(filterClassDate $filter, $useCounter=FALSE )
    {
        
        $select_cdate = $this->buildSelectFields('cd_', 'cd', $this->table);
        
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select_cdate )."
            FROM \"".( $this->table )."\" AS \"cd\"
            WHERE 1=1
                AND 
                (
                    UPPER(\"cd\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') 
                )
            ".((is_null($filter->start) && is_null($filter->end)) ? '' : " AND (\"cd\".\"start_day\" BETWEEN '".($filter->start)."' AND '".($filter->end)."') ")."
            " . ( $useCounter ? '' : " ORDER BY \"cd\".\"start_day\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        return $sql;
    }
    
    
}

class eClassDate extends MY_Entity
{
    public $start_day;
    public $name;


    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->start_day    = '';
            $this->name         = 'Clase';
        }
    }
}

class filterClassDate extends MY_Entity_Filter
{
    public $start;
    public $end;
    public $name;
    
    public function __construct()
    {
        parent::__construct();
        $this->start        = NULL;
        $this->end          = NULL;
        $this->name         = NULL;
    }
    
}