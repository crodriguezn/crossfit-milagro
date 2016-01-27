$.fn.modal.Constructor.prototype.enforceFocus = function () {
};


var Rol_Controller = {
    //************************************************
    // FUNCTION **************************************
    //************************************************
    init: function ()
    {
        var self = this;
        self.$table = $('.datatable table');

        if (!Rol_Base.permissions.create) {
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
            sAjaxSource: Core.site_url(Rol_Base.linkx + "/process/list-rol"),
            fnServerParams: function (aoData)
            {
                Core.Loading.wait(true, $('tbody', $(this)));
            },
            aoColumnDefs: [
                {sClass: "center", "aTargets": [0]},
                {sClass: "center", "aTargets": [1]},
                {sClass: "center", "aTargets": [2]},
                {
                    aTargets: [2], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-option" value="' + (data) + '"/>';
                    }
                }
            ],
            fnDrawCallback: function ()
            {
                Core.Loading.wait(false, $('tbody', $(this)));
                // aTargets: [3]
                $('.dt-col-option').each(function () {
                    var data = $(this).val();

                    var html = Rol_View.dtOptionsTable();
                    var $html = $(html);

                    $('.dt-action-view', $html).click(function () {
                        Rol_Modal.open(data, true);
                    });

                    $('.dt-action-edit', $html).click(function () {
                        Rol_Modal.open(data);
                    });

                    $(this).after($html);
                });
                $('.tip').tooltip();
            }
        });

        $('.action-popup-new').click(function () {
            Rol_Modal.open();
        });

        Rol_Modal.init();
    },
    refresDataTable: function (isDraw /*=true*/)
    {
        var self = this;

        setInterval(self.$table.dataTable().fnDraw(isDraw), 3000);
    }
};

var Rol_Modal = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal');

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

        $('[name="id_modules_all"]', self.$modal).change(function () {
            $('input[name="id_modules[]"]', self.$modal).prop('checked', $(this).prop("checked"));
            $.uniform.update();
        });
    },
    //=============================================================
    //=============================================================

    open: function (id_rol/*=0*/, isView/*=false*/)
    {
        var self = this;

        id_rol = typeof id_rol == 'undefined' ? 0 : id_rol;
        isView = typeof isView == 'boolean' ? isView : false;

        self.$modal.modal('show');
        self.dataLoad(id_rol, isView);

    },
    dataLoad: function (id_rol, isView)
    {
        var self = this;

        self.formReset();

        self.formLoading('load');
        self.formType('new');
        self.formReadOnly(true);

        if (id_rol == 0)
        {
            self.formLoading('none');

            if (!isView)
            {
                self.formReadOnly(false);
            }
        }
        else
        {
            Rol_Model.loadRol(id_rol, function (res) {
                if (!res.isSuccess)
                {
                    Core.Notification.error(res.message);
                    self.close();
                    return;
                }

                self.data(res.forms.rol);
                self.formLoading('none');
                if (isView)
                {
                    self.formType('view');
                }
                else
                {
                    self.formType('edit');
                    self.formReadOnly(false);
                }

            }, function () {
                self.close();
            });
        }
    },
    data: function (form_data/*=UNDEFINED*/)
    {
        var self = this;

        if (form_data)
        {
            //fields
            var id_rol = form_data.id_rol.value;
            var name = form_data.name.value;
            var name_key = form_data.name_key.value;

            $('[name="id_rol"]', self.$modal).val(id_rol);
            $('[name="name"]', self.$modal).val(name);
            $('[name="name_key"]', self.$modal).val(name_key);

            self.dataModules(form_data.id_modules.value);

            $.uniform.update();

            return;
        }

        form_data = {
            id_rol: $('[name="id_rol"]', self.$modal).val(),
            name: $('input[name="name"]', self.$modal).val(),
            name_key: $('input[name="name_key"]', self.$modal).val(),
            id_modules: self.dataModules()
        };

        return form_data;
    },
    dataModules: function (data_modules/*=UNDEFINED*/)
    {
        var self = this;


        if (data_modules)
        {
            // modules
            $.each(data_modules, function (index, value) {
                $('input[name="id_modules[]"][_id_module="' + (value) + '"]', self.$modal).prop('checked', true);
            });

            return;
        }

        // modules
        data_modules = [];
        $('input[name="id_modules[]"]', self.$modal).each(function (index, value) {
            if ($(this).prop('checked'))
            {
                data_modules.push($(this).attr('_id_module'));
            }
        });

        return data_modules;
    },
    close: function ()
    {
        var self = this;

        self.formReset();
        $('#form_modal').modal('hide');
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
        $('[name="id_modules[]"]', this.$modal).prop('checked', false);
        this.data(Rol_Base.rol_form_default);
    },
    errorClear: function ()
    {
        this.formError(Rol_Base.rol_form_default);
    },
    formType: function (type /* new, edit, view */)
    {
        var self = this;

        if (type == 'new')
        {
            $('.modal-title span', self.$modal).html('Nuevo');

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

            if (Rol_Base.permissions.update)
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

        $('input[name="name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="name_key"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="id_modules[]"]', self.$modal).prop('disabled', isFormReadOnly);
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

        Rol_Model.saveRol(data, function (data) {
            if (data.isSuccess)
            {
                Core.Notification.success(data.message);
                self.close();
                Rol_Controller.refresDataTable(false);
            }
            else
            {
                Core.Notification.error(data.message);
                self.formLoading('none');
                self.formError(data.forms.rol);
                self.formReadOnly(false);
            }


        });
    }
};

Core.addInit(function () {
    Rol_Controller.init();
});