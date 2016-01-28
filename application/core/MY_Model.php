<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $table = '';

    protected $conn_type;
    
    const CONN_DEF = 0; // default
    const CONN_DBD = 1; // digifort

    function __construct( $conn_type=self::CONN_DEF )
    {
        parent::__construct();
        
        $this->conn_type = $conn_type;
    }
    
    public function getConnection()
    {
        $db = NULL;
        
        switch( $this->conn_type )
        {
            case self::CONN_DEF :
                $db =& $this->db;
                break;
            case self::CONN_DBD :
                $db =& $this->dbd;
                break;
        }
        
        return $db;
    }
    
    function getTableName()
    {
        return $this->table;
    }
    
    function buildSelectFields( $prefix, $alias='', $table='' )
    {
        $db =& $this->getConnection();
        
        $str = '';
        
        if( empty($table) ){ $table = $this->table; }
        if( empty($table) ){ return $str; }
        
        $fields = $db->list_fields( $table );
        
        foreach( $fields as $field )
        {
            $str .= ( empty($str)?'':',' ) . ( empty($alias) ? '' : '"'.$alias.'".' ) . '"'.$field.'" AS "'.( $prefix . $field ).'"';
        }
        
        return $str;
    }
    
    //*****************************************************************
    //*****************************************************************
    
    function lastId()
    {
        $db =& $this->getConnection();
        
        $id = $db->insert_id();
        
        return $id;
    }
    
    function genId()
    {
        return $this->genMax('id') + 1;
    }
    
    function genMax( $key )
    {
        $db =& $this->getConnection();
        
        $db->select_max($key);
        $query = $db->get( $this->table );
        
        $row = $query->row_array();
        
        return $row[$key];
    }
    
    //*****************************************************************
    //*****************************************************************
    
    function load($value, $by='id', $except_value='', $except_by='id')
    {
        $db =& $this->getConnection();
        
        //var_dump($value);
        $db->where($by, $value);
        
        if( !empty($except_value) )
        {
            $db->where("$except_by <>", $except_value);
        }
        
        $query = $db->get( $this->table );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        return $query->row_array();
    }

    function loadArray($where = array(), $except_value='', $except_by='id')
    {
        $db = $this->getConnection();
        
        if(is_array($where))
        {
             //var_dump($where);
            $db->where($where);
        }
        
        if( !empty($except_value) )
        {
            $db->where("$except_by <>", $except_value);
        }
        
        $query = $db->get( $this->table );
        
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        return $query->row_array();

    }
    
    
    function execSaveUpdateDatas( $arrDatas )
    {
        if( !empty($arrDatas) )
        {
            foreach( $arrDatas as $arrData )
            {
                $this->execSaveUpdate( $arrData, FALSE );
            }
        }
    }
    
    function execSaveUpdate( $arrData, $isReturnId=TRUE )
    {
        $id_result = NULL;
        
        if( isset($arrData['id']) && !empty($arrData['id']) )
        {
            $id_tmp = $arrData['id'];
            
            unset( $arrData['id'] );
            
            $dataTmp = $this->load($id_tmp);
            if( empty($dataTmp) )
            {
                $this->save( $arrData );
                $id_result = $this->lastId();
            }
            else
            {
                $this->update( $arrData, $id_tmp );
                $id_result = $id_tmp;
            }
        }
        else
        {
            $this->save( $arrData );
            $id_result = $this->lastId();
        }
        
        if( $isReturnId )
        {
            return $id_result;
        }
    }
    
    /*function query($sql, $binds = FALSE, $return_object = TRUE)
    {
        $db =& $this->getConnection();
        
        if( $db->query( $sql, $binds, $return_object ) === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
        
    }*/
    
    function insert( $arrData )
    {
        $db =& $this->getConnection();
        
        if( $db->insert($this->table, $arrData) === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
    }

    function update( $arrData, $value, $by='id' )
    {
        $db = $this->getConnection();
        
        if( $db->update($this->table, $arrData, array($by=>$value)) === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
    }
    
    function delete( $value, $by='id' )
    {
        $db = $this->getConnection();
        
        if( $db->delete($this->table, array($by=>$value)) === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception( $this->messageError(__FUNCTION__, TRUE) );
        }
    }
    
    function lastQuery()
    {
        $db = $this->getConnection();
        return $db->last_query();
    }
    
    function messageError( $function, $isHTML = TRUE )
    {
        $msg = "".
            "CLASS: ".( __CLASS__ ).( $isHTML?'<br/>':"\n" ).
            "FUNCTION: $function".( $isHTML?'<br/>':"\n" ).
            "ERROR NUMBER: ".$this->db->_error_number().( $isHTML?'<br/>':"\n" ).
            "ERROR MESSAGE: ".$this->db->_error_message().( $isHTML?'<br/>':"\n" ).
            "QUERY: ".( $this->db->last_query() );
        
        //Helper_Log::write( $msg );
        
        return $msg;
    }
    
    function begin()
    {
        $db =& $this->getConnection();
        return $db->trans_begin();
    }
    
    function commit()
    {
        $db =& $this->getConnection();
        return $db->trans_commit();
    }
    
    function rollback()
    {
        $db =& $this->getConnection();
        return $db->trans_rollback();
    }
}
