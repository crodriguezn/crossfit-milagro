$.fn.modal.Constructor.prototype.enforceFocus = function () {
};

var Listing = {
    init: function ()
    {
        var self = this;

        self.$frm = $('[name="listing"]');

        $('button.action-close', self.$frm).click(function () {
            location.href = Core.site_url(Listing_Base.link);
        });

        $('button.action-edit', self.$frm).click(function () {
            self.formReadOnly(false);
            self.formType('edit');
        });

        $('button.action-save', self.$frm).click(function () {
            self.actionSave();
        });

        $('[name="id_permission_all"]', self.$frm).change(function () {
            $('input[name="id_permissions[]"]', self.$frm).prop('checked', $(this).prop("checked"));
            $.uniform.update();
        });


        self.formType('view');
        self.formReset();
    }
    ,
    formType: function (type /* new, edit, view */)
    {
        var self = this;

        if (type == 'edit')
        {
            //$('.modal-title span', self.$frm).html('Editar');

            $('.action-save', self.$frm).show();
            $('.action-edit', self.$frm).hide();

            self.formReadOnly(false);
        }
        else if (type == 'view')
        {
            //$('.modal-title span', self.$frm).html('Ver');

            $('.action-save', self.$frm).hide();

            if (Listing_Base.permissions.update_permission)
            {
                $('.action-edit', self.$frm).show();
            }
            else
            {
                $('.action-edit', self.$frm).hide();
            }

            self.formReadOnly(true);
        }
    }
    ,
    formReadOnly: function (isFormReadOnly)
    {
        var self = this;
        $('input[name="id_permissions[]"]', self.$frm).prop('disabled', isFormReadOnly);
        $('[name="id_permission_all"]', self.$frm).prop('disabled', isFormReadOnly);
        $.uniform.update();
    }
    ,
    formReset: function ()
    {
        var self = this;
        //self.formReadOnly(false);
        self.formLoading('none');
    }
    ,
    formLoading: function (key)
    {
        var self = this;

        switch (key)
        {
            case 'save':
                $('.loading span', self.$frm).html('Guardando...');
                $('.loading', self.$frm).show();
                $('.action-save, .action-edit, .action-close').addClass('disabled');
                break;
            case 'load':
                $('.loading span', self.$frm).html('Cargando...');
                $('.loading', self.$frm).show();
                $('.action-save, .action-edit, .action-close').addClass('disabled');
                break;
            case 'none':
                $('.loading span', self.$frm).html('');
                $('.loading', self.$frm).hide();
                $('.action-save, .action-edit, .action-close').removeClass('disabled');
                break;
        }
    }
    ,
    actionSave: function ()
    {
        var self = this;
        $.uniform.update();

        self.formLoading('save');
        self.formReadOnly(true);

        // modules
        var id_permissions = [];
        $('input[name="id_permissions[]"]', self.$frm).each(function (index, value) {
            if ($(this).prop('checked'))
            {
                id_permissions.push($(this).attr('_id_permission'));
            }
        });

        var jsonData = {
            id_profile: $('[name="id_profile"]', self.$frm).val(),
            id_permissions: id_permissions
        };
        Listing_Model.saveProfilePermission(jsonData, function (data) {
            if (data.isSuccess)
            {
                Core.Notification.success(data.message);
                self.formReadOnly(false);
                self.formLoading('none');
                //self.close();
                //$('.datatable table').dataTable().fnDraw();
            }
            else
            {
                Core.Notification.error(data.message);
                self.formLoading('none');
                self.formReadOnly(false);
            }

        });
    }
};


Core.addInit(function () {
    Listing.init();
});