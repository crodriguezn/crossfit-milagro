$.fn.modal.Constructor.prototype.enforceFocus = function () {
};
var Administration_Tab_Controller = {
    init: function ()
    {
        Picture_Control.init();
        Profile_Controller.init();
        User_Controller.init();
    }
};

var Picture_Control = {
    init: function ()
    {
        var self = this;
        self.$page = $('.thumbnail');
        $('.action-upload', self.$page).click(function () {
            if (UserProfile_Base.permissions.update)
            {
                Modal_Picture.open();
            }
            else
            {
                Core.Notification.error('No tiene permiso para Editar');
            }
        });

        $('.action-delete-picture', self.$page).click(function () {
            if (UserProfile_Base.permissions.update)
            {
                self.deletePicture();
            }
            else
            {
                Core.Notification.error('No tiene permiso para Editar');
            }
        });
        if (!UserProfile_Base.permissions.update)
        {
            $('.action-upload', self.$page).hide();
            $('.action-delete-picture', self.$page).hide();
            $('.thumb-options', self.$page).hide();
        }
        
        self.load();
        Modal_Picture.init();
    },
    load: function ()
    {
        var self = this;
        UProfile_Model.loadPictureProfile(function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
            }
            else
            {
                self.refreshPicture(res.data.uri);
            }
        });
    },
    refreshPicture: function (uri/*=UNDEFINED*/)
    {
        var self = this;

        if (uri)
        {
            if (uri != '')
            {
                $('.logo-preview', self.$page).attr('src', uri + '?' + ((new Date()).getTime()));
            }
            $.uniform.update();
            return;
        }

    },
    deletePicture: function ()
    {
        var self = this;
        Core.Alert.question('¿Desea Eliminar esta Imagen?', function () {
            UProfile_Model.deletePictureProfile(function (res) {
                if (!res.isSuccess)
                {
                    Core.Notification.error(res.message);
                }
                else
                {
                    Core.Notification.success(res.message);
                    self.refreshPicture(res.data.uri);
                }

            });
        }, function ( ) {
        });
    }
};

var Modal_Picture = {
    init: function ()
    {
        var self = this;
        self.$modal = $('#modal_upload_img');
        self.$form_img = $("[name='upload_img_profile']", self.$modal);

        $('.action-upload-modal', self.$form_img).click(function () {
            self.actionUpload();
        });

        self.$modal.on("show.bs.modal", function () {
        });

        self.$modal.on("hidden.bs.modal", function () {
            self.formReset();
        });

        /*precess bar*/
        self.$progress_bar = $('.progress-bar', self.$form_img);
        self.$percent = $('.progress-bar span', self.$form_img);
        $('.view_pre_upload', self.$form_img).hide();

    },
    beforeProcessBar: function ()
    {
        var self = this;
        $('.view_pre_upload', self.$form_img).show();
        var percentVal = '0%';
        self.$progress_bar.width(percentVal);
        self.$percent.html(percentVal);
    },
    uploadProgressBar: function (e)
    {
        var self = this;
        if (e.lengthComputable) {
            var max = e.total;
            var current = e.loaded;
            var Percentage = (current * 100) / max;
            var percentVal = Percentage + '%';
            Modal_Picture.$progress_bar.width(percentVal);
            Modal_Picture.$percent.html(percentVal);

        }
    },
    close: function ()
    {
        var self = this;
        self.formReset();
        self.$modal.modal('hide');
    },
    formReset: function ()
    {
        var self = this;
        $('[name="profile"]', self.$form_img).val('');
        $('.view_pre_upload', self.$form_img).hide();
        $.uniform.update();
    },
    open: function ()
    {
        var self = this;
        self.$modal.modal('show');
    },
    data: function (uri/*=UNDEFINED*/)
    {
        var self = this;

        if (uri)
        {
            if (uri != '')
            {
                Picture_Control.refreshPicture(uri);
            }
            $.uniform.update();
            return;
        }

        var formData = new FormData($("[name='upload_img_profile']", self.$modal)[0]);

        uri = formData;
        return uri;
    },
    actionUpload: function ()
    {
        var self = this;

        $('[name="profile"]', self.$form_img).prop('readonly', true);

        var data = self.data();

        UProfile_Model.uploadLogo(data, function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                $('[name="profile"]', self.$form_img).prop('readonly', false);
            }
            else
            {
                Core.Notification.success(res.message);
                self.data(res.data[1].uri);
                self.close();
            }

        });
    }
};

