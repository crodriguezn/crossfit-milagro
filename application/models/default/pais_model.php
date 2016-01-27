<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pais_Model extends MY_Model
{
    protected $table = 'pais';

    function __construct()
    {
        parent::__construct();
    }

    function load( $id_pais )
    {
        $row = parent::load($id_pais);

        $ePais = new ePais();
        $ePais->parseRow($row);
        
        return $ePais;
    }
    
    function save( ePais &$ePais )
    {
        try
        {
            if( empty($ePais->id) )
            {
                $ePais->id = $this->genId();
                $this->insert( $ePais->toData() );
            }
            else
            {
                $this->update( $ePais->toData(FALSE), $ePais->id );
            }
        }
        catch( Exception $e )
        {
            //Helper_Log::write( $e->getMessage() );
            throw new Exception( $e->getMessage() );
        }
    }
    
    function listAll($txt_filter='', $limit=null, $offset=null)
    {
        $query = $this->db->query( $this->queryAll($txt_filter, $limit, $offset) );

        $rows = $query->result_array();
        
        $ePaises = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $ePais = new ePais();
                $ePais->parseRow($row);
                
                $ePaises[] = $ePais;
            }
        }
            
        return $ePaises;
    }
    
    function countAll($txt_filter='')
    {
        $query = $this->db->query( $this->queryAll($txt_filter, null, null) );

        return $query->num_rows();
    }
    
    function queryAll($txt_filter='', $limit=null, $offset=null )
    {
        $sql = "
            SELECT *
            FROM ".( $this->table )."
            WHERE 1=1
                AND (
                    nombre LIKE '%".( $this->db->escape_like_str($txt_filter) )."%'
                )
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }
}

class ePais extends MY_Entity
{
    public $nombre;
    public $FIPS104;
    public $ISO2;
    public $ISON;
    public $Internet;
    public $Capital;
    public $MapReference;
    public $NationalitySingular;
    public $NationalityPlural;
    public $Currency;
    public $CurrencyCode;
    public $Population;
    public $Title;
    public $Comment;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->nombre = '';
            $this->FIPS104 = '';
            $this->ISO2 = '';
            $this->ISON = '';
            $this->Internet = '';
            $this->Capital = '';
            $this->MapReference = '';
            $this->NationalitySingular = '';
            $this->NationalityPlural = '';
            $this->Currency = '';
            $this->CurrencyCode = '';
            $this->Population = '';
            $this->Title = '';
            $this->Comment = '';
        }
    }
}