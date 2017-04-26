$.fn.modal.Constructor.prototype.enforceFocus = function () {
};

var Administration_Tab_Controller = {
    init: function ()
    {
        Company_Controller.init();
        Company_Branch_Controller.init();
    }
};

// ====================================================================================
// TAB EMPRESA
// ====================================================================================
var Company_Controller = {
    init: function ()
    {
        var self = this;
        self.$tab = $('#tab_company_data');
        self.$form_company = $("[name='company']", self.$tab);
        self.$form_logo = $("[name='upload_logo']", self.$tab);

        if (!Administration_Company_Base.permissions.access_company)
        {
            self.$tab.hide();
        }

        $('.action-save', self.$form_company).click(function () {
            if (Administration_Company_Base.permissions.update_company)
            {
                self.actionSave();
            }
        });

        $('.action-edit', self.$form_company).click(function () {
            if (Administration_Company_Base.permissions.update_company)
            {
                self.formMode('edit', self.$form_company);
            }
        });

        $('.action-edit', self.$form_logo).click(function () {
            if (Administration_Company_Base.permissions.update_logo_company)
            {
                self.formMode('edit', self.$form_logo);
            }
        });

        $('.action-save', self.$form_logo).click(function () {
            if (Administration_Company_Base.permissions.update_logo_company)
            {
                self.actionUpload();
            }
        });

        if (!Administration_Company_Base.permissions.update_company)
        {
            $('.action-edit', self.$form_company).hide();
            $('.action-save', self.$form_company).hide();
        }

        if (!Administration_Company_Base.permissions.update_logo_company)
        {
            $('.action-save', self.$form_logo).hide();
            $('.action-edit', self.$form_logo).hide();
        }


        $('.action-cancel', self.$form_company).click(function () {
            self.formMode('view', self.$form_company);
        });

        $('.action-cancel', self.$form_logo).click(function () {
            self.formMode('view', self.$form_logo);
        });

        /*precess bar*/
        self.$progress_bar = $('.progress-bar', self.$form_logo);
        self.$percent = $('.progress-bar span', self.$form_logo);
        $('.view_pre_upload', self.$form_logo).hide();

        self.reset();
        self.formMode('view', self.$form_company);
        self.formMode('view', self.$form_logo);
        self.dataLoad();

    },
    beforeProcessBar: function ()
    {
        var self = this;
        $('.view_pre_upload', self.$form_logo).show();
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
            //console.log(Percentage);
            var percentVal = Percentage + '%';
            //console.log(percentVal);
            Company_Controller.$progress_bar.width(percentVal);
            Company_Controller.$percent.html(percentVal);
            /*if(Percentage >= 100)
             {
             // process completed  
             }*/
        }
    },
    reset: function ()
    {
        this.dataDefault();
        this.errorClear();
    },
    //====================
    // DATA
    //====================
    dataDefault: function ()
    {
        this.data(Administration_Company_Base.data_company_default);
    },
    dataLoad: function ()
    {
        var self = this;

        self.formLoading(true, self.$form_company);
        self.formLoading(true, self.$form_logo);

        Company_Model.loadCompany(function (res) {
            self.formLoading(false, self.$form_company);
            self.formLoading(false, self.$form_logo);

            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
            }
            self.data(res.forms.company);
            self.data_logo(res.data.uri_logo);
        });
    },
    data_logo: function (uri_logo/*=UNDEFINED*/)
    {
        var self = this;

        if (uri_logo)
        {
            if (uri_logo != '')
            {
                $('.logo-preview', self.$form_logo).attr('src', uri_logo + '?' + ((new Date()).getTime()));
            }
            $.uniform.update();
            return;
        }


        /*var file = $('[name="logo"]', self.$form_logo)[0].files[0];
         //obtenemos el nombre del archivo
         var fileName = file.name;
         //obtenemos la extensión del archivo
         fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
         //obtenemos el tamaño del archivo
         var fileSize = file.size;
         //obtenemos el tipo de archivo image/png ejemplo
         var fileType = file.type;
         //mensaje con la información del archivo
         console.log("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
         */
        var formData = new FormData($("[name='upload_logo']", self.$tab)[0]);

        uri_logo = formData;
        return uri_logo;
    },
    data: function (company_data/*=UNDEFINED*/)
    {
        var self = this;

        if (company_data)
        {
            $('input[name="name"]', self.$tab).val(company_data.name.value);
            $('input[name="description"]', self.$tab).val(company_data.description.value);
            $('input[name="name_key"]', self.$tab).val(company_data.name_key.value);
            $('input[name="phone"]', self.$tab).val(company_data.phone.value);

            $.uniform.update();

            return;
        }

        company_data = {
            name: $('[name="name"]', self.$tab).val(),
            name_key: $('[name="name_key"]', self.$tab).val(),
            description: $('[name="description"]', self.$tab).val(),
            phone: $('[name="phone"]', self.$tab).val()
        };

        return company_data;
    },
    //====================
    // ERRORS
    //====================
    errorClear: function ()
    {
        this.errorData(Administration_Company_Base.data_company_default);
    },
    errorData: function (company_data_error/*=UNDEFINED*/)
    {
        var self = this;

        var $tab_group = $('.form-group', self.$tab);

        $tab_group.removeClass('has-error');
        $('.label-danger', $tab_group).html('').hide();

        if (typeof company_data_error == 'undefined') {
            return;
        }

        for (var field_name in company_data_error)
        {
            var $tab_group = $('[name="' + (field_name) + '"]', self.$tab).closest('.form-group');
            if (!$.isEmptyObject(company_data_error[field_name].error))
            {
                $tab_group.addClass('has-error');
                $('.label-danger', $tab_group).html(company_data_error[field_name].error).show();
            }
        }

    },
    //====================
    // FORM
    //====================
    formLoading: function (isLoading, $form)
    {
        var self = this;

        var $target = $form;

        isLoading ? Core.Loading.wait(true, $target) : Core.Loading.wait(false, $target);
    },
    formMode: function (mode, $form)
    {
        var self = this;

        switch (mode)
        {
            case 'view':
                $('.action-save', $form).hide();
                $('.action-edit', $form).show();
                $('.action-cancel', $form).hide();

                $('input[name]', $form).prop('disabled', true);
                break;
            case 'edit':
                $('.action-save', $form).show();
                $('.action-edit', $form).hide();
                $('.action-cancel', $form).show();

                $('input[name]', $form).prop('disabled', false);
                break;
        }
    },
    //====================
    // ACTIONS
    //====================
    actionSave: function ()
    {
        var self = this;
        var data = self.data();

        self.errorClear();
        self.formLoading(true, self.$form_company);

        Core.Ajax.post(Core.site_url(Administration_Company_Base.linkx + '/process/save-company'), data, function (res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
                self.data(res.forms.company);
            }
            else
            {
                Core.Notification.error(res.message);
                self.errorData(res.forms.company);
            }

            self.formLoading(false, self.$form_company);
            self.formMode('view', self.$form_company);
        }, function () {
            self.formLoading(false, self.$form_company);
            self.formMode('view', self.$form_company);
        });
    },
    actionUpload: function ()
    {
        var self = this;

        self.formLoading(true, self.$form_logo);
        var data = self.data_logo();

        Company_Model.uploadLogo(data, function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                //self.errorData(res.data.company_error);
            }
            else
            {
                Core.Notification.success(res.message);
                self.data_logo(res.data.data.full_path);
            }
            self.formLoading(false, self.$form_logo);
            self.formMode('view', self.$form_logo);

        });
    }
};