var Profile_Controller = {
    init: function ()
    {
        var self = this;
        self.$tab = $('#tabDatos');
        self.$formDataPersonal = $("[name='frmProfile']", self.$tab);
        $('.action-save', self.$formDataPersonal).click(function () {
            if (UserProfile_Base.permissions.update)
            {
                self.actionSave();
            }
        });

        $('.action-edit', self.$formDataPersonal).click(function () {
            if (UserProfile_Base.permissions.update)
            {
                self.formType('edit');
            }
        });

        if (!UserProfile_Base.permissions.update)
        {
            $('.action-edit', self.$formDataPersonal).hide();
            $('.action-save', self.$formDataPersonal).hide();
        }


        $('.action-cancel', self.$formDataPersonal).click(function () {
            self.formType('view');
        });

        $('select[name="id_pais"]', self.$formDataPersonal).on('change', function () {
            self.loadProvincia();
        });

        $('select[name="id_provincia"]', self.$formDataPersonal).on('change', function () {
            self.loadCiudad();
        });

        self.reset();
        self.formLoading('load');
        self.dataLoad();
        self.formType('view');

    },
    initLoadComponents: function (fLoad)
    {
        var self = this;
        var oProfile = new eProfile();

        UProfile_Model.loadComponents(function (res)
        {
            if (res.data.eCatalogs['TIPO_IDENT'])
            {
                $('.el-fin-tipo-documeno', self.$formDataPersonal).show();

                var TIPO_IDENT = res.data.eCatalogs['TIPO_IDENT'];
                var html = '';
                if (TIPO_IDENT.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="tipo_documento"]', self.$formDataPersonal).attr('_value');
                    $.each(TIPO_IDENT, function (idx, tipo_identificacion)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (tipo_identificacion.value == oProfile.tipo_documento)
                            {
                                isView = tipo_identificacion.value;
                            }
                        }
                        else
                        {
                            if (tipo_identificacion.value == _value)
                            {
                                isView = tipo_identificacion.value;
                            }
                        }

                        html += '<option value="' + (tipo_identificacion.value) + '">' + (tipo_identificacion.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="tipo_documento"]', self.$formDataPersonal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="tipo_documento"]', self.$formDataPersonal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-tipo-documeno', self.$formDataPersonal).hide();
            }

            if (res.data.eCatalogs['GENDER'])
            {
                $('.el-fin-genero', self.$formDataPersonal).show();
                var GENDER = res.data.eCatalogs['GENDER'];
                var html = '';
                if (GENDER.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="gender"]', self.$formDataPersonal).attr('_value');
                    $.each(GENDER, function (idx, genero)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (genero.value == oProfile.gender)
                            {
                                isView = genero.value;
                            }
                        }
                        else
                        {
                            if (genero.value == _value)
                            {
                                isView = genero.value;
                            }
                        }
                        html += '<option value="' + (genero.value) + '">' + (genero.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="gender"]', self.$formDataPersonal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="gender"]', self.$formDataPersonal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-genero', self.$formDataPersonal).hide();
            }

            if (res.data.eCatalogs['ESTADO_CIVIL'])
            {
                $('.el-fin-estado-civil', self.$formDataPersonal).show();
                var ESTADO_CIVIL = res.data.eCatalogs['ESTADO_CIVIL'];
                var html = '';
                if (ESTADO_CIVIL.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="estado_civil"]', self.$formDataPersonal).attr('_value');
                    $.each(ESTADO_CIVIL, function (idx, estado_civil)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (estado_civil.value == oProfile.estado_civil)
                            {
                                isView = estado_civil.value;
                            }
                        }
                        else
                        {
                            if (estado_civil.value == _value)
                            {
                                isView = estado_civil.value;
                            }
                        }
                        html += '<option value="' + (estado_civil.value) + '">' + (estado_civil.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="estado_civil"]', self.$formDataPersonal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="estado_civil"]', self.$formDataPersonal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-estado-civil', self.$formDataPersonal).hide();
            }

            if (res.data.eCatalogs['TIPO_DE_SANGRE'])
            {
                $('.el-fin-tipo-sangre', self.$formDataPersonal).show();
                var TIPO_DE_SANGRE = res.data.eCatalogs['TIPO_DE_SANGRE'];
                var html = '';
                if (TIPO_DE_SANGRE.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="tipo_sangre"]', self.$formDataPersonal).attr('_value');
                    $.each(TIPO_DE_SANGRE, function (idx, tipo_sangre)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (tipo_sangre.value == oProfile.tipo_sangre)
                            {
                                isView = tipo_sangre.value;
                            }
                        }
                        else
                        {

                            if (tipo_sangre.value == _value)
                            {
                                isView = tipo_sangre.value;
                            }
                        }

                        html += '<option value="' + (tipo_sangre.value) + '">' + (tipo_sangre.text) + '</option>';
                    });
                }
                else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="tipo_sangre"]', self.$formDataPersonal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="tipo_sangre"]', self.$formDataPersonal).eq(0).select2("val"))
                        .select2('close');
                $.uniform.update();
                $('.el-fin-tipo-sangre', self.$formDataPersonal).hide();
            }
        });
        self.loadPais(fLoad);
    },
    loadPais: function (fLoad)
    {
        var self = this;

        var oProfile = new eProfile();

        $('.el-fin-pais', self.$formDataPersonal).show();
        UProfile_Model.loadPais(function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-pais'].length > 0)
            {
                var _value = $('select[name="id_pais"]', self.$formDataPersonal).attr('_value');
                $.each(res.data['cbo-pais'], function (idx, pais)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (pais.value == oProfile.id_pais)
                        {
                            isView = pais.value;
                        }
                    }
                    else
                    {
                        if (pais.value == _value)
                        {
                            isView = pais.value;
                        }
                    }
                    html += '<option value="' + (pais.value) + '">' + (pais.text) + '</option>';
                });
            }
            else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('[name="id_pais"]', self.$formDataPersonal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_pais"]', self.$formDataPersonal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-pais', self.$formDataPersonal).hide();
            self.loadProvincia(fLoad);
        });
    },
    loadProvincia: function (fLoad/*=undefined*/)
    {
        var self = this;

        var oProfile = new eProfile();

        var id_pais = $('select[name="id_pais"]', self.$formDataPersonal).select2('val');
        $('.el-fin-provincia', self.$formDataPersonal).show();
        UProfile_Model.loadProvincia(id_pais, function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-provincia'].length > 0)
            {
                var _value = $('select[name="id_provincia"]', self.$formDataPersonal).attr('_value');
                $.each(res.data['cbo-provincia'], function (idx, provincia)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (provincia.value == oProfile.id_provincia)
                        {
                            isView = provincia.value;
                        }
                    }
                    else
                    {
                        if (provincia.value == _value)
                        {
                            isView = provincia.value;
                        }
                    }
                    html += '<option value="' + (provincia.value) + '">' + (provincia.text) + '</option>';
                });
            }
            else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('[name="id_provincia"]', self.$formDataPersonal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_provincia"]', self.$formDataPersonal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-provincia', self.$formDataPersonal).hide();
            self.loadCiudad(fLoad);
        });
    },
    loadCiudad: function (fLoad/*=undefined*/)
    {
        var self = this;

        var oProfile = new eProfile();

        var id_provincia = $('select[name="id_provincia"]', self.$formDataPersonal).select2('val');
        $('.el-fin-ciudad', self.$formDataPersonal).show();
        UProfile_Model.loadCiudad(id_provincia, function (res) {
            var html = '';
            if (res.data['cbo-ciudad'].length > 0)
            {
                var isView = 0;
                var _value = $('select[name="id_ciudad"]', self.$formDataPersonal).attr('_value');
                $.each(res.data['cbo-ciudad'], function (idx, ciudad)
                {
                    if (typeof _value == 'undefined')
                            //if (_value == 0)
                            {
                                if (ciudad.value == oProfile.id_ciudad)
                                {
                                    isView = ciudad.value;
                                }
                            }
                    else
                    {
                        if (ciudad.value == _value)
                        {
                            isView = ciudad.value;
                        }
                    }
                    html += '<option value="' + (ciudad.value) + '">' + (ciudad.text) + '</option>';
                });
            }
            else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('select[name="id_ciudad"]', self.$formDataPersonal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_ciudad"]', self.$formDataPersonal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-ciudad', self.$formDataPersonal).hide();
            if (fLoad)
            {
                fLoad();
            }
        });
    },
    reset: function ()
    {
        var self = this;
        self.dataDefault();
        self.errorClear();
        self.formReadOnly(false);
        self.formLoading('none');
    },
    //====================
    // DATA
    //====================
    dataDefault: function ()
    {
        var self = this;

        self.data('set', UserProfile_Base.profile_form_default);
    },
    dataLoad: function ()
    {
        var self = this;
        UProfile_Model.loadProfile(function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                return;
            }

            self.data('set', res.forms.profile);

            var fLoad = function ()
            {
                self.formLoading('none');
            };
            self.initLoadComponents(function () {
                fLoad();
            });
        });
    }
    ,
    //data: function (profile_data/*=UNDEFINED*/)
    data: function (type /* set, get*/, data/*=UNDEFINED*/)
    {
        var self = this;

        if (type == 'set')
        {
            var oProfile = new eProfile();
            oProfile.init(data);

            $('[name="name"]', self.$formDataPersonal).val(oProfile.name);
            $('[name="surname"]', self.$formDataPersonal).val(oProfile.surname);
            $('[name="tipo_documento"]', self.$formDataPersonal).attr('_value', oProfile.tipo_documento);
            $('[name="document"]', self.$formDataPersonal).val(oProfile.document);
            $('[name="birthday"]', self.$formDataPersonal).val(oProfile.birthday);
            $('[name="gender"]', self.$formDataPersonal).attr('_value', oProfile.gender);
            $('[name="address"]', self.$formDataPersonal).val(oProfile.address);
            $('[name="phone_cell"]', self.$formDataPersonal).val(oProfile.phone_cell);
            $('[name="email"]', self.$formDataPersonal).val(oProfile.email);
            $('[name="estado_civil"]', self.$formDataPersonal).attr('_value', oProfile.estado_civil);
            $('[name="tipo_sangre"]', self.$formDataPersonal).attr('_value', oProfile.tipo_sangre);
            $('[name="id_pais"]', self.$formDataPersonal).attr('_value', oProfile.id_pais);
            $('[name="id_provincia"]', self.$formDataPersonal).attr('_value', oProfile.id_provincia);
            $('[name="id_ciudad"]', self.$formDataPersonal).attr('_value', oProfile.id_ciudad);
            $('#name_h6', self.$formDataPersonal).html(oProfile.name + ' ' + oProfile.surname + '<small>' + oProfile.name_profile + '</small>');
            
            $.uniform.update();
            return;
        }
        else if (type == 'get')
        {
            data = {
                name: $('[name="name"]', self.$tab).val(),
                surname: $('[name="surname"]', self.$tab).val(),
                tipo_documento: $('[name="tipo_documento"]', self.$tab).select2('val'),
                document: $('[name="document"]', self.$tab).val(),
                birthday: $('[name="birthday"]', self.$tab).val(),
                gender: $('[name="gender"]', self.$tab).select2('val'),
                address: $('[name="address"]', self.$tab).val(),
                phone_cell: $('[name="phone_cell"]', self.$tab).val(),
                email: $('[name="email"]', self.$tab).val(),
                estado_civil: $('[name="estado_civil"]', self.$tab).select2('val'),
                tipo_sangre: $('[name="tipo_sangre"]', self.$tab).select2('val'),
                id_ciudad: $('[name="id_ciudad"]', self.$tab).select2('val')
            };
            
            return data;
        }
        return;
    },
    //====================
    // ERRORS
    //====================
    errorClear: function ()
    {
        this.errorData(UserProfile_Base.profile_form_default);
    }
    ,
    errorData: function (data/*=UNDEFINED*/)
    {
        var self = this;
        var $form_group = $('.form-group', self.$formDataPersonal);
        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();
        for (var field_name in data)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$formDataPersonal).closest('.form-group');
            if (!$.isEmptyObject(data[field_name].error))
            {
                $form_group.addClass('has-error');
                $('.label-danger', $form_group).html(data[field_name].error).show();
            }
        }
    }
    ,
    //====================
    // FORM
    //====================
    formLoading: function (key)
    {
        var self = this;
        switch (key)
        {
            case 'save':
                $('.loading span', self.$formDataPersonal).html('Guardando...');
                $('.loading', self.$formDataPersonal).show();
                $('.action-save, .action-edit, .action-cancel', self.$formDataPersonal).addClass('disabled');
                break;
            case 'load':
                $('.loading span', self.$formDataPersonal).html('Cargando...');
                $('.loading', self.$formDataPersonal).show();
                $('.action-save, .action-edit, .action-cancel', self.$formDataPersonal).addClass('disabled');
                break;
            case 'none':
                $('.loading span', self.$formDataPersonal).html('');
                $('.loading', self.$formDataPersonal).hide();
                $('.action-save, .action-edit, .action-cancel', self.$formDataPersonal).removeClass('disabled');
                break;
        }
    },
    formType: function (type /* edit, view */)
    {
        var self = this;
        if (type == 'edit')
        {
            $('.action-save', self.$formDataPersonal).show();
            $('.action-edit', self.$formDataPersonal).hide();
            $('.action-cancel', self.$formDataPersonal).show();
            self.formReadOnly(false);
        }
        else if (type == 'view')
        {
            $('.action-save', self.$formDataPersonal).hide();
            $('.action-cancel', self.$formDataPersonal).hide();
            if (UserProfile_Base.permissions.update)
            {
                $('.action-edit', self.$formDataPersonal).show();
            }
            else
            {
                $('.action-edit', self.$formDataPersonal).hide();
            }
            self.formReadOnly(true);
        }
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;
        
        Core.Form.readOnly(self.$formDataPersonal, isFormReadOnly);
        $('[name="tipo_documento"]', self.$formDataPersonal).select2('enable', false);
        $('[name="document"]', self.$formDataPersonal).prop('readonly', true);
        $('[name="name"]', self.$formDataPersonal).prop('readonly', true);
        $('[name="surname"]', self.$formDataPersonal).prop('readonly', true);

        $.uniform.update();
    },
    // ======================================================================
    // ======================================================================
    actionSave: function ()
    {
        var self = this;
        $.uniform.update();
        self.formLoading('save');
        self.formReadOnly(true);
        var data = self.data('get');
        UProfile_Model.saveProfile(data, function (data) {
            if (data.isSuccess)
            {
                Core.Notification.success(data.message);
                self.formLoading('none');
                self.formType('view');
            }
            else
            {
                Core.Notification.error(data.message);
                self.formLoading('none');
                self.errorData(data.forms.profile);
                self.formReadOnly(false);
            }
        });
    }
};

