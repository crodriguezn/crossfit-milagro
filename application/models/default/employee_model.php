<?php

/*
 * @autor Carlos Luis Rodriguez Nieto (taylorluis93@gmail.com)
 * @date 21-abr-2017
 * @time 18:40:38
 * @link http://luis-rodriguez-ec.herokuapp.com/site/index
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employee_Model extends MY_Model 
{
    protected $table = 'employee';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eEmployee = new eEmployee();
        
        $eEmployee->parseRow($row);
        
        return $eEmployee;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id') 
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eEmployee = new eEmployee();
        
        $eEmployee->parseRow($row);
        
        return $eEmployee;
    }
    
    function save(eEmployee &$eEmployee)
    {
        try
        {
            if (empty($eEmployee->id)) 
            {
                $eEmployee->id = $this->genId();
                $this->insert($eEmployee->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eEmployee->toData(TRUE), $eEmployee->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    function filter(filterEmployee $filter, &$eEmployees, &$ePersons, &$count )
    {
        $eEmployees = array();
        $ePersons   = array();
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
                $eEmployee = new eEmployee();
                $eEmployee->parseRow($row, 'e_');

                $eEmployees[] = $eEmployee;
                
                $ePerson = new ePerson();
                $ePerson->parseRow($row, 'p_');

                $ePersons[] = $ePerson;
                
            }
        }
        
    }

    function filterQuery( filterEmployee $filter, $useCounter=FALSE )
    {
        $select_employee = $this->buildSelectFields('e_', 'e', $this->table);
        $select_person = $this->buildSelectFields('p_', 'p', 'person');
        $select = ($select_employee.','.$select_person);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"e\"
                INNER JOIN \"person\" AS \"p\" ON \"p\".\"id\" = \"e\".\"id_person\" 
            WHERE 1=1
                AND (
                    UPPER(\"p\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"document\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"surname\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') 
                )
                " .( is_null($filter->isCoach) ? "":" AND (\"e\".\"isCoach\"=".($filter->isCoach).")" ). "
            " . ( $useCounter ? '' : " ORDER BY \"p\".\"surname\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        //print_r($sql);
        return $sql;
    }
    
}

class eEmployee extends MY_Entity
{
    public $id_person;
    public $salary;
    public $start_time;
    public $final_time;
    public $isCoach;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_person            = 0;
            $this->salary               = '';
            $this->start_time           = '';
            $this->final_time           = '';
            $this->isCoach              = 0;
        }
    }
}

class filterEmployee extends MY_Entity_Filter
{
    public $isCoach;
    public function __construct()
    {
        parent::__construct();
        $this->isCoach = NULL;
        
    }
    
}