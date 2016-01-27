<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Profile_Company_Branch_Model extends MY_Model
{
    protected $table = 'user_profile__company_branch';

    function __construct()
    {
        parent::__construct();
    }

    function load( $value, $by='id', $except_value='', $except_by='id' )
    {
        $row = parent::load($value, $by, $except_value, $except_by);

        $eUserProfileCompanyBranch = new eUserProfileCompanyBranch();
        $eUserProfileCompanyBranch->parseRow($row);
        
        return $eUserProfileCompanyBranch;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id') 
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eUserProfileCompanyBranch = new eUserProfileCompanyBranch();
        $eUserProfileCompanyBranch->parseRow($row);
        
        return $eUserProfileCompanyBranch;
    }
    
    function save(eUserProfileCompanyBranch &$eUserProfileCompanyBranch )
    {
        try
        {
            if( empty($eUserProfileCompanyBranch->id) )
            {
                $eUserProfileCompanyBranch->id = $this->genId();
                $this->insert( $eUserProfileCompanyBranch->toData() );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update( $eUserProfileCompanyBranch->toData(FALSE), $eUserProfileCompanyBranch->id );
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch( Exception $e )
        {
            throw new Exception( $e->getMessage() );
        }
    }
    
    
     public function listCompanyBranchsByUserProfile( $id_user, $id_profile, $isActive=NULL )
    {
        $select_company_branch = $this->buildSelectFields('cb_', 'cb', 'company_branch' );
        
        $sql = '
            SELECT
                '.( $select_company_branch ).'
            FROM
                "'.( $this->table ).'" AS "upcb"
                INNER JOIN "user_profile" AS "up" ON "up"."id" = "upcb"."id_user_profile"
                INNER JOIN "profile" AS "p" ON "p"."id" = "up"."id_profile"
                INNER JOIN "user" AS "u" ON "u"."id" = "up"."id_user"
                INNER JOIN "company_branch" AS "cb" ON "cb"."id" = "upcb"."id_company_branch"
            WHERE 1=1
                AND "p"."id" = '.( $this->db->escape($id_profile) ).'
                AND "u"."id" = '.( $this->db->escape($id_user) ).'
                '. ( is_null($isActive) ? '':" AND \"cb\".\"isActive\"='". ( $isActive ) ."'" ) .'
        ';
        $query = $this->db->query($sql);
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
                
                $eCompanyBranch->parseRow($row,'cb_');
                
                $eCompanyBranches[] = $eCompanyBranch;
            }
        }
        
        return $eCompanyBranches;
    }
    
    public function deleteByUserProfile( $id_user_profile )
    {
        if( $this->db->delete($this->table, array('id_user_profile'=>$id_user_profile)) === FALSE )
        {
            throw new Exception("Error in: TABLE:".$this->table.", FUNCTION:".__FUNCTION__);
        }
        Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_DELETE );
    }
    
}

class eUserProfileCompanyBranch extends MY_Entity
{
    public $id_user_profile;
    public $id_company_branch;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_user_profile = 0;
            $this->id_company_branch = 0;
        }
    }
}