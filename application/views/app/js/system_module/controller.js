var Controller_Module = {
    //************************************************
    // FUNCTION **************************************
    //************************************************
    init: function ()
    {
        var self = this;

        $('[action="action-new-module"]').click(function () {
            Modal_Module.open();
        });

        $('[action="action-save-order"]').click(function () {
            self.actionSaveOrder();
        });

        self.eventLoadModulesSubmodules();
    },
    eventLoadModulesSubmodules: function ()
    {
        var self = this;

        Core.Loading.wait(true, $('.sortable-module .panel'));

        Model_Module.loadModulesSubmodules(function (res) {
            Core.Loading.wait(false, $('.sortable-module .panel'));
            self.htmlPanelModulesSubmodules(res);
        }, function () {
            Core.Loading.wait(true, $('.sortable-module .panel'));
        });
    },
    eventReloadModulesSubmodules: function ()
    {
        var self = this;

        self.eventLoadModulesSubmodules();
    },
    htmlPanelModulesSubmodules: function (res)
    {
        if (!res.isSuccess)
        {
            Core.Notification.error(res.message);
            return;
        }

        $('.sortable-module').html('');

        var data = res.data._modules_submodules;
        $.each(data, function (i, dt) {
            var $panel = $('[element="panel-module"] > .panel').clone();

            //============
            // FILL DATA
            //============

            $('[name="id_module"]', $panel).val(dt.id);
            var icon = (dt.name_icon == '') ? '<i class="icon-table2"></i>' : '<i class="' + dt.name_icon + '"></i>';
            $('.panel-title', $panel).append(icon + dt.name);

            //============
            // ACTIONS
            //============

            $('[action="view-module"]', $panel).click(function () {
                //alert( dt.parent.id );
                Modal_Module.open(dt.id, true);
            });
            //
            $('[action="edit-module"]', $panel).click(function () {
                //alert( dt.parent.id );
                Modal_Module.open(dt.id);
            });

            //======================
            // FILL DATA SUBMODULES
            //======================

            $.each(dt._submodules, function (i, submodule) {
                var $tr = $('[element="panel-module-table-tr"] tr').clone();

                $tr.data({'id_module': submodule.id});
                $('td:nth-child(2)', $tr).html(submodule.name);
                $('td:nth-child(3)', $tr).html(submodule.name_key);
                $('td:nth-child(4)', $tr).html(submodule.description);

                // ACTIONS ====

                $('[action="action-view"]', $tr).click(function () {
                    Modal_Module.open(submodule.id, true);
                });

                $('[action="action-edit"]', $tr).click(function () {
                    Modal_Module.open(submodule.id);
                });

                // =============

                $('.sortable-submodule', $panel).append($tr);
            });

            //======================
            //======================

            $('.sortable-module').append($panel);
        });

        $(".sortable-module").sortable({
            revert: true,
            handle: ".sortable-module-handle"
        });

        $(".sortable-submodule").sortable({
            revert: true,
            handle: ".sortable-submodule-handle"
        });
    },
    actionSaveOrder: function ()
    {
        Core.Loading.wait(true, $('.sortable-module .panel'));

        var i = 0;
        var data = [];
        $('.sortable-module > .panel').each(function () {
            var $panel = $(this);

            var id_module = $('input[name="id_module"]', $panel).val();

            data.push({'id_module': id_module, 'order': i++});

            var j = 0;
            $('.sortable-submodule > tr', $panel).each(function () {
                var $tr = $(this);

                var dt = $tr.data();

                data.push({'id_module': dt.id_module, 'order': j++});
            });
        });

        Model_Module.saveOrderModules({data: data}, function (res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
            }
            else
            {
                Core.Notification.error(res.message);
            }
            Core.Loading.wait(false, $('.sortable-module .panel'));
            Controller_Module.eventReloadModulesSubmodules();
        });
    }
};

