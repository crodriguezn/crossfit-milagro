<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ciudad_Model extends MY_Model 
{

    protected $table = 'ciudad';

    function __construct()
    {
        parent::__construct();
    }
    
    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eCiudad = new eCiudad();
        $eCiudad->parseRow($row);

        return $eCiudad;
        
    }

    function loadArray($where = array(), $except_value = '', $except_by = 'id')
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eCiudad = new eCiudad();
        $eCiudad->parseRow($row);

        return $eCiudad;
    }
    
    function save(eCiudad &$eCiudad)
    {
        try
        {
            if (empty($eCiudad->id))
            {
                $eCiudad->id = $this->genId();
                $this->insert($eCiudad->toData());
            }
            else
            {
                $this->update($eCiudad->toData(FALSE), $eCiudad->id);
            }
        } catch (Exception $e)
        {
            //Helper_Log::write( $e->getMessage() );
            throw new Exception($e->getMessage());
        }
    }

    function listAll($txt_filter = '', $limit = null, $offset = null)
    {
        $query = $this->db->query($this->queryAll($txt_filter, $limit, $offset));

        //$result_array = $query->result_array();

        $rows = $query->result_array();

        $eCiudades = array();
        if (!empty($rows))
        {
            foreach ($rows as $row)
            {
                $eCiudad = new eCiudad();
                $eCiudad->parseRow($row);

                $eCiudades[] = $eCiudad;
            }
        }

        return $eCiudades;
    }

    function countAll($txt_filter = '') 
    {
        $query = $this->db->query($this->queryAll($txt_filter, null, null));

        return $query->num_rows();
    }

    function queryAll($txt_filter = '', $limit = null, $offset = null)
    {
        $sql = "
            SELECT *
            FROM " . ( $this->table ) . "
            WHERE 1=1
                AND (
                    nombre LIKE '%" . ( $this->db->escape_like_str($txt_filter) ) . "%'
                )
            " . ( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " ) . "
        ";

        return $sql;
    }

    function listCiudadxProvincia($id_provincia) 
    {
        $sql = "
            SELECT 
                *
            FROM " . ( $this->table ) . "
            WHERE
                1=1 
                AND 
                id_provincia=" .( $this->db->escape($id_provincia) )." ";

        $query = $this->db->query($sql);

        $rows = $query->result_array();

        $eCiudades = array();
        
        if (!empty($rows))
        {
            foreach ($rows as $row)
            {
                $eCiudad = new eCiudad();
                
                $eCiudad->parseRow($row);

                $eCiudades[] = $eCiudad;
            }
        }

        return $eCiudades;
    }
}

class eCiudad extends MY_Entity
{
    public $id_pais;
    public $id_provincia;
    public $nombre;
    public $Latitude;
    public $Longitude;
    public $TimeZone;
    public $DmaId;
    public $Code;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct( $useDefault );
        
        if( $useDefault )
        {
            $this->id_pais = NULL;
            $this->id_provincia = NULL;
            $this->nombre = '';
            $this->Latitude = '';
            $this->Longitude = '';
            $this->TimeZone = '';
            $this->DmaId = '';
            $this->Code = '';
        }
    }
}