<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Person_Model extends MY_Model
{
    protected $table = 'person';

    function __construct()
    {
        parent::__construct();
    }

  
    function loadByDocument( $document, $except_value='' )
    {
        $ePerson = $this->load($document, 'document', $except_value);

        return $ePerson;
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);

        $ePerson = new ePerson();
        
        $ePerson->parseRow($row);

        return $ePerson;
    }
    
    function save(ePerson &$ePerson)
    {
        try
        {
            if( empty($ePerson->id) )
            {
                $ePerson->id = $this->genId();
                $this->insert($ePerson->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($ePerson->toData(FALSE), $ePerson->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    
    function existDocument($document) {
        $sql = "select count(DOCUMENT) from person where DOCUMENT='$document'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($result[0]->count == 0) {
            return 'success';
        } else {
            return 'error';
        }
    }

}

class ePerson extends MY_Entity
{
    public $name;
    public $surname;
    public $tipo_documento;
    public $document;
    public $birthday;
    public $gender;
    public $address;
    public $phone_cell;
    public $email;
    public $estado_civil;
    public $tipo_sangre;
    public $id_ciudad;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name = '';
            $this->surname = '';
            $this->tipo_documento = '';
            $this->document = '';
            $this->birthday = NULL;
            $this->gender = '';
            $this->address = NULL;
            $this->phone_cell = '';
            $this->email = '';
            $this->estado_civil = '';
            $this->tipo_sangre = '';
            $this->id_ciudad = 0;
        }
    }
}