var UserProfile_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    profile_form_default: $.parseJSON('<?php echo json_encode($profile_form_default); ?>'),
    user_form_default: $.parseJSON('<?php echo json_encode($user_form_default); ?>')
};

/* --VARIABLE DE ENTIDAD--  */
var eProfile = function ()
{
    var self = this;
    var name, surname, tipo_documento, document, birthday, gender, address, phone_cell, email;
    var estado_civil, tipo_sangre, id_pais, id_provincia, id_ciudad, name_profile;
    self.init = function (data/*=undefined*/, useDefault/*=false*/)/*contrutor de la entidad*/
    {
        if (useDefault)
        {
            data = UserProfile_Base.profile_form_default;
        }

        self.name = data.name.value;
        self.surname = data.surname.value;
        self.tipo_documento = data.tipo_documento.value;
        self.document = data.document.value;
        self.birthday = data.birthday.value;
        self.gender = data.gender.value;
        self.address = data.address.value;
        self.phone_cell = data.phone_cell.value;
        self.email = data.email.value;
        self.estado_civil = data.estado_civil.value;
        self.tipo_sangre = data.tipo_sangre.value;
        self.id_pais = data.id_pais.value;
        self.id_provincia = data.id_provincia.value;
        self.id_ciudad = data.id_ciudad.value;
        self.name_profile = data.name_profile.value;

    };
    function __construct()
    {
        self.init(UserProfile_Base.profile_form_default, true);
    }
    ;
    __construct();
};