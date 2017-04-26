$.fn.modal.Constructor.prototype.enforceFocus = function () {
};

var Customer_Crossfit_Controller = {
    init: function ()
    {
        var self = this;
        self.$table = $('.datatable-media table');

        //===== Fancy box (lightbox plugin) =====//
        $(".lightbox", self.$table).fancybox({
            padding: 1
        });

        if (!Customer_Crossfit_Base.permissions.create) {
            $('.panel-toolbar').hide();
        }

        self.$table.dataTable({
            bJQueryUI: false,
            bAutoWidth: false,
            bProcessing: false,
            bServerSide: true,
            bSort: false,
            sPaginationType: "full_numbers",
            sDom: '<"datatable-header"Tfl><"datatable-scroll"tr><"datatable-footer"ip>',
            sAjaxSource: Core.site_url(Customer_Crossfit_Base.linkx + "/process/list-customer-crossfit"),
            fnServerParams: function (aoData)
            {
                Core.Loading.wait(true, $('tbody', $(this)));
            },
            aoColumnDefs: [
                {sClass: "center", "aTargets": [0]},
                {sClass: "center", "aTargets": [1]},
                {sClass: "center", "aTargets": [2]},
                {sClass: "left", "aTargets": [3]},
                {sClass: "left file-info", "aTargets": [4]},
                {sClass: "center", "aTargets": [5]},
                {
                    aTargets: [0], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-imagen" _path="' + (data.path) + '" _title="' + (data.title) + '" />';
                    }
                },
                {
                    aTargets: [4], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-detalle" _birthday="' + (data.birthday) + '" _registration="' + (data.registration_date) + '" _location="' + (data.location) + '"/>';
                    }
                },
                {
                    aTargets: [5], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-option" _person="' + (data.person) + '" _id="' + (data.id) + '"/>';
                    }
                }

            ],
            fnDrawCallback: function ()
            {
                Core.Loading.wait(false, $('tbody', $(this)));
                // aTargets: [0]
                $('.dt-col-imagen').each(function () {
                    var path = $(this).attr('_path');

                    var title = $(this).attr('_title');

                    var html = Customer_Crossfit_View.dtImagenTable(path, title);

                    var $html = $(html);

                    $(this).after($html);
                });

                // aTargets: [4]
                $('.dt-col-detalle').each(function () {
                    var birthday = $(this).attr('_birthday');

                    var registration = $(this).attr('_registration');

                    var location = $(this).attr('_location');

                    var html = Customer_Crossfit_View.dtDetalleTable(birthday, registration, location);

                    var $html = $(html);

                    $(this).after($html);
                });

                // aTargets: [5]
                $('.dt-col-option').each(function () {
                    var person = $(this).attr('_person');
                    var id = $(this).attr('_id');

                    var html = Customer_Crossfit_View.dtOptionsTable();
                    var $html = $(html);

                    $('.dt-action-view', $html).click(function () {
                        Modal_CustomerCrossfit.open(id, true);
                    });
                    if (Customer_Crossfit_Base.permissions.update)
                    {
                        $('.dt-action-edit', $html).click(function () {
                            Modal_CustomerCrossfit.open(id);
                        });
                    }
                    if (Customer_Crossfit_Base.permissions.access_imc)
                    {
                        $('.dt-action-biotipo', $html).click(function () {
                            Modal_ControlIMC.open(id, person);
                        });
                    }

                    $(this).after($html);
                });
                $('.tip').tooltip();
            }

        });
        if (Customer_Crossfit_Base.permissions.create)
        {
            $('.action-popup-new').click(function () {
                Modal_CustomerCrossfit.open();
            });
        }


        $('[action="action-refresh"]').click(function () {
            self.refresDataTable(false);
        });

        Modal_CustomerCrossfit.init();

        Modal_ControlIMC.init();
    },
    refresDataTable: function (isDraw /*=true*/)
    {
        var self = this;

        setInterval(self.$table.dataTable().fnDraw(isDraw), 3000);
    }

};

