<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Control_IMC_Model extends MY_Model 
{
    protected $table = 'control_imc';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eControlIMC = new eControlIMC();
        
        $eControlIMC->parseRow($row);
        
        return $eControlIMC;
    }
    
    function save(eControlIMC &$eControlIMC)
    {
        try
        {
            if (empty($eControlIMC->id)) 
            {
                $eControlIMC->id = $this->genId();
                 
                $this->insert($eControlIMC->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eControlIMC->toData(TRUE), $eControlIMC->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    
    function filter( filterControlIMC $filter, &$eControlIMCs, &$count )
    {
        $eControlIMCs = array();
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
                $eControlIMC = new eControlIMC();
                $eControlIMC->parseRow($row, 'c_');

                $eControlIMCs[] = $eControlIMC;
            }
        }
        
    }

    function filterQuery( filterControlIMC $filter, $useCounter=FALSE )
    {
        $select_controlIMC = $this->buildSelectFields('c_', 'c', $this->table);
        $select = ($select_controlIMC);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"c\"
            WHERE 1=1
                AND \"c\".\"id_customer\" = $filter->id_customer
                ".( is_numeric($filter->text) ? "
                    AND (
                    \"c\".\"weight\" = '" .($filter->text). "' OR 
                    \"c\".\"height\" = '" .($filter->text). "'  
                   
                    )"
                    :
                '')."
            " . ( $useCounter ? '' : " GROUP BY \"c\".\"id\" " ) . "
            " . ( $useCounter ? '' : " ORDER BY \"update_date\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        //print_r($sql);
        return $sql;
    }
    
    
}

class eControlIMC extends MY_Entity
{
    public $id_customer;
    public $weight;
    public $height;
    public $update_date;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_customer = 0;
            $this->weight = 0;
            $this->height = 0;
            $this->update_date = '';
        }
    }
}

class filterControlIMC extends MY_Entity_Filter
{
    public $id_customer;
    public function __construct()
    {
        parent::__construct();
        $this->id_customer = NULL;
        
    }
    
}