<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_Type_Model extends MY_Model
{
    protected $table = 'catalog_type';

    function __construct()
    {
        parent::__construct();
    }
    
    function load($value, $by = 'id', $except_value = '', $except_by = 'id') {
        return parent::load($value, $by, $except_value, $except_by);
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id') {
        return parent::loadArray($where, $except_value, $except_by);
    }
            
    function listAll($txt_filter='', $limit=NULL, $offset=NULL)
    {
        $query = $this->db->query( $this->queryAll($txt_filter, $limit, $offset) );

        $rows = $query->result_array();

        $eCatalogByTypes = array();
        
        if (!empty($rows)) 
        {
            foreach ($rows as $row) 
            {
                $eCatalogByType = new eCatalogType();
                $eCatalogByType->parseRow($row);

                $eCatalogByTypes[] = $eCatalogByType;
            }
        }

        return $eCatalogByTypes;
    }
    

    function countAll($txt_filter='')
    {
        $query = $this->db->query( $this->queryAll($txt_filter, NULL, NULL, TRUE) );

        $row = $query->row_array();
        
        return $row['count'];
    }

    function queryAll($txt_filter='', $limit=NULL, $offset=NULL, $isQueryCount=FALSE) {
        
        $sql = "
            SELECT
                ".( $isQueryCount ? "COUNT(*) AS \"count\"" : "".( $this->table ).".*" )."
            FROM
                ".( $this->table)."
            WHERE 1=1
                AND (
                    \"name\" LIKE '%".( $this->db->escape_like_str($txt_filter) )."%' OR
                    \"code\" LIKE '%".( $this->db->escape_like_str($txt_filter) )."%'
                )
            ".( $isQueryCount ? '' : " ORDER BY \"name\" ASC " )."
            ".( $isQueryCount || is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }
}

class eCatalogType extends MY_Entity
{
    public $name;
    public $code;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->code = '';
        }
    }
}