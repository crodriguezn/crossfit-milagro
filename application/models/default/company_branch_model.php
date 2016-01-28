<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_Branch_Model extends MY_Model
{
    protected $table = 'company_branch';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id') 
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eCompanyBranch = new eCompanyBranch();
        $eCompanyBranch->parseRow($row);
        
        return $eCompanyBranch;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id') 
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eCompanyBranch = new eCompanyBranch();
        $eCompanyBranch->parseRow($row);
        
        return $eCompanyBranch;
    }
            
    function save( eCompanyBranch &$eCompanyBranch )
    {
        try
        {
            if( empty($eCompanyBranch->id) )
            {
                $eCompanyBranch->id = $this->genId();
                $this->insert( $eCompanyBranch->toData() );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update( $eCompanyBranch->toData(FALSE), $eCompanyBranch->id );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch( Exception $e )
        {
            //Helper_Log::write( $e->getMessage() );
            throw new Exception( $e->getMessage() );
        }
    }
    
    public function listByCompany( $id_company, $isActive = NULL )
    {
        $db =& $this->getConnection();
        
        //var_dump($value);
        $this->db->where('id_company', $id_company);
        
        if( !is_null($isActive) )
        {
            $this->db->where('isActive', $isActive);
        }
        
        //$db->where('id_company', $id_company);
        
        $this->db->order_by('name','ASC');
        //$db->order_by('name','ASC');
        
        //$query = $db->get( $this->table );
        $query = $this->db->get( $this->table );
        
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $rows = $query->result_array();

        $eCompanyBranches = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eCompanyBranch = new eCompanyBranch();
                
                $eCompanyBranch->parseRow($row);
                
                $eCompanyBranches[] = $eCompanyBranch;
            }
        }
        
        return $eCompanyBranches;
    }
    
    
    // ****************************************************************
    
    function filter( filterCompanyBranch $filter, &$eCompanyBranches, &$count=NULL )
    {
        $eCompanyBranches = array();
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
                $eCompanyBranch = new eCompanyBranch();
                
                $eCompanyBranch->parseRow($row, 'cb_');
                
                $eCompanyBranches[] = $eCompanyBranch;
            }
        }        
    }

    function filterQuery( filterCompanyBranch $filter, $useCounter=FALSE )
    {
        $select_company_branch = $this->buildSelectFields('cb_', 'cb', $this->table);
        
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select_company_branch )."
            FROM \"".( $this->table )."\" AS \"cb\"
            WHERE 1=1
                " . ( is_null($filter->isActive) ? '' : " AND \"cb\".\"isActive\"=" . ( $this->db->escape($filter->isActive) ) . " " ) . "
                AND \"cb\".\"id_company\"=" . ( $this->db->escape($filter->id_company) ) . "
                AND (
                    UPPER(\"cb\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"cb\".\"address\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"cb\".\"phone\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( $useCounter ? '' : " ORDER BY \"cb\".\"name\" ASC " ) . "
            " . ( is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";

        return $sql;
    }
    
}

class eCompanyBranch extends MY_Entity
{
    public $id_company;
    public $name;
    public $address;
    public $phone;
    public $isActive;
    public $id_ciudad;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct( $useDefault );
        
        if( $useDefault )
        {
            $this->id_company = NULL;
            $this->name = '';
            $this->address = '';
            $this->phone = '';
            $this->isActive = 1;
            $this->id_ciudad = NULL;
        }
    }
}

class filterCompanyBranch extends MY_Entity_Filter
{
    public $id_company;
    public $isActive;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->id_company = FALSE;
        $this->isActive = NULL;
    }
}