var Modal_CustomerCrossfit = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal');

        $('.el-finding-document', self.$modal).hide(); /*ocultar el buscando*/


        $('button.action-save', self.$modal).click(function () {
            if (Customer_Crossfit_Base.permissions.update || Customer_Crossfit_Base.permissions.create)
            {
                self.actionSave();
            }
        });

        $('button.action-edit', self.$modal).click(function () {
            if (Customer_Crossfit_Base.permissions.update)
            {
                self.formReadOnly(false);
                self.formType('edit');
            }
        });


        if (!Customer_Crossfit_Base.permissions.update)
        {
            $('button.action-edit', self.$modal).hide();
            $('button.action-save', self.$modal).hide();
        }

        $('select[name="id_pais"]', self.$modal).on('change', function () {
            self.loadProvincia();
        });

        $('select[name="id_provincia"]', self.$modal).on('change', function () {
            self.loadCiudad();
        });

        self.$modal.on("show.bs.modal", function () {
            //alert('show form');
        });

        self.$modal.on("hidden.bs.modal", function () {
            self.formReset();
        });

        $('input[name="document"]', self.$modal).focusout(function ()
        {

            if (!$(this).prop('readonly'))
            {
                var document = $(this).val();
                $('[name="username"]', self.$modal).val(document);
                /*alert(document);*/
                if (document != '' || document != null)
                {
                    self.loadByDocument(document);
                }
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
    loadByDocument: function (document)
    {
        var self = this;

        $('.el-finding-document', self.$modal).show();

        self.formReadOnly(true);
        self.formLoading('load');
        self.smgKey('load');
        self.errorClear();
        CustomerCrossfit_Model.loadPersonByDocument(document, function (oRes)
        {
            $('.el-finding-document', self.$modal).hide();

            if (!oRes.isSuccess)
            {
                Core.Notification.error(oRes.message);
                return;
            }
            self.data(oRes.forms.person, true);

            var fLoad = function ()
            {
                self.formReadOnly(false);
                self.formLoading('none');
                if ($('[name="id_user"]', self.$modal) == 0)
                {
                    self.smgKey('new');
                } else
                {
                    self.smgKey('edit');
                }
            };

            self.loadProvincia(function () {
                fLoad();
            });
        });



    },
    close: function ()
    {
        var self = this;

        self.formReset();
        self.$modal.modal('hide');
    },
    // =======================================================================
    formReset: function ()
    {
        var self = this;
        Customer_Crossfit_Base.data_company_branch = [];
        self.dataDefault();
        self.errorClear();
        self.formReadOnly(false);
        self.formLoading('none');

    },
    dataDefault: function ()
    {
        this.data(Customer_Crossfit_Base.customer_crossfit_form_default);
    },
    errorClear: function ()
    {
        this.formError(Customer_Crossfit_Base.customer_crossfit_form_default);
    },
    smgKey: function (type /* new, edit, view, load */)
    {
        var self = this;
        if (type == 'new')
        {
            $('.msg-clave span', self.$modal).show();
            $('.msg-clave span', self.$modal).html('Usuario y contraseña es el número de documento ingresado');
        } else if (type == 'edit')
        {
            $('.msg-clave span', self.$modal).show();
            $('.msg-clave span', self.$modal).html('Si no ha modificado la clave en primera instancia es el número de documento');
        } else if (type == 'view')
        {
            $('.msg-clave span', self.$modal).hide();
            $('.msg-clave span', self.$modal).html('');
        } else if (type == 'load')
        {
            $('.msg-clave span', self.$modal).show();
            $('.msg-clave span', self.$modal).html('Si no ha modificado la clave en primera instancia es el número de documento');
        }
    },
    formType: function (type /* new, edit, view */)
    {
        var self = this;

        self.smgKey(type);

        if (type == 'new')
        {
            $('.modal-title span', self.$modal).html('Nuevo');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();
            $('#divNumRegistro', self.$modal).hide();

            self.formReadOnly(false);
        } else if (type == 'edit')
        {
            $('.modal-title span', self.$modal).html('Editar');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();
            $('#divNumRegistro', self.$modal).show();

            self.formReadOnly(false);

        } else if (type == 'view')
        {
            $('.modal-title span', self.$modal).html('Ver');

            $('.action-save', self.$modal).hide();
            $('#divNumRegistro', self.$modal).show();
            if (Customer_Crossfit_Base.permissions.update)
            {
                $('.action-edit', self.$modal).show();
            } else
            {
                $('.action-edit', self.$modal).hide();
            }

            self.formReadOnly(true);
        }
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;

        var self = this;
        $('[name="name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="surname"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="document"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="birthday"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="address"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="phone_cell"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="email"]', self.$modal).prop('readonly', isFormReadOnly);

        $('[name="tipo_documento"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="gender"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="estado_civil"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="tipo_sangre"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_pais"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_provincia"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_ciudad"]', self.$modal).select2('enable', !isFormReadOnly);

        $('[name="id_profile"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="username"]', self.$modal).prop('readonly', true);
        //$('[name="password_new"]', self.$modal).prop('readonly', isFormReadOnly);
        //$('[name="password_new_repeat"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="isActive"]', self.$modal).prop('disabled', isFormReadOnly);
        $('[name="id_company_branchs"]', self.$modal).select2('readonly', isFormReadOnly);

        if ($('[name="id_customer"]', self.$modal).val() != 0)
        {
            $('[name="document"]', self.$modal).prop('readonly', true);
            $('[name="tipo_documento"]', self.$modal).select2('enable', false);
        }


        $.uniform.update();
    },
    formLoading: function (key)
    {
        var self = this;

        switch (key)
        {
            case 'save':
                $('.loading span', self.$modal).html('Guardando...');
                $('.loading', self.$modal).show();

                $('.action-save, .action-edit, .action-close', self.$modal).addClass('disabled');
                break;
            case 'load':
                $('.loading span', self.$modal).html('Cargando...');
                $('.loading', self.$modal).show();
                $('.action-save, .action-edit, .action-close', self.$modal).addClass('disabled');
                break;
            case 'none':
                $('.loading span', self.$modal).html('');
                $('.loading', self.$modal).hide();
                $('.action-save, .action-edit, .action-close', self.$modal).removeClass('disabled');
                break;
        }
    },
    formError: function (data)
    {
        var self = this;

        var $form_group = $('.form-group', self.$modal);

        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();

        for (var field_name in data)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$modal).closest('.form-group');
            if (!$.isEmptyObject(data[field_name].error))
            {
                $form_group.addClass('has-error');
                $('.label-danger', $form_group).html(data[field_name].error).show();
            }
        }
    },
    open: function (id_customer/*=0*/, isView/*=false*/)
    {
        var self = this;

        id_customer = typeof id_customer == 'undefined' ? 0 : id_customer;
        isView = typeof isView == 'boolean' ? isView : false;

        self.formReset();
        //self.$modal.modal('show');
        self.formLoading('load');
        self.formReadOnly(true);

        if (id_customer == 0)
        {
            self.formType('new');
            self.formReadOnly(true);
            var fLoad = function ()
            {
                self.formLoading('none');
                self.formReadOnly(false);
            };
        } else
        {
            self.dataLoad(id_customer);
            if (isView)
            {
                self.formType('view');
            } else
            {
                self.formType('edit');
            }
            self.formReadOnly(true);
            var fLoad = function ()
            {
                self.formLoading('none');
                if (!isView)
                {
                    self.formReadOnly(false);
                }
            };
        }

        self.$modal
                .off('shown.bs.modal')
                .on('shown.bs.modal', function () {
                    self.initLoadComponents(function () {
                        fLoad();
                    });
                })
                .modal('show');
    },
    dataLoad: function (id_customer)
    {
        var self = this;
        CustomerCrossfit_Model.loadCustomer(id_customer, function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                self.close();
                return;
            }
            self.data(res.forms.customer);
        }, function () {
            self.close();
        });
    },
    data: function (data/*=UNDEFINED*/, Tdocument/*=false*/)
    {
        var self = this;

        if (data)
        {
            var id_form = data.id_form.value;
            var id_person = data.id_person.value;
            var name = data.name.value;
            var surname = data.surname.value;
            var tipo_documento = data.tipo_documento.value;
            var document = data.document.value;
            var birthday = data.birthday.value;
            var gender = data.gender.value;
            var address = data.address.value;
            var phone_cell = data.phone_cell.value;
            var email = data.email.value;
            var estado_civil = data.estado_civil.value;
            var tipo_sangre = data.tipo_sangre.value;
            var id_pais = data.id_pais.value;
            var id_provincia = data.id_provincia.value;
            var id_ciudad = data.id_ciudad.value;

            var id_profile = data.id_profile.value;
            var id_user = data.id_user.value;
            var id_customer = data.id_customer.value;
            var registration_date = data.registration_date.value;
            var code = data.code.value;
            var username = data.username.value;
            //var password_new = data.password_new.value;
            //var password_new_repeat = data.password_new_repeat.value;
            var isActive = (data.isActive.value == 0) ? false : true;

            var id_company_branchs = (data.id_company_branchs.value == null) ? [] : data.id_company_branchs.value;

            var path_picture = data.path_picture.value;


            $('[name="id_form"]', self.$modal).val(id_form);
            $('[name="id_person"]', self.$modal).val(id_person);
            $('[name="name"]', self.$modal).val(name);
            $('[name="surname"]', self.$modal).val(surname);
            if (Tdocument)
            {
                $('[name="tipo_documento"]', self.$modal).select2('val', tipo_documento);
                $('[name="gender"]', self.$modal).select2('val', gender);
                $('[name="estado_civil"]', self.$modal).select2('val', estado_civil);
                $('[name="tipo_sangre"]', self.$modal).select2('val', tipo_sangre);
                $('[name="id_pais"]', self.$modal).select2('val', id_pais);
            } else
            {
                $('[name="document"]', self.$modal).val(document);
                $('[name="tipo_documento"]', self.$modal).attr('_value', tipo_documento);
                $('[name="gender"]', self.$modal).attr('_value', gender);
                $('[name="estado_civil"]', self.$modal).attr('_value', estado_civil);
                $('[name="tipo_sangre"]', self.$modal).attr('_value', tipo_sangre);
                $('[name="id_pais"]', self.$modal).attr('_value', id_pais);
            }


            $('[name="birthday"]', self.$modal).val(birthday);
            $('[name="address"]', self.$modal).val(address);
            $('[name="phone_cell"]', self.$modal).val(phone_cell);
            $('[name="email"]', self.$modal).val(email);
            $('[name="id_provincia"]', self.$modal).attr('_value', id_provincia);
            $('[name="id_ciudad"]', self.$modal).attr('_value', id_ciudad);
            $('[name="id_user"]', self.$modal).val(id_user);

            $('[name="username"]', self.$modal).val(($.isEmptyObject(username)) ? $('[name="document"]', self.$modal).val() : username);
            //$('[name="password_new"]', self.$modal).val(password_new);
            //$('[name="password_new_repeat"]', self.$modal).val(password_new_repeat);
            $('[name="id_profile"]', self.$modal).attr('_value', id_profile);
            $('[name="isActive"]', self.$modal).prop('checked', isActive);
            $('[name="id_company_branchs"]', self.$modal).attr('_value', id_company_branchs);
            Customer_Crossfit_Base.data_company_branch = id_company_branchs;

            $('[name="id_customer"]', self.$modal).val(id_customer);
            $('[name="registration_date"]', self.$modal).val(registration_date);
            $('[name="code"]', self.$modal).val(code);
            $('#code_span', self.$modal).html(code);

            self.refreshPicture(path_picture);

            $.uniform.update();
            return;
        }
        data = {
            id_form: $('[name="id_form"]', self.$modal).val(),
            id_person: $('[name="id_person"]', self.$modal).val(),
            name: $('[name="name"]', self.$modal).val(),
            surname: $('[name="surname"]', self.$modal).val(),
            tipo_documento: $('[name="tipo_documento"]', self.$modal).select2('val'),
            document: $('[name="document"]', self.$modal).val(),
            birthday: $('[name="birthday"]', self.$modal).val(),
            gender: $('[name="gender"]', self.$modal).select2('val'),
            address: $('[name="address"]', self.$modal).val(),
            phone_cell: $('[name="phone_cell"]', self.$modal).val(),
            email: $('[name="email"]', self.$modal).val(),
            estado_civil: $('[name="estado_civil"]', self.$modal).select2('val'),
            tipo_sangre: $('[name="tipo_sangre"]', self.$modal).select2('val'),
            id_ciudad: $('[name="id_ciudad"]', self.$modal).select2('val'),
            id_user: $('[name="id_user"]', self.$modal).val(),
            username: $('[name="username"]', self.$modal).val(),
            //password_new: $('[name="password_new"]', self.$modal).val(),
            //password_new_repeat: $('[name="password_new_repeat"]', self.$modal).val(),
            id_profile: $('[name="id_profile"]', self.$modal).select2('val'),
            id_company_branchs: $('[name="id_company_branchs"]', self.$modal).select2('val'),
            isActive: $('[name="isActive"]', self.$modal).prop('checked') ? 1 : 0,
            id_customer: $('[name="id_customer"]', self.$modal).val(),
            registration_date: $('[name="registration_date"]', self.$modal).val(),
            code: $('[name="code"]', self.$modal).val()

        };
        return data;
    },
    initLoadComponents: function (fLoad)
    {
        var self = this;
        CustomerCrossfit_Model.loadComponents(function (res)
        {
            if (res.data.eCatalogs['TIPO_IDENT'])
            {
                $('.el-fin-tipo-documeno', self.$modal).show();

                var TIPO_IDENT = res.data.eCatalogs['TIPO_IDENT'];
                var html = '';
                if (TIPO_IDENT.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="tipo_documento"]', self.$modal).attr('_value');
                    $.each(TIPO_IDENT, function (idx, tipo_identificacion)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (tipo_identificacion.value == Customer_Crossfit_Base.customer_crossfit_form_default.tipo_documento.value)
                            {
                                isView = tipo_identificacion.value;
                            }
                        } else
                        {
                            if (tipo_identificacion.value == _value)
                            {
                                isView = tipo_identificacion.value;
                            }
                        }

                        html += '<option value="' + (tipo_identificacion.value) + '">' + (tipo_identificacion.text) + '</option>';
                    });
                } else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="tipo_documento"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="tipo_documento"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-tipo-documeno', self.$modal).hide();
            }

            if (res.data.eCatalogs['GENDER'])
            {
                $('.el-fin-genero', self.$modal).show();
                var GENDER = res.data.eCatalogs['GENDER'];
                var html = '';
                if (GENDER.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="gender"]', self.$modal).attr('_value');
                    $.each(GENDER, function (idx, genero)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (genero.value == Customer_Crossfit_Base.customer_crossfit_form_default.gender.value)
                            {
                                isView = genero.value;
                            }
                        } else
                        {
                            if (genero.value == _value)
                            {
                                isView = genero.value;
                            }
                        }
                        html += '<option value="' + (genero.value) + '">' + (genero.text) + '</option>';
                    });
                } else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="gender"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="gender"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-genero', self.$modal).hide();
            }

            if (res.data.eCatalogs['ESTADO_CIVIL'])
            {
                $('.el-fin-estado-civil', self.$modal).show();
                var ESTADO_CIVIL = res.data.eCatalogs['ESTADO_CIVIL'];
                var html = '';
                if (ESTADO_CIVIL.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="estado_civil"]', self.$modal).attr('_value');
                    $.each(ESTADO_CIVIL, function (idx, estado_civil)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (estado_civil.value == Customer_Crossfit_Base.customer_crossfit_form_default.estado_civil.value)
                            {
                                isView = estado_civil.value;
                            }
                        } else
                        {
                            if (estado_civil.value == _value)
                            {
                                isView = estado_civil.value;
                            }
                        }
                        html += '<option value="' + (estado_civil.value) + '">' + (estado_civil.text) + '</option>';
                    });
                } else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="estado_civil"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="estado_civil"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-estado-civil', self.$modal).hide();
            }

            if (res.data.eCatalogs['TIPO_DE_SANGRE'])
            {
                $('.el-fin-tipo-sangre', self.$modal).show();
                var TIPO_DE_SANGRE = res.data.eCatalogs['TIPO_DE_SANGRE'];
                var html = '';
                if (TIPO_DE_SANGRE.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="tipo_sangre"]', self.$modal).attr('_value');
                    $.each(TIPO_DE_SANGRE, function (idx, tipo_sangre)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (tipo_sangre.value == Customer_Crossfit_Base.customer_crossfit_form_default.tipo_sangre.value)
                            {
                                isView = tipo_sangre.value;
                            }
                        } else
                        {

                            if (tipo_sangre.value == _value)
                            {
                                isView = tipo_sangre.value;
                            }
                        }

                        html += '<option value="' + (tipo_sangre.value) + '">' + (tipo_sangre.text) + '</option>';
                    });
                } else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="tipo_sangre"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="tipo_sangre"]', self.$modal).eq(0).select2("val"))
                        .select2('close');
                $.uniform.update();
                $('.el-fin-tipo-sangre', self.$modal).hide();
            }

            if (res.data.eProfiles)
            {

                $('.el-fin-perfil', self.$modal).show();

                var ePERFILES = res.data.eProfiles;
                var html = '';
                if (ePERFILES.length > 0)
                {
                    var isView = 0;
                    var _value = $('select[name="id_profile"]', self.$modal).attr('_value');
                    $.each(ePERFILES, function (idx, profile)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (profile.value == Customer_Crossfit_Base.customer_crossfit_form_default.id_profile.value)
                            {
                                isView = profile.value;
                            }
                        } else
                        {
                            if (profile.value == _value)
                            {
                                isView = profile.value;
                            }
                        }

                        html += '<option value="' + (profile.value) + '">' + (profile.text) + '</option>';
                    });
                } else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="id_profile"]', self.$modal)
                        .html(html)
                        .select2('val', isView != 0 ? isView : $('[name="id_profile"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-perfil', self.$modal).hide();
            }

            if (res.data.eCompanyBranches)
            {

                $('.el-fin-company-branchs', self.$modal).show();

                var eCOMPANY_BRANCHS = res.data.eCompanyBranches;
                var html = '';
                if (eCOMPANY_BRANCHS.length > 0)
                {
                    var isView = 0;
                    var _value = Customer_Crossfit_Base.data_company_branch;
                    //var _value = $('select[name="id_company_branchs"]', self.$modal).attr('_value');
                    $.each(eCOMPANY_BRANCHS, function (idx, company_branch)
                    {
                        if (typeof _value == 'undefined')
                        {
                            if (company_branch.value == Customer_Crossfit_Base.customer_crossfit_form_default.id_company_branchs)
                            {
                                isView = company_branch.value;
                            }
                        } else
                        {
                            if (company_branch.value == _value)
                            {
                                isView = company_branch.value;
                            }
                        }

                        html += '<option value="' + (company_branch.value) + '">' + (company_branch.text) + '</option>';
                    });
                } else
                {
                    html += '<option value="">&lt;VACIO&gt;</option>';
                }
                $('select[name="id_company_branchs"]', self.$modal)
                        .html(html)
                        //.select2('val', isView != 0 ? isView : $('[name="id_company_branchs"]', self.$modal).eq(0).select2("val"))
                        .select2('val', isView != 0 ? isView : $('[name="id_company_branchs"]', self.$modal).eq(0).select2("val"))
                        .select2('close');

                $.uniform.update();
                $('.el-fin-company-branchs', self.$modal).hide();
            }

        });
        self.loadPais(fLoad);
    },
    loadPais: function (fLoad)
    {
        var self = this;
        $('.el-fin-pais', self.$modal).show();
        CustomerCrossfit_Model.loadPais(function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-pais'].length > 0)
            {
                var _value = $('select[name="id_pais"]', self.$modal).attr('_value');
                $.each(res.data['cbo-pais'], function (idx, pais)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (pais.value == Customer_Crossfit_Base.customer_crossfit_form_default.id_pais.value)
                        {
                            isView = pais.value;
                        }
                    } else
                    {
                        if (pais.value == _value)
                        {
                            isView = pais.value;
                        }
                    }
                    html += '<option value="' + (pais.value) + '">' + (pais.text) + '</option>';
                });
            } else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('[name="id_pais"]', self.$modal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_pais"]', self.$modal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-pais', self.$modal).hide();
            self.loadProvincia(fLoad);
        });
    },
    loadProvincia: function (fLoad/*=undefined*/)
    {
        var self = this;
        var id_pais = $('select[name="id_pais"]', self.$modal).select2('val');
        $('.el-fin-provincia', self.$modal).show();
        CustomerCrossfit_Model.loadProvincia(id_pais, function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-provincia'].length > 0)
            {
                var _value = $('select[name="id_provincia"]', self.$modal).attr('_value');
                $.each(res.data['cbo-provincia'], function (idx, provincia)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (provincia.value == Customer_Crossfit_Base.customer_crossfit_form_default.id_provincia.value)
                        {
                            isView = provincia.value;
                        }
                    } else
                    {
                        if (provincia.value == _value)
                        {
                            isView = provincia.value;
                        }
                    }
                    html += '<option value="' + (provincia.value) + '">' + (provincia.text) + '</option>';
                });
            } else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('[name="id_provincia"]', self.$modal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_provincia"]', self.$modal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-provincia', self.$modal).hide();
            self.loadCiudad(fLoad);
        });
    },
    loadCiudad: function (fLoad/*=undefined*/)
    {
        var self = this;
        var id_provincia = $('select[name="id_provincia"]', self.$modal).select2('val');
        $('.el-fin-ciudad', self.$modal).show();
        CustomerCrossfit_Model.loadCiudad(id_provincia, function (res) {
            var html = '';
            if (res.data['cbo-ciudad'].length > 0)
            {
                var isView = 0;
                var _value = $('select[name="id_ciudad"]', self.$modal).attr('_value');
                $.each(res.data['cbo-ciudad'], function (idx, ciudad)
                {
                    if (typeof _value == 'undefined')
                            //if (_value == 0)
                            {
                                if (ciudad.value == Customer_Crossfit_Base.customer_crossfit_form_default.id_ciudad.value)
                                {
                                    isView = ciudad.value;
                                }
                            } else
                    {
                        if (ciudad.value == _value)
                        {
                            isView = ciudad.value;
                        }
                    }
                    html += '<option value="' + (ciudad.value) + '">' + (ciudad.text) + '</option>';
                });
            } else
            {
                html += '<option value="">&lt;VACIO&gt;</option>';
            }
            $('select[name="id_ciudad"]', self.$modal)
                    .html(html)
                    .select2('val', isView != 0 ? isView : $('[name="id_ciudad"]', self.$modal).eq(0).select2("val"))
                    .select2('close');
            $.uniform.update();
            $('.el-fin-ciudad', self.$modal).hide();
            if (fLoad)
            {
                fLoad();
            }
        });
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
        CustomerCrossfit_Model.saveCustomer(data, function (res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
                self.close();
                Customer_Crossfit_Controller.refresDataTable(false);
            } else
            {
                Core.Notification.error(res.message);
                self.formLoading('none');
                self.formError(res.forms.customer);
                self.formReadOnly(false);
            }

        });
    }
};

