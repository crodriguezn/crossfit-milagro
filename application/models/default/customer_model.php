<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_Model extends MY_Model 
{
    protected $table = 'customer';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eCustomer = new eCustomer();
        
        $eCustomer->parseRow($row);
        
        return $eCustomer;
    }
    
    function save(eCustomer &$eCustomer)
    {
        try
        {
            if (empty($eCustomer->id)) 
            {
                $eCustomer->id = $this->genId();
                $eCustomer->code = Helper_Formula::CrearCodigoCustomer($eCustomer->id, 'WOD');
                $this->insert($eCustomer->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eCustomer->toData(TRUE), $eCustomer->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    function filter( filterCustomer $filter, &$eCustomers, &$ePersons, &$eCiudades, &$count )
    {
        $eCustomers = array();
        $ePersons   = array();
        $eCiudades  = array();
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
                $eCustomer = new eCustomer();
                $eCustomer->parseRow($row, 'c_');

                $eCustomers[] = $eCustomer;
                
                $ePerson = new ePerson();
                $ePerson->parseRow($row, 'p_');

                $ePersons[] = $ePerson;
                
                $eCiudad = new eCiudad();
                $eCiudad->parseRow($row, 'ci_');

                $eCiudades[] = $eCiudad;
                
            }
        }
        
    }

    function filterQuery( filterCustomer $filter, $useCounter=FALSE )
    {
        $select_customer = $this->buildSelectFields('c_', 'c', $this->table);
        $select_person = $this->buildSelectFields('p_', 'p', 'person');
        $select_ciudad = $this->buildSelectFields('ci_', 'ci', 'ciudad');
        $select = ($select_customer.','.$select_person.','.$select_ciudad);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"c\"
                INNER JOIN \"person\" AS \"p\" ON \"p\".\"id\" = \"c\".\"id_person\" 
                INNER JOIN \"ciudad\" AS \"ci\" ON \"ci\".\"id\" = \"p\".\"id_ciudad\" 
            WHERE 1=1
                AND (
                    UPPER(\"p\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"document\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"surname\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"c\".\"code\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( $useCounter ? '' : " GROUP BY \"c\".\"id\", \"p\".\"id\", \"ci\".\"id\" " ) . "
            " . ( $useCounter ? '' : " ORDER BY \"surname\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        //print_r($sql);
        return $sql;
    }
    
}

class eCustomer extends MY_Entity
{
    public $id_person;
    public $code;
    public $registration_date;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_person = 0;
            $this->code = '';
            $this->registration_date = '';
        }
    }
}

class filterCustomer extends MY_Entity_Filter
{
    //public $id_person;
    public function __construct()
    {
        parent::__construct();
        //$this->id_person = NULL;
        
    }
    
}