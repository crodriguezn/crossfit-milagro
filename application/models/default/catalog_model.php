<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_Model extends MY_Model
{
    protected $table = 'catalog';

    function __construct()
    {
        parent::__construct();
    }

    public function listByType($catalog_type_code)
    {
        $sql = '
            SELECT
                "c".*
            FROM "'. ( $this->table ) .'" AS "c"
                INNER JOIN "catalog_type" AS "ct" ON "c"."id_catalog_type" = "ct"."id"
            WHERE
                "ct"."code" = ?
            ORDER BY
                "c"."name" ASC
        ';

        $query = $this->db->query($sql, array($catalog_type_code));

        $rows = $query->result_array();

        $eCatalogs = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eCatalog = new eCatalog();
                $eCatalog->parseRow($row);

                $eCatalogs[] = $eCatalog;
            }
        }
        
        return $eCatalogs;
    }
    
    function listAll($txt_filter='', $limit=NULL, $offset=NULL)
    {
        $query = $this->db->query( $this->queryAll($txt_filter, $limit, $offset) );

        $rows = $query->result_array();

        $eTypeByCatalogos = array();
        
        if (!empty($rows)) 
        {
            foreach ($rows as $row) 
            {
                $eTypeByCatalog = new eCatalog();
                $eTypeByCatalog->parseRow($row);

                $eTypeByCatalogos[] = $eTypeByCatalog;
            }
        }

        return $eTypeByCatalogos;
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
                ".( $this->table )."
                INNER JOIN catalog_type ON ".( $this->table ).".\"id_catalog_type\" = catalog_type.\"id\"
            WHERE 
                1=1
                AND 
                \"id_catalog_type\"=".( $this->db->escape_like_str($txt_filter) )."
            ".( $isQueryCount ? '' : " ORDER BY \"name\" ASC " )."
            ".( $isQueryCount || is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }
}

class eCatalog extends MY_Entity
{
    public $id_catalog_type;
    public $name;
    public $code;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_catalog_type = NULL;
            $this->name = '';
            $this->code = '';
        }
    }
}