var Modal_ControlIMC = {
    init: function ()
    {
        var self = this;
        self.$modalControl = $('#form_control_modal');

        if (!Customer_Crossfit_Base.permissions.create_imc) {
            //$('.panel-toolbar', self.$modalControl).hide();
            $('.pn-imc', self.$modalControl).hide();
        }

        self.$tableControl = $('.datatable table', self.$modalControl);

        self.$modalControl.on("show.bs.modal", function () {
            //alert('show form');
        });

        self.$modalControl.on("hidden.bs.modal", function () {
            self.$tableControl.dataTable().fnDestroy();
            self.formReset();
        });


        $('.action-popup-agregar', self.$modalControl).click(function () {
            if (Customer_Crossfit_Base.permissions.create_imc)
            {
                self.actionSave();
            }
        });



        $('[action="action-refresh"]', self.$modalControl).click(function () {
            self.refresDataTable(false);
        });

    },
    refresDataTable: function (isDraw /*=true*/)
    {
        var self = this;

        setInterval(self.$tableControl.dataTable().fnDraw(isDraw), 3000);
    },
    close: function ()
    {
        var self = this;

        self.formReset();
        self.$modalControl.modal('hide');
    },
    // =======================================================================
    formReset: function ()
    {
        var self = this;
        self.dataDefault();
        self.errorClear();
        self.formReadOnly(false);
        self.formLoading('none');

    },
    dataDefault: function ()
    {
        this.data(Customer_Crossfit_Base.control_imc_form_default);
    },
    errorClear: function ()
    {
        this.formError(Customer_Crossfit_Base.control_imc_form_default);
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;

        var self = this;
        $('[name="weight"]', self.$modalControl).prop('readonly', isFormReadOnly);
        $('[name="height"]', self.$modalControl).prop('readonly', isFormReadOnly);

        $.uniform.update();
    },
    data: function (data/*=UNDEFINED*/)
    {
        var self = this;

        if (data)
        {

            var id_customer = data.id_customer.value;
            var weight = data.weight.value;
            var height = data.height.value;

            $('[name="id_customer"]', self.$modalControl).val(id_customer);
            $('[name="weight"]', self.$modalControl).val(weight);
            $('[name="height"]', self.$modalControl).val(height);

            $.uniform.update();
            return;
        }
        data = {
            id_customer: $('[name="id_customer"]', self.$modalControl).val(),
            weight: $('[name="weight"]', self.$modalControl).val(),
            height: $('[name="height"]', self.$modalControl).val()
        };
        return data;
    },
    formLoading: function (key)
    {
        var self = this;

        switch (key)
        {
            case 'save':
                //$('.loading span', self.$modal).html('Guardando...');
                //$('.loading', self.$modal).show();

                $('.action-popup-agregar, .action-close', self.$modalControl).addClass('disabled');
                //$('.action-popup-agregar', self.$modal).attr('disabled')
                Core.Loading.wait(true, $('.pn-imc', self.$modalControl));
                self.formReadOnly(true);

                break;
            case 'load':
                //$('.loading span', self.$modal).html('Cargando...');
                //$('.loading', self.$modal).show();
                $('.action-popup-agregar, .action-close', self.$modalControl).addClass('disabled');
                Core.Loading.wait(true, $('.pn-imc', self.$modalControl));
                self.formReadOnly(true);
                break;
            case 'none':
                //$('.loading span', self.$modal).html('');
                //$('.loading', self.$modal).hide();
                $('.action-popup-agregar, .action-close', self.$modalControl).removeClass('disabled');
                Core.Loading.wait(false, $('.pn-imc', self.$modalControl));
                self.formReadOnly(false);
                break;
        }
    },
    formError: function (data)
    {
        var self = this;

        var $form_group = $('.form-group', self.$modalControl);

        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();

        for (var field_name in data)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$modalControl).closest('.form-group');
            if (!$.isEmptyObject(data[field_name].error))
            {
                $form_group.addClass('has-error');
                $('.label-danger', $form_group).html(data[field_name].error).show();
            }
        }
    },
    formType: function (type /* new, view */)
    {
        var self = this;

        if (type == 'new')
        {
            $('.action-popup-agregar', self.$modalControl).show();
            if (!Customer_Crossfit_Base.permissions.create_imc)
            {
                $('.pn-imc', self.$modalControl).hide();
            } else
            {
                $('.pn-imc', self.$modalControl).show();
            }


            self.formReadOnly(false);
        } else if (type == 'view')
        {
            $('.action-popup-agregar', self.$modalControl).hide();
            $('.pn-imc', self.$modalControl).hide();
            self.formReadOnly(true);
        }
    },
    open: function (id_customer/*=0*/, person/*null*/, isView/*=false*/)
    {
        var self = this;
        id_customer = typeof id_customer == 'undefined' ? 0 : id_customer;
        isView = typeof isView == 'boolean' ? isView : false;
        $('.modal-title span', self.$modalControl).html(' :: ' + person + ' :: ');
        $('.panel-title span', self.$modalControl).html(' :: ' + person + ' :: ');
        self.$tableControl.dataTable({
            bJQueryUI: false,
            bAutoWidth: false,
            bProcessing: false,
            bServerSide: true,
            bSort: false,
            sPaginationType: "full_numbers",
            sDom: '<"datatable-header"Tfl><"datatable-scroll"tr><"datatable-footer"ip>',
            sAjaxSource: Core.site_url(Customer_Crossfit_Base.linkx + "/process/list-control-imc"),
            fnServerParams: function (aoData)
            {
                Core.Loading.wait(true, $('tbody', $(this)));
                aoData.push({"name": "id_customer", "value": id_customer});
            },
            aoColumnDefs: [
                {sClass: "center", "aTargets": [0]},
                {sClass: "center", "aTargets": [1]},
                {sClass: "center", "aTargets": [2]},
                {sClass: "center", "aTargets": [3]},
                {sClass: "left file-info", "aTargets": [4]},
                {sClass: "left file-info", "aTargets": [5]}

            ],
            fnDrawCallback: function ()
            {
                Core.Loading.wait(false, $('tbody', $(this)));

                $('.tip', self.$tableControl).tooltip();
            }

        });
        $('[name="DataTables_Table_1_length"]', self.$modalControl).select2({minimumResultsForSearch: -1});


        self.formReset();
        self.formType('new');
        if (!Customer_Crossfit_Base.permissions.access_imc)
        {
            self.formType('view');
        }
        $('[name="id_customer"]', self.$modalControl).val(id_customer);
        self.$modalControl
                .off('shown.bs.modal')
                .on('shown.bs.modal', function () {
                    /*self.initLoadComponents(function () {
                     fLoad();
                     });*/
                })
                .modal('show');
    },
    //====================
    // ACTIONS
    //====================
    actionSave: function ()
    {
        var self = this;
        var data = self.data();
        var id_customer = $('[name="id_customer"]', self.$modalControl).val();
        self.errorClear();
        self.formLoading('save');
        CustomerCrossfit_Model.saveControlIMC(data, function (res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
                //self.close();
                self.formReset();
                $('[name="id_customer"]', self.$modalControl).val(id_customer);
                Modal_ControlIMC.refresDataTable(false);
            } else
            {
                Core.Notification.error(res.message);
                self.formLoading('none');
                self.formError(res.forms.control);
                self.formReadOnly(false);
            }

        });
    }
};
Core.addInit(function () {
    Customer_Crossfit_Controller.init();
});

