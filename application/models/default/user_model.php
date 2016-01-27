<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends MY_Model
{
    protected $table = 'user';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by='id', $except_value='', $except_by='id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eUser = new eUser();
        
        $eUser->parseRow($row);
        
        return  $eUser;
    }
        
    function save(eUser &$eUser)
    {
        try
        {
            if (empty($eUser->id))
            {
                $eUser->id = $this->genId();
                $this->insert($eUser->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eUser->toData(FALSE), $eUser->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    
    function login($username, $password)
    {
        $sql = '
            SELECT
                "u".*
            FROM
                "user" AS "u"
                INNER JOIN "person" AS "p" ON "p"."id" = "u"."id_person"
                LEFT JOIN "user_profile" AS "up" ON "up".id_user="u"."id"
            WHERE 1=1
                AND "u"."username" = '.( $this->db->escape($username) ).'
                AND "u"."password" = '.( $this->db->escape(md5($password)) ).'
                AND "up"."isActive" = 1
        ';

        //Helper_Log::write($sql, Helper_Log::LOG_DB);
        
        $query = $this->db->query( $sql );
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $row = $query->row_array();
        
        $eUser = new eUser();
       
        $eUser->parseRow($row);
        
        return $eUser;
    }
    
    function checkPassword( $id_user, $password )
    {
        $query = $this->db->get_where($this->table, array('id'=>$id_user, 'password'=>md5($password)));
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $row = $query->row_array();
        
        $eUser = new eUser();
       
        $eUser->parseRow($row);
        
        return ( $eUser->isEmpty() ) ? FALSE : TRUE;
    }
    
    function updatePassword( $id_user, $password )
    {
        // throw new Exception
        parent::update( array( 'password' => md5( $password ) ), $id_user );
        Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
    }
    
    function filter( filterUser $filter, &$eUsers, &$ePersons, &$count )
    {
        $eUsers = array();
        $ePersons = array();
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
                $eUser = new eUser();
                $eUser->parseRow($row, 'u_');

                $eUsers[] = $eUser;
                
                $ePerson = new ePerson();
                $ePerson->parseRow($row, 'p_');

                $ePersons[] = $ePerson;
                
            }
        }
        
    }

    function filterQuery( filterUser $filter, $useCounter=FALSE )
    {
        $select_user = $this->buildSelectFields('u_', 'u', $this->table);
        $select_person = $this->buildSelectFields('p_', 'p', 'person');
        $select = ($select_user.','.$select_person);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"u\"
                INNER JOIN \"person\" AS \"p\" ON \"p\".\"id\" = \"u\".\"id_person\" 
                INNER JOIN \"user_profile\" AS \"up\" ON \"up\".\"id_user\" = \"u\".\"id\" 
                INNER JOIN \"user_profile__company_branch\" AS \"up_cb\" ON \"up_cb\".\"id_user_profile\" = \"up\".\"id\" 
            WHERE 1=1
                AND (
                    UPPER(\"p\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"document\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"surname\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"u\".\"username\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . (is_null($filter->id_company_branch) ? '' : ' AND \"up_cb\".\"id_company_branch\" = '.($filter->id_company_branch).'' ) . "
            GROUP BY \"u\".\"id\", \"p\".\"id\"
            " . ( $useCounter ? '' : " ORDER BY \"surname\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        
        return $sql;
    }
}

class eUser extends MY_Entity
{
    public $id_person;
    public $username;
    public $password;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_person = NULL;
            $this->username = '';
            $this->password = '';
        }
    }
}

class filterUser extends MY_Entity_Filter
{
    public $id_company_branch;
    public function __construct()
    {
        parent::__construct();
        $this->id_company_branch = NULL;
        
    }
    
}