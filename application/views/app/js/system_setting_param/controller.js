$.fn.modal.Constructor.prototype.enforceFocus = function () {
};

var SettingParam_Controller = {
    init: function ()
    {
        var self = this;
        self.$form_setting = $("[name='setting_param']");
        self.$visor_logo = $(".panel-logo");

        $('.action-save', self.$form_setting).click(function () {
            if (SettingParam_Base.permissions.update)
            {
                self.actionSave();
            }
        });

        $('.action-edit', self.$form_setting).click(function () {
            if (SettingParam_Base.permissions.update)
            {
                self.formType('edit');
            }
        });

        if (!SettingParam_Base.permissions.update)
        {
            $('.action-edit', self.$form_setting).hide();
            $('.action-save', self.$form_setting).hide();
        }

        $('.action-cancel', self.$form_setting).click(function () {
            self.formType('view');
        });

        self.reset();
        self.formType('view');
        self.formLoading('none');
        self.dataLoad();
//        console.log(self.$form_setting[0]);
//        var formData = new FormData(self.$form_setting[0]);
//        console.log(formData);
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
        this.data(SettingParam_Base.data_setting_param_default);
    },
    data: function (data/*=UNDEFINED*/)
    {
        var self = this;

        if (data)
        {
            $('[name="name_system"]', self.$form_setting).val(data.name_system.value);
            $('[name="isSaveBinnacle"]', self.$form_setting).prop('checked', (data.isSaveBinnacle.value == 0) ? false : true);
            $('[name="name_system"]', self.$form_setting).val(data.name_system.value);
            $('select[name="session_time_limit_min"]', self.$form_setting).select2('val', data.session_time_limit_min.value);
            $('select[name="session_time_limit_max"]', self.$form_setting).select2('val', data.session_time_limit_max.value);

            if (data.logo.value)
            {
                if (data.logo.value != '')
                {
                    $('.logo-preview', self.$visor_logo).attr('src', data.logo.value + '?' + ((new Date()).getTime()));
                }
            }
            $.uniform.update();

            return;
        }
        var formData = new FormData(self.$form_setting[0]);
//        data = {
//            name_system: $('[name="name_system"]', self.$form_setting).val(),
//            session_time_limit_min: $('[name="session_time_limit_min"]', self.$form_setting).val(),
//            session_time_limit_max: $('[name="session_time_limit_max"]', self.$form_setting).val(),
//            formData: formData
//        };
        data = formData;
        return data;
    },
    dataLoad: function ()
    {
        var self = this;

        self.formLoading('load');

        SettingParam_Model.loadSettingParam(function (res) {
            self.formLoading('none');

            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
            }
            self.data(res.forms.setting);
        });
    },
    //====================
    // ERRORS
    //====================
    errorClear: function ()
    {
        this.errorData(SettingParam_Base.data_setting_param_default);
    },
    errorData: function (data_error/*=UNDEFINED*/)
    {
        var self = this;

        var $tab_group = $('.form-group', self.$form_setting);

        $tab_group.removeClass('has-error');
        $('.label-danger', $tab_group).html('').hide();

        if (typeof data_error == 'undefined') {
            return;
        }

        for (var field_name in data_error)
        {
            var $tab_group = $('[name="' + (field_name) + '"]', self.$form_setting).closest('.form-group');
            if (!$.isEmptyObject(data_error[field_name].error))
            {
                $tab_group.addClass('has-error');
                $('.label-danger', $tab_group).html(data_error[field_name].error).show();
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
                $('.loading span', self.$form_setting).html('Guardando...');
                $('.loading', self.$form_setting).show();
                $('.action-save, .action-edit, .action-cancel', self.$form_setting).addClass('disabled');
                break;
            case 'load':
                $('.loading span', self.$form_setting).html('Cargando...');
                $('.loading', self.$form_setting).show();
                $('.action-save, .action-edit, .action-cancel', self.$form_setting).addClass('disabled');
                break;
            case 'none':
                $('.loading span', self.$form_setting).html('');
                $('.loading', self.$form_setting).hide();
                $('.action-save, .action-edit, .action-cancel', self.$form_setting).removeClass('disabled');
                break;
        }
    },
    formType: function (type /* edit, view */)
    {
        var self = this;
        if (type == 'edit')
        {
            $('.action-save', self.$form_setting).show();
            $('.action-edit', self.$form_setting).hide();
            $('.action-cancel', self.$form_setting).show();
            self.formReadOnly(false);
        }
        else if (type == 'view')
        {
            $('.action-save', self.$form_setting).hide();
            $('.action-cancel', self.$form_setting).hide();
            if (SettingParam_Base.permissions.update)
            {
                $('.action-edit', self.$form_setting).show();
            }
            else
            {
                $('.action-edit', self.$form_setting).hide();
            }
            self.formReadOnly(true);
        }
    },
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;
        $('[name="name_system"]', self.$form_setting).prop('readonly', isFormReadOnly);
        $('[name="logo"]', self.$form_setting).prop('disabled', isFormReadOnly);
        $('[name="isSaveBinnacle"]', self.$form_setting).prop('disabled', isFormReadOnly);
        if(isFormReadOnly)
        {
            $('[name="session_time_limit_min"]', self.$form_setting).prop('disabled', true);
            $('[name="session_time_limit_max"]', self.$form_setting).prop('disabled', true);
        }
        else
        {
            $('select[name="session_time_limit_min"]', self.$form_setting).select2('enable', true);
            $('select[name="session_time_limit_max"]', self.$form_setting).select2('enable', true);
        }
        
        $.uniform.update();
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

        SettingParam_Model.saveSettingParam(data, function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                //self.errorData(res.data.company_error);
            }
            else
            {
                Core.Notification.success(res.message);
                var data = res.forms.setting;
//                self.data(res.forms.setting);
                if (data.logo.value)
                {
                    if (data.logo.value != '')
                    {
                        $('.logo-preview', self.$visor_logo).attr('src', data.logo.value + '?' + ((new Date()).getTime()));
                    }
                }
            }
            self.formLoading('none');
            self.formType('view');

        });
    }
};

Core.addInit(function () {
    SettingParam_Controller.init();
});