var User_Controller = {
    init: function ()
    {
        var self = this;
        self.$tab = $('#tabCuenta');

        self.$formDataUser = $("[name='frmUser']", self.$tab);
        $('.action-save', self.$formDataUser).click(function () {
            if (UserProfile_Base.permissions.update)
            {
                self.actionSave();
            }
        });

        $('.action-edit', self.$formDataUser).click(function () {
            if (UserProfile_Base.permissions.update)
            {
                self.formType('edit');
            }
        });

        if (!UserProfile_Base.permissions.update)
        {
            $('.action-edit', self.$formDataUser).hide();
            $('.action-save', self.$formDataUser).hide();
        }


        $('.action-cancel', self.$formDataUser).click(function () {
            self.reset();
            self.formType('view');
        });

        self.reset();
        self.formType('view');
    },
    reset: function ()
    {
        var self = this;
        self.dataDefault();
        self.errorClear();
        self.formReadOnly(false);
        self.formLoading('none');
    },
    formType: function (type /* edit, view */)
    {
        var self = this;
        if (type == 'edit')
        {
            $('.action-save', self.$formDataUser).show();
            $('.action-edit', self.$formDataUser).hide();
            $('.action-cancel', self.$formDataUser).show();
            self.formReadOnly(false);
        }
        else if (type == 'view')
        {
            $('.action-save', self.$formDataUser).hide();
            $('.action-cancel', self.$formDataUser).hide();
            if (UserProfile_Base.permissions.update)
            {
                $('.action-edit', self.$formDataUser).show();
            }
            else
            {
                $('.action-edit', self.$formDataUser).hide();
            }
            self.formReadOnly(true);
        }
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;
        $('[name="username"]', self.$formDataUser).prop('readonly', true);
        
        Core.Form.readOnly(self.$formDataUser, isFormReadOnly);
        $('[name="username"]', self.$formDataUser).prop('readonly', true);
        $.uniform.update();
    },
    //====================
    // ERRORS
    //====================
    errorClear: function ()
    {
        this.errorData(UserProfile_Base.user_form_default);
    },
    errorData: function (data/*=UNDEFINED*/)
    {
        var self = this;
        var $form_group = $('.form-group', self.$formDataUser);
        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();
        for (var field_name in data)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$formDataUser).closest('.form-group');
            if (!$.isEmptyObject(data[field_name].error))
            {
                $form_group.addClass('has-error');
                $('.label-danger', $form_group).html(data[field_name].error).show();
            }
        }
    },
    //====================
    // FORM
    //====================
    formLoading: function (key)
    {
        var self = this;
        switch (key)
        {
            case 'save':
                $('.loading span', self.$formDataUser).html('Guardando...');
                $('.loading', self.$formDataUser).show();
                $('.action-save, .action-edit, .action-cancel', self.$formDataUser).addClass('disabled');
                break;
            case 'load':
                $('.loading span', self.$formDataUser).html('Cargando...');
                $('.loading', self.$formDataUser).show();
                $('.action-save, .action-edit, .action-cancel', self.$formDataUser).addClass('disabled');
                break;
            case 'none':
                $('.loading span', self.$formDataUser).html('');
                $('.loading', self.$formDataUser).hide();
                $('.action-save, .action-edit, .action-cancel', self.$formDataUser).removeClass('disabled');
                break;
        }
    },
    //====================
    // DATA
    //====================
    dataDefault: function ()
    {
        this.data(UserProfile_Base.user_form_default);
    },
    data: function (data/*=UNDEFINED*/)
    {
        var self = this;

        if (data)
        {
            var username = data.username.value;

            $('[name="username"]', self.$formDataUser).val(username);

            $.uniform.update();
            return;
        }
        data = {
            username: $('[name="username"]', self.$tab).val(),
            password_current: $('[name="password_current"]', self.$tab).val(),
            password_new: $('[name="password_new"]', self.$tab).val(),
            password_new_repeat: $('[name="password_new_repeat"]', self.$tab).val()
        };
        return data;
    },
    //====================
    // ACTIONS
    //====================
    actionSave: function ()
    {
        var self = this;
        var data = self.data();
        self.errorClear();
        self.formLoading('save');
        PUser_Model.saveUser(data, function (res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
                self.data(res.forms.user);
                self.formType('view');
            }
            else
            {
                Core.Notification.error(res.message);
                self.errorData(res.forms.user);
            }

            self.formLoading('none');
        });
    }
};

Core.addInit(function () {
    Administration_Tab_Controller.init();
});