// ====================================================================================
// TAB SUCURSALES
// ====================================================================================

var Company_Branch_Controller = {
    init: function ()
    {
        var self = this;
        self.$tab = $('#tab_company_branches');
        self.$table = $('.datatable table');

        self.$table.dataTable({
            bJQueryUI: false,
            bAutoWidth: false,
            bProcessing: false,
            bServerSide: true,
            bSort: false,
            sPaginationType: "full_numbers",
            sDom: '<"datatable-header"Tfl><"datatable-scroll"tr><"datatable-footer"ip>',
            sAjaxSource: Core.site_url(Administration_Company_Base.linkx + "/process/list-branch"),
            fnServerParams: function (aoData)
            {
                Core.Loading.wait(true, $('tbody', $(this)));
            },
            aoColumnDefs: [
                {sClass: "center", "aTargets": [3]},
                {sClass: "center", "aTargets": [4]},
                {
                    aTargets: [3], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-state" value="' + (data) + '"/>';
                    }
                },
                {
                    aTargets: [4], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-option" value="' + (data) + '"/>';
                    }
                }
            ],
            fnDrawCallback: function (oSettings)
            {
                Core.Loading.wait(false, $('tbody', $(this)));
                /*var jsonRes = oSettings.jqXHR.responseJSON;
                 
                 if (!jsonRes.isSuccess)
                 {
                 Core.Notification.error(jsonRes.message);
                 }*/

                // aTargets: [3]
                $('.dt-col-state').each(function () {
                    var data = $(this).val();

                    var html = Company_Branch_View.dtStateTable(data);
                    var $html = $(html);

                    $(this).after($html);
                });

                // aTargets: [4]
                $('.dt-col-option').each(function () {
                    var data = $(this).val();

                    var html = Company_Branch_View.dtOptionsTable();
                    //alert(html);
                    var $html = $(html);

                    $('.dt-action-view', $html).click(function () {
                        Modal_Company_Branch.open(data, true);
                    });

                    $('.dt-action-edit', $html).click(function () {
                        Modal_Company_Branch.open(data, false);
                    });

                    $(this).after($html);
                });
                $('.tip').tooltip();
            }
        });

        $('.action-new', self.$tab).click(function () {
            Modal_Company_Branch.open();
        });
        
        $('[action="action-refresh"]', self.$tab).click(function () {
            self.refresDataTable(false);
        });
        
        Modal_Company_Branch.init();
    },
    refresDataTable: function (isDraw /*=true*/)
    {
        var self = this;

        setInterval(self.$table.dataTable().fnDraw(isDraw), 3000);
    }
};

