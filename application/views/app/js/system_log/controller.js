$.fn.modal.Constructor.prototype.enforceFocus = function () {
};


var Log_Controller = {
    //************************************************
    // FUNCTION **************************************
    //************************************************
    init: function ()
    {
        $('#fileTreeDemo_2').fileTree(
        {
            root: Log_Base.root,
            script: Log_Base.linkx + "/process/list-file",
            folderEvent: 'click',
            expandSpeed: 750,
            collapseSpeed: 750,
            multiFolder: false,
            element: $('.sortable-file')
        },
        function (file)
        {
            Log_Modal.open(file, true);
        }
        );
        Log_Modal.init();
    }
};

var Log_Modal = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal');


        self.$modal.on("show.bs.modal", function () {
            //alert('show form');
        });

        self.$modal.on("hidden.bs.modal", function () {
            self.formReset();
        });

    },
    //=============================================================
    //=============================================================

    open: function (file/*=0*/, isView/*=false*/)
    {
        var self = this;

        file = typeof file == 'undefined' ? 0 : file;
        isView = typeof isView == 'boolean' ? isView : false;
        self.formReset();
        self.$modal.modal('show');
        Core.Loading.load($('.file_text', self.$modal), true);
        Log_Model.loadFile(file, function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                self.close();
                return;
            }
            Core.Loading.load($('.file_text', self.$modal), false);
            $('.file_text', self.$modal).html(res.forms.file.text);
            self.formLoading('none');
            if (isView)
            {
                self.formType('view', res.forms.file.name);
                $('.loading span', self.$modal).html(res.forms.file.path+' ( size: '+res.forms.file.size+' ) ');
                $('.loading', self.$modal).show();
            }
            else
            {
                self.formType('edit', res.forms.file.name);
            }

        }, function () {
            self.close();
        });

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
        self.formLoading('none');

    },
    dataDefault: function ()
    {
        var self = this;
        $('.file_text', self.$modal).html('');
    },
    formType: function (type /* new, edit, view */, text /*=null*/)
    {
        var self = this;

        if (type == 'new')
        {
            $('.modal-title span', self.$modal).html('Nuevo');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();

        }
        else if (type == 'edit')
        {
            $('.modal-title span', self.$modal).html('Editar');
            $('.modal-title .name_file', self.$modal).html(' -- ' + text + ' -- ');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();

        }
        else if (type == 'view')
        {
            $('.modal-title span', self.$modal).html('Ver');
            $('.modal-title .name_file', self.$modal).html(' -- ' + text + ' -- ');

            $('.action-save', self.$modal).hide();

            if (Log_Base.permissions.update)
            {
                $('.action-edit', self.$modal).show();
            }
            else
            {
                $('.action-edit', self.$modal).hide();
            }

        }
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
    }
};
Core.addInit(function () {
    Log_Controller.init();
});