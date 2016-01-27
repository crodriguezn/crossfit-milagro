<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Profile_Model extends MY_Model
{
    protected $table = 'user_profile';

    function __construct()
    {
        parent::__construct();
    }

    function load($value, $by='id', $except_value='', $except_by='id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eUserProfile = new eUserProfile();
        $eUserProfile->parseRow($row);
        
        return  $eUserProfile;
    }
    
    function loadArray($where = array(), $except_value = '', $except_by = 'id')
    {
        $row = parent::loadArray($where, $except_value, $except_by);
        
        $eUserProfile = new eUserProfile();
        $eUserProfile->parseRow($row);
        
        return  $eUserProfile;
    }
            
    function save(eUserProfile &$eUserProfile)
    {
        try
        {
            if (empty($eUserProfile->id))
            {
                $eUserProfile->id = $this->genId();
                $this->insert($eUserProfile->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eUserProfile->toData(FALSE), $eUserProfile->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    
    public function listProfilesByUser( $id_user, $isActive = NULL )
    {
        
        $select_profile = $this->buildSelectFields('p_', 'p', 'profile' );
        
        $sql = '
            SELECT
                '.( $select_profile ).'
            FROM
                "'.( $this->table ).'" AS "up"
                INNER JOIN "profile" AS "p" ON "p"."id" = "up"."id_profile"
                INNER JOIN "user" AS "u" ON "u"."id" = "up"."id_user"
            WHERE 1=1
                AND "u"."id" = '.( $this->db->escape($id_user) ).'
                '. ( is_null($isActive) ? '':" AND \"p\".\"isActive\"='". ( $isActive ) ."'" ) .'
        ';
        
        $query = $this->db->query($sql);
        if( $query === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }

        $rows = $query->result_array();

        $eProfiles = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eProfile = new eProfile();
                
                $eProfile->parseRow($row, 'p_');
                
                $eProfiles[] = $eProfile;
            }
        }
        
        return $eProfiles;
    }
    
    
}

class eUserProfile extends MY_Entity
{
    public $id_user;
    public $id_profile;
    public $isActive;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_user = 0;
            $this->id_profile = 0;
            $this->isActive = 0;
        }
    }
}