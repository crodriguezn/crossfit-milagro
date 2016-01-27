$.fn.modal.Constructor.prototype.enforceFocus = function () {
};


var Profile_Controller = {
    //************************************************
    // FUNCTION **************************************
    //************************************************
    init: function ()
    {
        var self = this;
        self.$table = $('.datatable table');

        if (!Profile_Base.permissions.create) {
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
            sAjaxSource: Core.site_url(Profile_Base.linkx + "/process/list-profile"),
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
                        return '<input type="hidden" class="dt-col-state" value="' + (data) + '"/>';
                    }
                },
                {
                    aTargets: [3], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-option" value="' + (data) + '"/>';
                    }
                }
            ],
            fnDrawCallback: function ()
            {
                Core.Loading.wait(false, $('tbody', $(this)));
                // aTargets: [2]
                $('.dt-col-state').each(function () {
                    var data = $(this).val();

                    var html = Profile_View.dtStateTable(data);
                    var $html = $(html);

                    $(this).after($html);
                });

                // aTargets: [3]
                $('.dt-col-option').each(function () {
                    var data = $(this).val();

                    var html = Profile_View.dtOptionsTable();
                    var $html = $(html);

                    $('.dt-action-view', $html).click(function () {
                        Profile_Modal.open(data, true);
                    });

                    $('.dt-action-edit', $html).click(function () {
                        Profile_Modal.open(data);
                    });
                    $('.dt-action-view-permission', $html).click(function () {
                        location.href = Core.site_url('app/permissions/listing/' + data);
                        //Profile_Modal.open(data);
                    });

                    $(this).after($html);
                });
                $('.tip').tooltip();
            }
        });

        $('.action-popup-new').click(function () {
            Profile_Modal.open();
        });

        Profile_Modal.init();
    },
    refresDataTable: function (isDraw /*=true*/)
    {
        var self = this;

        setInterval(self.$table.dataTable().fnDraw(isDraw), 3000);
    }
};

var Profile_Modal = {
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

    }
    ,
    modalComponentsInit: function (fOnLoadComponents)
    {
        var self = this;

        Profile_Model.loadComponentsModalRoles(function (res) {
            var html = '';

            $.each(res.data['combo-roles'], function (idx, rol) {
                html += '<option value="' + (rol.value) + '">' + (rol.text) + '</option>';
            });
            $('select[name="id_rol"]', self.$modal)
                    .html(html)
                    .select2('val', 0) // select the new term
                    .select2('close');

            $.uniform.update();

            fOnLoadComponents();
        }, function () {

        });
    }
    ,
    //=============================================================
    //=============================================================

    open: function (id_profile/*=0*/, isView/*=false*/)
    {
        var self = this;

        id_profile = typeof id_profile == 'undefined' ? 0 : id_profile;
        isView = typeof isView == 'boolean' ? isView : false;

        self.$modal.modal('show');
        var fOnLoadComponents = function ()
        {
            self.dataLoad(id_profile, isView);

        };

        self.modalComponentsInit(fOnLoadComponents);
    },
    dataLoad: function (id_profile, isView)
    {
        var self = this;

        self.formReset();

        self.formLoading('load');
        self.formType('new');
        self.formReadOnly(true);

        if (id_profile == 0)
        {
            self.formLoading('none');

            if (!isView)
            {
                self.formReadOnly(false);
            }
        }
        else
        {
            Profile_Model.loadProfile(id_profile, function (res) {
                if (!res.isSuccess)
                {
                    Core.Notification.error(res.message);
                    self.close();
                    return;
                }

                self.data(res.forms.profile);
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
            var id_profile = form_data.id_profile.value;
            var id_rol = form_data.id_rol.value;
            var name = form_data.name.value;
            var description = form_data.description.value;
            var isActive = (form_data.isActive.value == 0) ? false : true;

            var ID_ROL_DEFAULT = $('[name="id_rol"] option:eq(0)').attr('value');
            $('[name="id_profile"]', self.$modal).val(id_profile);
            $('select[name="id_rol"]', self.$modal).select2('val', form_data.id_rol.value).change();
            $('[name="id_rol"]', self.$modal).select2('val', id_rol);
            $('[name="name"]', self.$modal).val(name);
            $('[name="description"]', self.$modal).val(description);
            $('[name="isActive"]', self.$modal).prop('checked', isActive);

            $.uniform.update();

            return;
        }

        form_data = {
            id_profile: $('[name="id_profile"]', self.$modal).val(),
            id_rol: $('[name="id_rol"]', self.$modal).select2('val'),
            name: $('[name="name"]', self.$modal).val(),
            description: $('[name="description"]', self.$modal).val(),
            isActive: $('[name="isActive"]', self.$modal).prop('checked') ? 1 : 0
        };

        return form_data;
    },
    close: function ()
    {
        this.formReset();
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
        this.data(Profile_Base.profile_form_default);
    },
    errorClear: function ()
    {
        this.formError(Profile_Base.profile_form_default);
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

            if (Profile_Base.permissions.update)
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
        $('[name="description"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="isActive"]', self.$modal).prop('disabled', isFormReadOnly);
        $('[name="id_rol"]', self.$modal).select2('enable', !isFormReadOnly);

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

        Profile_Model.saveProfile(data, function (data) {
            if (data.isSuccess)
            {
                Core.Notification.success(data.message);
                self.close();
                Profile_Controller.refresDataTable(false);
            }
            else
            {
                Core.Notification.error(data.message);
                self.formLoading('none');
                self.formError(data.forms.profile);
                self.formReadOnly(false);
            }


        });
    }
};

var Listing = {
    init: function ()
    {
        var self = this;

        self.$frm = $('[name="listing"]');

        $('[action="action-cancelar"]', self.$frm).click(function () {
            location.href = Core.site_url(Profile_Base.link);
        });
    }
};


Core.addInit(function () {
    Profile_Controller.init();
    Listing.init();
});