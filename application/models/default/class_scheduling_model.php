<?php

/*
 * @autor Carlos Luis Rodriguez Nieto (taylorluis93@gmail.com)
 * @date 21-abr-2017
 * @time 17:53:05
 * @link http://luis-rodriguez-ec.herokuapp.com/site/index
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Class_Scheduling_Model extends MY_Model 
{
    protected $table = 'class_scheduling';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eClassScheduling = new eClassScheduling();
        
        $eClassScheduling->parseRow($row);
        
        return $eClassScheduling;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id')
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eClassScheduling = new eClassScheduling();
        
        $eClassScheduling->parseRow($row);
        
        return $eClassScheduling;
    }
    
    function save(eClassScheduling &$eClassScheduling)
    {
        try
        {
            if (empty($eClassScheduling->id)) 
            {
                $eClassScheduling->id = $this->genId();
                $this->insert($eClassScheduling->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eClassScheduling->toData(TRUE), $eClassScheduling->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    function filter(filterClassScheduling $filter, &$eClassSchedulings, &$eClassHours, &$eClassDates, &$eEmployees, &$ePersons, &$count )
    {
        $eClassSchedulings  = array();
        $eClassHours        = array();
        $eClassDates        = array();
        $eEmployees         = array();
        $ePersons           = array();
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
        //$count = isset($row['count'])? $row['count']: NULL;
        $count = $row['count'];
        
        $rows = $queryR->result_array();
        
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eClassScheduling = new eClassScheduling();
                $eClassScheduling->parseRow($row, 'cs_');

                $eClassSchedulings[] = $eClassScheduling;
                
                $eClassHour = new eClassHour();
                $eClassHour->parseRow($row, 'ch_');
                
                $eClassHours[] = $eClassHour;
                
                $eClassDate = new eClassDate();
                $eClassDate->parseRow($row, 'cd_');
                
                $eClassDates[] = $eClassDate;
                
                $eEmployee = new eEmployee();
                $eEmployee->parseRow($row, 'e_');
                
                $eEmployees[] = $eEmployee;
                
                $ePerson = new ePerson();
                $ePerson->parseRow($row, 'p_');
                
                $ePersons[] = $ePerson;
                
            }
        }
        
    }

    function filterQuery(filterClassScheduling $filter, $useCounter=FALSE )
    {
        $select_class_hour          = $this->buildSelectFields('ch_', 'ch', 'class_hour');
        $select_class_date          = $this->buildSelectFields('cd_', 'cd', 'class_date');
        $select_class_scheduling    = $this->buildSelectFields('cs_', 'cs', $this->table);
        $select_employee            = $this->buildSelectFields('e_', 'e', 'employee');
        $select_person              = $this->buildSelectFields('p_', 'p', 'person');
        $select = ($select_class_hour.','.$select_class_date.','.$select_class_scheduling.','.$select_employee.','.$select_person);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"cs\"
                INNER JOIN \"class_hour\" AS \"ch\" ON \"ch\".\"id\" = \"cs\".\"id_class_hour\"                 
                INNER JOIN \"class_date\" AS \"cd\" ON \"cd\".\"id\" = \"cs\".\"id_class_date\" 
                INNER JOIN \"employee\" AS \"e\" ON \"e\".\"id\" = \"cs\".\"id_employee\" 
                INNER JOIN \"person\" AS \"p\" ON \"p\".\"id\" = \"e\".\"id_person\" 
            WHERE 1=1
                AND (
                    \"ch\".\"start_hour\" LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    \"ch\".\"final_hour\" LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"document\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"surname\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') 
                )
                ".((is_null($filter->start) && is_null($filter->end)) ? '' : " AND (\"cd\".\"start_day\" BETWEEN '".($filter->start)."' AND '".($filter->end)."') ")."
                ".( is_null($filter->id_employee) ? '': " AND (\"e\".\"id\" = ".($filter->id_employee).") " )."
                ".( is_null($filter->isActive) ? '': " AND (\"cs\".\"isActive\" = ".($filter->isActive).") " )."    
            " . ( $useCounter ? '' : " ORDER BY \"ch\".\"start_hour\", \"ch\".\"final_hour\", \"p\".\"surname\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        //print_r($sql);
        return $sql;
    }
    
    function updateIsActiveByIDClassHour($id_class_hour, $isActive = 1, $date = "date('Y-m-d')") 
    {
        /*
            $sql ="
                UPDATE class_scheduling
                SET \"isActive\" = '0'
                WHERE id_class_hour = 1 AND created>'2017-04-19'";
         */
        try
        {
            $arrData = array('isActive'=>$isActive);
            $where = array(
                            'id_class_hour' => $id_class_hour,
                            'created >' => $date
                        );
            
            $this->arrUpdate($arrData, $where);
            Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
        
    }
    
    function updateIsActiveByIDClassDate($id_class_date, $isActive = 1)
    {
        try
        {
            $arrData = array('isActive'=>$isActive);
            $where = array(
                            'id_class_date' => $id_class_date
                        );
            
            $this->arrUpdate($arrData, $where);
            Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    function listClassProgramation_By_IdClassDate($id_class_date, &$eClassSchedulings, $id_employee=NULL)
    {
        $eClassSchedulings  = array();
         
        $select_class_scheduling    = $this->buildSelectFields('cs_', 'cs', $this->table);
      
        $select = ($select_class_scheduling);
        $sql = "
            SELECT 
                " .( $select )."
            FROM \"".( $this->table )."\" AS \"cs\"
                INNER JOIN \"class_hour\" AS \"ch\" ON \"ch\".\"id\" = \"cs\".\"id_class_hour\"                 
                INNER JOIN \"class_date\" AS \"cd\" ON \"cd\".\"id\" = \"cs\".\"id_class_date\" 
                INNER JOIN \"employee\" AS \"e\" ON \"e\".\"id\" = \"cs\".\"id_employee\" 
            WHERE 1=1
                 AND \"cs\".\"id_class_date\"=$id_class_date
                ".( is_null($id_employee) ? '': "\"e\".\"id\" = ".($id_employee)."" )."
        ";
         
         $queryR = $this->db->query($sql);
        if( $queryR === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $queryR->result_array();
        
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eClassScheduling = new eClassScheduling();
                $eClassScheduling->parseRow($row, 'cs_');

                $eClassSchedulings[] = $eClassScheduling;
                
            }
        }
        
    }
    
    
}

class eClassScheduling extends MY_Entity
{
    public $id_class_hour;
    public $id_class_date;
    public $id_employee;
    public $isActive;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_class_hour    = 0;
            $this->id_class_date    = 0;
            $this->id_employee      = 0;
            $this->isActive         = 1;
        }
    }
}

class filterClassScheduling extends MY_Entity_Filter
{
    public $start;
    public $end;
    public $id_employee;
    public $isActive;
    public function __construct()
    {
        parent::__construct();
        $this->start        = NULL;
        $this->end          = NULL;
        $this->id_employee  = NULL;
        $this->isActive     = NULL;
        
    }
    
}