var Modal_Company_Branch = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#modal_branch_form');

        $('button.action-save', self.$modal).click(function () {
            self.actionSave();
        });

        $('button.action-edit', self.$modal).click(function () {
            self.formReadOnly(false);
            self.formType('edit');
        });

        self.$modal.on("show.bs.modal", function () {
            //alert('show form');
        });

        self.$modal.on("hidden.bs.modal", function () {
            self.formReset();
        });

        $('select[name="id_pais"]', self.$modal).on('change', function () {
            self.loadProvincia();
        });

        $('select[name="id_provincia"]', self.$modal).on('change', function () {
            self.loadCiudad();
        });
    },
    loadPais: function (fLoad)
    {

        var self = this;
        $('.el-fin-pais', self.$modal).show();
        Company_Branch_Model.loadPais(function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-pais'].length > 0)
            {
                var _value = $('select[name="id_pais"]', self.$modal).attr('_value');
                $.each(res.data['cbo-pais'], function (idx, pais)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (pais.value == Administration_Company_Base.data_company_branch_default.id_pais.value)
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
      
        Company_Branch_Model.loadProvincia(id_pais, function (res) {
            var html = '';
            var isView = 0;
            if (res.data['cbo-provincia'].length > 0)
            {
                var _value = $('select[name="id_provincia"]', self.$modal).attr('_value');
                $.each(res.data['cbo-provincia'], function (idx, provincia)
                {
                    if (typeof _value == 'undefined')
                    {
                        if (provincia.value == Administration_Company_Base.data_company_branch_default.id_provincia.value)
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
        //Core.Loading.wait(true, $('.el-fin-ciudad', self.$modal));
        Company_Branch_Model.loadCiudad(id_provincia, function (res) {
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
                                if (ciudad.value == Administration_Company_Base.data_company_branch_default.id_ciudad.value)
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
    //=============================================================
    //=============================================================

    open: function (id_company_branch/*=0*/, isView/*=false*/)
    {
        var self = this;

        id_company_branch = typeof id_company_branch == 'undefined' ? 0 : id_company_branch;
        isView = typeof isView == 'boolean' ? isView : false;

        self.formReset();
        //self.$modal.modal('show');
        self.formLoading('load');
        self.formReadOnly(true);

        if (id_company_branch == 0)
        {
            self.formType('new');
            self.formReadOnly(true);
            var fLoad = function ()
            {
                self.formLoading('none');
                self.formReadOnly(false);
            };
        }
        else
        {
            self.dataLoad(id_company_branch);
            if (isView)
            {
                self.formType('view');
            }
            else
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
                    self.loadPais(function () {
                        fLoad();
                    });
                })
                .modal('show');

    },
    dataLoad: function (id_company_branch)
    {
        var self = this;
        Company_Branch_Model.loadCompanyBranch(id_company_branch, function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                self.close();
                return;
            }
            self.data(res.forms.company_branch);
        }, function () {
            self.close();
        });

    },
    data: function (form_data/*=UNDEFINED*/)
    {
        var self = this;

        if (form_data)
        {
            //fields
            var id_company_branch = form_data.id_company_branch.value;
            var name = form_data.name.value;
            var address = form_data.address.value;
            var phone = form_data.phone.value;
            var id_pais = form_data.id_pais.value;
            var id_provincia = form_data.id_provincia.value;
            var id_ciudad = form_data.id_ciudad.value;
            var isActive = (form_data.isActive.value == 0) ? false : true;
            var monthly_price = form_data.monthly_price.value;
            var daily_price = form_data.daily_price.value;

            $('[name="id_company_branch"]', self.$modal).val(id_company_branch);
            $('[name="name"]', self.$modal).val(name);
            $('[name="address"]', self.$modal).val(address);
            $('[name="phone"]', self.$modal).val(phone);
            $('[name="monthly_price"]', self.$modal).val(monthly_price);
            $('[name="daily_price"]', self.$modal).val(daily_price);
            $('[name="isActive"]', self.$modal).prop('checked', isActive);
            $('[name="id_pais"]', self.$modal).attr('_value', id_pais);
            $('[name="id_provincia"]', self.$modal).attr('_value', id_provincia);
            $('[name="id_ciudad"]', self.$modal).attr('_value', id_ciudad);

            $.uniform.update();

            return;
        }

        form_data = {
            id_company_branch: $('[name="id_company_branch"]', self.$modal).val(),
            name: $('[name="name"]', self.$modal).val(),
            address: $('[name="address"]', self.$modal).val(),
            phone: $('[name="phone"]', self.$modal).val(),
            isActive: $('[name="isActive"]', self.$modal).prop('checked') ? 1 : 0,
            id_ciudad: $('[name="id_ciudad"]', self.$modal).select2('val'),
            monthly_price: $('[name="monthly_price"]', self.$modal).val(),
            daily_price: $('[name="daily_price"]', self.$modal).val()
        };

        return form_data;
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

        self.dataDefault();
        self.errorClear();
        self.formReadOnly(false);
        self.formLoading('none');
    },
    dataDefault: function ()
    {
        this.data(Administration_Company_Base.data_company_branch_default);
    },
    errorClear: function ()
    {
        this.formError(Administration_Company_Base.data_company_branch_default);
    },
    formType: function (type /* new, edit, view */)
    {
        var self = this;

        if (type == 'new')
        {
            $('.modal-title span', self.$modal).html('Nueva');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();

            self.formReadOnly(false);
        }
        else if (type == 'edit')
        {
            $('.modal-title span', self.$modal).html('Editar');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();

            self.formReadOnly(false);
        }
        else if (type == 'view')
        {
            $('.modal-title span', self.$modal).html('Ver');

            $('.action-save', self.$modal).hide();

            if (Administration_Company_Base.permissions.update_branch)
            {
                $('.action-edit', self.$modal).show();
            }
            else
            {
                $('.action-edit', self.$modal).hide();
            }

            self.formReadOnly(true);
        }
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;

        $('[name="name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="address"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="phone"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="isActive"]', self.$modal).prop('disabled', isFormReadOnly);
        $('[name="id_pais"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_provincia"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="id_ciudad"]', self.$modal).select2('enable', !isFormReadOnly);
        $('[name="monthly_price"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="daily_price"]', self.$modal).prop('readonly', isFormReadOnly);
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
                $('.action-save, .action-edit, .action-close').addClass('disabled');
                break;
            case 'load':
                $('.loading span', self.$modal).html('Cargando...');
                $('.loading', self.$modal).show();
                $('.action-save, .action-edit, .action-close').addClass('disabled');
                break;
            case 'none':
                $('.loading span', self.$modal).html('');
                $('.loading', self.$modal).hide();
                $('.action-save, .action-edit, .action-close').removeClass('disabled');
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
    // ======================================================================
    // ======================================================================
    actionSave: function ()
    {
        var self = this;
        $.uniform.update();

        self.formLoading('save');
        self.formReadOnly(true);

        var data = self.data();

        Company_Branch_Model.saveCompanyBranch(data, function (data) {
            if (data.isSuccess)
            {
                Core.Notification.success(data.message);
                self.close();
                Company_Branch_Controller.refresDataTable(false);
            }
            else
            {
                Core.Notification.error(data.message);
                self.formLoading('none');
                self.formError(data.forms.company_branch);
                self.formReadOnly(false);
            }


        });
    }
};

Core.addInit(function () {
    Administration_Tab_Controller.init();
});