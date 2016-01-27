<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_B_Ficha_Alumno extends MY_Form {

    public $id_alumno;
    public $id_persona;
    public $telefono_emergencia;
    public $cod_curso_browse;
    public $name;
    public $surname;
    public $id_tipo_document;
    public $document;
    public $isPasaporteAleman;
    public $birthday;
    public $gender;
    public $address;
    public $calle_principal;
    public $calle_secundaria;
    public $sector_urbanizacion;
    public $phone;
    public $celular;
    public $email;
    public $tipo_sangre;
    public $id_pais;
    public $id_provincia;
    public $id_ciudad;
    public $id_canton;
    public $id_discapacidad;
    public $num_carnet_conadis;
    public $vive_con;
    public $vive_con_detalle;
    public $vive_fuera_pais;
    public $fallecido;
    public $observaciones_discapacidad;
    public $tiene_discapacidad;
    public $estado_civil;
    public $id_profesion;
    public $id_religion;
    public $id_idioma;

    public function __construct($isReadPost = FALSE)
    {
        parent::__construct();
        
        $this->id_alumno = 0;
        $this->id_persona = 0;
        $this->telefono_emergencia = '';
        $this->cod_curso_browse = '';
        $this->name = '';
        $this->surname = '';
        $this->id_tipo_document = 0;
        $this->document = '';
        $this->isPasaporteAleman = 0;
        $this->birthday = '';
        $this->gender = '';
        $this->address = '';
        $this->calle_principal = '';
        $this->calle_secundaria = '';
        $this->sector_urbanizacion = '';
        $this->phone = '';
        $this->celular = '';
        $this->email = '';
        $this->tipo_sangre = '';
        $this->id_pais = 0;
        $this->id_provincia = 0;
        $this->id_ciudad = 0;
        $this->id_canton = 0;
        $this->id_discapacidad = 0;
        $this->num_carnet_conadis = '';
        $this->vive_con = '';
        $this->vive_con_detalle = '';
        $this->vive_fuera_pais = 0;
        $this->observaciones_discapacidad = '';
        $this->estado_civil = '';
        $this->id_profesion = 0;
        $this->id_religion = 0;
        $this->id_idioma = 0;
        $this->tiene_discapacidad = 0;

        if( $isReadPost ) {
            $this->readPost();
        }
    }

    public function readPost()
    {
        $MY = & MY_Controller::get_instance();

        $this->id_alumno = $MY->input->post('id_ficha_alumno');
        $this->id_persona = $MY->input->post('id_ficha_persona');
        $this->telefono_emergencia = $MY->input->post('telefono_emergencia_alumno');
        $this->cod_curso_browse = $MY->input->post('cod_curso_browse_alumno');
        $this->name = $MY->input->post('nombres_alumno');
        $this->surname = $MY->input->post('apellidos_alumno');
        $this->id_tipo_document = $MY->input->post('tipo_identificacion_alumno');
        $this->document = $MY->input->post('numero_identificacion_alumno');
        $this->isPasaporteAleman = $MY->input->post('pasaporte_aleman_alumno');
        $this->birthday = $MY->input->post('fecha_nacimiento_alumno');
        $this->gender = $MY->input->post('genero_alumno');
        $this->address = $MY->input->post('direccion_alumno');
        $this->calle_principal = $MY->input->post('calle_principal_alumno');
        $this->calle_secundaria = $MY->input->post('calle_secundaria_alumno');
        $this->sector_urbanizacion = $MY->input->post('sector_urbanizacion_alumno');
        $this->phone = $MY->input->post('telefono_alumno');
        $this->celular = $MY->input->post('celular_alumno');
        $this->email = $MY->input->post('email_alumno');
        $this->tipo_sangre = $MY->input->post('tipo_sangre_alumno');
        $this->id_pais = $MY->input->post('pais_alumno');
        $this->id_provincia = $MY->input->post('provincia_alumno');
        $this->id_ciudad = $MY->input->post('ciudad_alumno');
        $this->id_canton = $MY->input->post('canton_alumno');
        $this->id_discapacidad = $MY->input->post('discapacidad_alumno');
        $this->num_carnet_conadis = $MY->input->post('n_carnet_conadis_alumno');
        $this->vive_con = $MY->input->post('quien_vive_alumno');
        $this->vive_con_detalle = $MY->input->post('vive_otro_alumno');
        $this->vive_fuera_pais = $MY->input->post('vive_fuera_pais');
        $this->observaciones_discapacidad = $MY->input->post('inf_adicional_conadis_alumno');
        $this->estado_civil = $MY->input->post('estado_civil_alumno');
        $this->id_profesion = $MY->input->post('profesion_alumno');
        $this->id_religion = $MY->input->post('religion_alumno');
        $this->id_idioma = $MY->input->post('idioma_alumno');
    }

    public function setPersonEntity(eBPerson $eBPersonas)
    {
        $this->cod_curso_browse = $eBPersonas->Codigo_A;
        $this->document = $eBPersonas->Identifica;
        $this->name = utf8_decode($eBPersonas->NOMBRES);
        $this->surname = utf8_decode($eBPersonas->APELLIDOS);
        if( $eBPersonas->Fecha_Nac=='' ) {
            $this->birthday = '';
        } 
        else
        {
            $this->birthday = date("Y/m/d", strtotime($eBPersonas->Fecha_Nac));
        }
        if ($eBPersonas->Sexo=='') 
        {
            $this->gender='';
        } 
        else 
          {
            if ($eBPersonas->Sexo == 1) 
            {
                $this->gender = 'GENDER_MALE';
            }
            else
            {
                $this->gender = 'GENDER_FEMALE';
            }
        }

        $this->email = rtrim($eBPersonas->Mail1);
    }

    public function getPersonEntity()
    {
        $eBPersonas = new eBPerson();

        $eBPersonas->cod_curso_browse = $this->cod_curso_browse;
        $eBPersonas->Identifica = $this->document;
        $eBPersonas->NOMBRES = $this->name;
        $eBPersonas->APELLIDOS = $this->surname;
        $eBPersonas->Fecha_Nac = $this->birthday;
        $eBPersonas->Sexo = $this->gender;
        $eBPersonas->Mail1 = $this->email;

        return $eBPersonas;
    }

    public function toArray() {
        return array(
            'fields' => array(
                'id_ficha_alumno' => $this->id_alumno,
                'id_ficha_persona' => $this->id_persona,
                'cod_curso_browse_alumno' => $this->cod_curso_browse,
                'tipo_identificacion_alumno' => $this->id_tipo_document,
                'numero_identificacion_alumno' => $this->document,
                'pasaporte_aleman_alumno' => $this->isPasaporteAleman,
                'nombres_alumno' => $this->name,
                'apellidos_alumno' => $this->surname,
                'fecha_nacimiento_alumno' => $this->birthday,
                'genero_alumno' => $this->gender,
                'pais_alumno' => $this->id_pais,
                'provincia_alumno' => $this->id_provincia,
                'canton_alumno' => $this->id_canton,
                'ciudad_alumno' => $this->id_ciudad,
                'telefono_alumno' => $this->phone,
                'celular_alumno' => $this->celular,
                'email_alumno' => $this->email,
                'direccion_alumno' => $this->address,
                'calle_principal_alumno' => $this->calle_principal,
                'calle_secundaria_alumno' => $this->calle_secundaria,
                'sector_urbanizacion_alumno' => $this->sector_urbanizacion,
                'quien_vive_alumno' => $this->vive_con,
                'vive_otro_alumno' => $this->vive_con_detalle,
                'discapacidad_alumno' => $this->id_discapacidad,
                'n_carnet_conadis_alumno' => $this->num_carnet_conadis,
                'inf_adicional_conadis_alumno' => $this->observaciones_discapacidad,
                'tipo_sangre_alumno' => $this->tipo_sangre,
                'telefono_emergencia_alumno' => $this->telefono_emergencia,
                'estado_civil_alumno' => $this->estado_civil,
                'religion_alumno' => $this->id_religion,
                'profesion_alumno' => $this->id_profesion,
                'idioma_alumno' => $this->id_idioma
            ),
            'errors' => $this->errors
        );
    }

}
