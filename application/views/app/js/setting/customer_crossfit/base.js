var Customer_Crossfit_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    customer_crossfit_form_default: $.parseJSON('<?php echo json_encode($customer_crossfit_form_default); ?>'),
    control_imc_form_default: $.parseJSON('<?php echo json_encode($control_imc_form_default); ?>'),
    data_company_branch: []
};

/* --VARIABLE DE ENTIDAD--  */
var ePerson = function ()
{
    var self = this;
    var name, surname, tipo_documento, document, birthday, gender, address, phone_cell, email;
    var estado_civil, tipo_sangre, id_pais, id_provincia, id_ciudad, id_person;
    self.init = function (data/*=undefined*/, useDefault/*=false*/)/*contrutor de la entidad*/
    {
        if (useDefault)
        {
            data = Customer_Crossfit_Base.customer_crossfit_form_default;
        }
        self.id_person = data.id_person.value;
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

    };
    function __construct()
    {
        self.init(Customer_Crossfit_Base.customer_crossfit_form_default, true);
    }
    ;
    __construct();
};


var eUser = function ()
{
    var self = this;
    var id_user, username;
    self.init = function (data/*=undefined*/, useDefault/*=false*/)/*contrutor de la entidad*/
    {
        if (useDefault)
        {
            data = Customer_Crossfit_Base.customer_crossfit_form_default;
        }
        self.id_user = data.id_user.value;
        self.username = data.username.value;

    };
    function __construct()
    {
        self.init(Customer_Crossfit_Base.customer_crossfit_form_default, true);
    }
    ;
    __construct();
};

var eProfile = function ()
{
    var self = this;
    var id_profile, isActive;
    self.init = function (data/*=undefined*/, useDefault/*=false*/)/*contrutor de la entidad*/
    {
        if (useDefault)
        {
            data = Customer_Crossfit_Base.customer_crossfit_form_default;
        }
        self.id_profile = data.id_profile.value;
        self.isActive = data.isActive.value;

    };
    function __construct()
    {
        self.init(Customer_Crossfit_Base.customer_crossfit_form_default, true);
    }
    ;
    __construct();
};

var eCustomer = function ()
{
    var self = this;
    var id_customer, code, registration_date;
    self.init = function (data/*=undefined*/, useDefault/*=false*/)/*contrutor de la entidad*/
    {
        if (useDefault)
        {
            data = Customer_Crossfit_Base.customer_crossfit_form_default;
        }
        self.id_customer = data.id_customer.value;
        self.code = data.code.value;
        self.registration_date = data.registration_date.value;

    };
    function __construct()
    {
        self.init(Customer_Crossfit_Base.customer_crossfit_form_default, true);
    }
    ;
    __construct();
};