var Modal_Module = {
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
            //self.formFields(null);
        });

        $('.action-popup-new-permission', self.$modal).click(function () {
            Modal_Module_Permission.open();
        });

        $('[name="consultarIconClass"]', self.$modal).click(function () {
            Modal_Icon_Class.open();
        });
        var $view_icon_class = $('.view_icon_class', self.$modal);

        $('select[name="id_parent_module"]', self.$modal).change(function () {
            $view_icon_class.hide();
            if ($(this).val() == 0)
            {
                $view_icon_class.show();
            }
            //console.log($( this ).val());
        });

    },
    //=============================================================
    //=============================================================
    open: function (id_module/*=0*/, isView/*=false*/)
    {
        var self = this;

        id_module = id_module ? id_module : 0;
        isView = (typeof isView == 'boolean') ? isView : false;

        self.$modal.modal('show');
        var fOnLoadComponents = function ()
        {
            self.dataLoad(id_module, isView);
        };

        self.modalComponentsInit(fOnLoadComponents);
    },
    close: function ()
    {
        this.reset();

        $('#form_modal').modal('hide');
    },
    modalComponentsInit: function (fOnLoadComponents)
    {
        var self = this;

        Model_Module.loadComponentsModalModule(function (res) {
            var html = '';

            $.each(res.data['combo-modules'], function (idx, module) {
                html += '<option value="' + (module.id) + '">' + (module.name) + '</option>';
            });
            $('[name="id_parent_module"]', self.$modal)
                    .html(html)
                    .select2('val', 0) // select the new term
                    .select2('close')       // close the dropdown
                    .change();

            $.uniform.update();

            fOnLoadComponents();
        }, function () {

        });
    },
    //=============================================================
    dataDefault: function ()
    {
        this.data(Base_Module.data_module_default);
    },
    dataLoad: function (id_module, isView)
    {
        var self = this;

        self.reset();

        self.formLoading('load');
        self.formType('new');
        self.formReadOnly(true);

        if (id_module == 0)
        {
            self.formLoading('none');

            if (!isView)
            {
                self.formReadOnly(false);
            }
        }
        else
        {
            Model_Module.loadModule(id_module, function (res) {
                if (!res.isSuccess)
                {
                    Core.Notification.error(res.message);
                    self.close();
                    return;
                }

                self.data(res.data.module);
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
    data: function (module_data/*=UNDEFINED*/)
    {
        var self = this;

        if (module_data)
        {
            //fields
            $('input[name="id_module"]', self.$modal).val(module_data.id_module);
            $('select[name="id_parent_module"]', self.$modal).select2('val', module_data.id_parent_module).change();
            $('input[name="name"]', self.$modal).val(module_data.name);
            $('input[name="name_key"]', self.$modal).val(module_data.name_key);
            $('input[name="description"]', self.$modal).val(module_data.description);
            $('input[name="id_icon"]', self.$modal).val(module_data.id_icon);
            $('[name="isActive"]', self.$modal).prop('checked', (module_data.isActive==0) ? false : true);
            $('[name="isAdmin"]', self.$modal).prop('checked', (module_data.isAdmin==0) ? false : true);
            
            self.dataPermissions(module_data._permissions);

            $.uniform.update();

            return;
        }

        module_data = {
            id_module: $('[name="id_module"]', self.$modal).val(),
            id_parent_module: $('[name="id_parent_module"]', self.$modal).select2('val'),
            name: $('[name="name"]', self.$modal).val(),
            name_key: $('[name="name_key"]', self.$modal).val(),
            description: $('[name="description"]', self.$modal).val(),
            id_icon: $('[name="id_icon"]', self.$modal).val(),
            isActive: $('[name="isActive"]',self.$modal).prop('checked') ? 1 : 0,
            isAdmin: $('[name="isAdmin"]',self.$modal).prop('checked') ? 1 : 0,
            _permissions: self.dataPermissions()
        };

        return module_data;
    },
    dataPermissions: function (module_permissions_datas/*=UNDEFINED*/)
    {
        var self = this;

        if (module_permissions_datas)
        {
            // permissions
            $('.data-permisions tbody', self.$modal).html('');
            $.each(module_permissions_datas, function (index, module_permission_data) {
                self.dataPermission(module_permission_data);
            });

            return;
        }

        module_permissions_datas = [];
        $('.data-permisions tbody tr', self.$modal).each(function (index, elTr) {
            var $_tr = $(elTr);

            module_permissions_datas.push({
                'permission_id': $('[name="permission_id"]', $_tr).val(),
                'permission_name': $('[name="permission_name"]', $_tr).val(),
                'permission_name_key': $('[name="permission_name_key"]', $_tr).val(),
                'permission_description': $('[name="permission_description"]', $_tr).val()
            });
        });

        return module_permissions_datas;
    },
    dataPermission: function (module_permission_data)
    {
        var self = this;

        var tr = null;
        $('.data-permisions tbody tr', self.$modal).each(function (index, elTr) {
            var $_tr = $(elTr);

            var permission_id = $('[name="permission_id"]', $_tr).val();

            if (permission_id == module_permission_data.permission_id)
            {
                tr = $_tr;
            }
        });

        if (tr == null)
        {
            tr = View_Module.trPermission();
        }

        var $tr = $(tr);

        $('td:nth-child(1)', $tr).html(module_permission_data.permission_name);
        $('td:nth-child(2)', $tr).html(module_permission_data.permission_name_key);
        $('td:nth-child(3)', $tr).html(module_permission_data.permission_description);

        $('[name="permission_id"]', $tr).val(module_permission_data.permission_id);
        $('[name="permission_name"]', $tr).val(module_permission_data.permission_name);
        $('[name="permission_name_key"]', $tr).val(module_permission_data.permission_name_key);
        $('[name="permission_description"]', $tr).val(module_permission_data.permission_description);

        $('td:nth-child(4) .dt-action-edit-permission', $tr).off('click').on('click', function () {
            Modal_Module_Permission.open(module_permission_data);
        });

        $('.data-permisions tbody', self.$modal).append($tr);
    },
    // ===========================================================
    reset: function ()
    {
        this.dataDefault();
        this.errorClear();

        this.formReadOnly(false);
        this.formLoading('none');
    },
    //=============================================================
    errorClear: function ()
    {
        this.errorData(Base_Module.data_module_default);
    },
    errorData: function (module_data_error)
    {
        var self = this;

        var $form_group = $('.form-group', self.$modal);

        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();

        if (typeof module_data_error == 'undefined') {
            return;
        }
        for (var field_name in module_data_error)
        {
            if (module_data_error[field_name].length > 0)
            {
                var $form_group = $('[name="' + (field_name) + '"]', self.$modal).closest('.form-group');
                $form_group.addClass('has-error');
                $('.label-danger', $form_group).html(module_data_error[field_name]).show();
            }
        }
    },
    //=============================================================
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
            $('.action-edit', self.$modal).show();

            self.formReadOnly(true);
        }
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;

        $('input[name="id_module"]', self.$modal).prop('readonly', isFormReadOnly);
        $('select[name="id_parent_module"]', self.$modal).select2('enable', !isFormReadOnly);
        $('input[name="name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="name_key"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="description"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="id_icon"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="isActive"]', self.$modal).prop('disabled', isFormReadOnly);
        $('input[name="isAdmin"]', self.$modal).prop('disabled', isFormReadOnly);

        $('input[name="id_permissions[]"]', self.$modal).prop('disabled', isFormReadOnly);

        isFormReadOnly ? $('.table-controls', self.$modal).hide() : $('.table-controls', self.$modal).show();
        isFormReadOnly ? $('.panel-toolbar', self.$modal).hide() : $('.panel-toolbar', self.$modal).show();

        $.uniform.update();
    },
    formLoading: function (key)
    {
        var self = this;

        switch (key)
        {
            case 'save':
                $('.loading .text', self.$modal).html('Guardando...');
                $('.loading', self.$modal).show();
                $('.action-save, .action-edit, .action-close').addClass('disabled');
                break;
            case 'load':
                $('.loading .text', self.$modal).html('Cargando...');
                $('.loading', self.$modal).show();
                $('.action-save, .action-edit, .action-close').addClass('disabled');
                break;
            case 'none':
                $('.loading .text', self.$modal).html('');
                $('.loading', self.$modal).hide();
                $('.action-save, .action-edit, .action-close').removeClass('disabled');
                break;
        }
    },
    //=============================================================
    actionSave: function ()
    {
        var self = this;

        self.formLoading('save');
        self.formReadOnly(true);

        var data = self.data();

        Model_Module.saveModule(data, function (res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
                self.close();

                Controller_Module.eventReloadModulesSubmodules();
            }
            else
            {
                Core.Notification.error(res.message);
                self.formLoading('none');
                self.formReadOnly(false);

                self.errorData(res.data.module_error);
            }
        });
    }
};

var Modal_Module_Permission = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal_permission');

        //****************************************

        $('button.action-add', self.$modal).click(function () {
            self.actionAdd();
        });

        self.$modal.on("show.bs.modal", function () {
            //alert('show form');
        });

        self.$modal.on("hidden.bs.modal", function () {
            self.reset();
        });
    },
    //=============================================================
    //=============================================================
    open: function (data_permission/*UNDEFINED*/)
    {
        var self = this;

        self.reset();

        self.$modal.modal('show');

        if (typeof data_permission == 'undefined')
        {
            data_permission = Base_Module.data_permission_default;
        }

        self.data(data_permission);
    },
    close: function ()
    {
        var self = this;

        self.reset();
        self.$modal.modal('hide');
    },
    //=============================================================
    reset: function ()
    {
        var self = this;

        self.data(Base_Module.data_permission_default);
        self.errorData(Base_Module.data_permission_default);
    },
    //=============================================================
    data: function (data_permission/*=UNDEFINED*/)
    {
        var self = this;

        if (data_permission)
        {
            var id_permission = (data_permission.permission_id == 0) ? '-' + (new Date()).getTime() : data_permission.permission_id;
            var name = data_permission.permission_name;
            var name_key = data_permission.permission_name_key;
            var description = data_permission.permission_description;

            $('input[name="permission_id"]', self.$modal).val(id_permission);
            $('input[name="permission_name"]', self.$modal).val(name);
            $('input[name="permission_name_key"]', self.$modal).val(name_key);
            $('input[name="permission_description"]', self.$modal).val(description);

            $.uniform.update();

            return;
        }

        data_permission = {
            permission_id: $('input[name="permission_id"]', self.$modal).val(),
            permission_name: $('input[name="permission_name"]', self.$modal).val(),
            permission_name_key: $('input[name="permission_name_key"]', self.$modal).val(),
            permission_description: $('input[name="permission_description"]', self.$modal).val()
        };

        return data_permission;
    },
    errorData: function (data_error_permission/*=UNDEFINED*/)
    {
        var self = this;

        if (data_error_permission)
        {
            //console.log( data_error_permission );
            var $form_group = $('.form-group', self.$modal);

            $form_group.removeClass('has-error');
            $('.label-danger', $form_group).html('').hide();

            for (var field_name in data_error_permission)
            {
                if (data_error_permission[field_name].length != 0)
                {
                    var $form_group = $('[name="' + (field_name) + '"]', self.$modal).closest('.form-group');
                    $form_group.addClass('has-error');
                    $('.label-danger', $form_group).html(data_error_permission[field_name]).show();
                }
            }

            return;
        }

        var data_permission = self.data();
        data_error_permission = {};

        if (data_permission.permission_name.trim().length == 0) {
            data_error_permission.permission_name = 'Campo incompleto';
        }

        if (data_permission.permission_name_key.trim().length == 0) {
            data_error_permission.permission_name_key = 'Campo incompleto';
        }

        if (data_permission.permission_description.trim().length == 0) {
            data_error_permission.permission_description = 'Campo incompleto';
        }

        return data_error_permission;
    },
    formIsValidateAdd: function ()
    {
        var self = this;

        var permission_data_error = self.errorData();

        var isValid = $.isEmptyObject(permission_data_error);

        if (!isValid)
        {
            self.errorData(permission_data_error);
        }

        return isValid;
    },
    // =====================================
    actionAdd: function ()
    {
        var self = this;

        if (!self.formIsValidateAdd())
        {
            return;
        }

        var data_permission = self.data();

        Modal_Module.dataPermission(data_permission);
        self.close();
    }
};

var Modal_Icon_Class = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal_icon');

        //****************************************

        self.$modal.on("show.bs.modal", function () {
            //alert('show form');
        });

        self.$modal.on("hidden.bs.modal", function () {
            //self.reset();
        });
    },
    //=============================================================
    //=============================================================
    open: function ( )
    {
        var self = this;
        $(".content-icon-class").load('<?php echo site_url("app/icon_class/modal"); ?>');
        self.$modal.modal('show');
    },
    close: function ()
    {
        var self = this;

        self.$modal.modal('hide');
    }
};

Core.addInit(function () {
    Controller_Module.init();
    Modal_Module.init();
    Modal_Module_Permission.init();
    Modal_Icon_Class.init();
});