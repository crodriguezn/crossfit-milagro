$.fn.modal.Constructor.prototype.enforceFocus = function () {
};


var Binnacle_Controller = {
    //************************************************
    // FUNCTION **************************************
    //************************************************
    init: function ()
    {
        var self = this;
        self.$table = $('.datatable table');

        var cboAccion = self.getValueFilterByElement('accion');

        
        if (!Binnacle_Base.permissions.create) {
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
            sAjaxSource: Core.site_url(Binnacle_Base.linkx + "/process/list-binnacle"),
            fnServerParams: function (aoData)
            {
                Core.Loading.wait(true, $('tbody', $(this)));
                aoData.push(
                            {name: "accion", value: cboAccion},
                            {name: "date_begin", value: $("[name='date_begin']").val()},
                            {name: "date_end", value: $("[name='date_end']").val()}
                        );
            },
            aoColumnDefs: [
                {sClass: "center", "aTargets": [0]},
                {sClass: "center", "aTargets": [1]},
                {sClass: "center", "aTargets": [2]},
                {sClass: "center", "aTargets": [3]},
                {sClass: "center", "aTargets": [4]},
                {
                    aTargets: [0], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-action" value="' + (data) + '"/>';
                    }
                },
                {
                    aTargets: [4], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-option" value="' + (data) + '"/>';
                    }
                }
            ],
            fnDrawCallback: function ()
            {
                Core.Loading.wait(false, $('tbody', $(this)));
                // aTargets: [0]
                $('.dt-col-action').each(function () {
                    var data = $(this).val();

                    var html = Binnacle_View.dtActionTable(data);
                    var $html = $(html);

                    $(this).after($html);
                });

                // aTargets: [3]
                $('.dt-col-option').each(function () {
                    var data = $(this).val();

                    var html = Binnacle_View.dtOptionsTable();
                    var $html = $(html);

                    $('.dt-action-view', $html).click(function () {
                        Binnacle_Modal.open(data, true);
                    });

                    $(this).after($html);
                });
                $('.tip').tooltip();
            }
        });

        $('.action-popup-new').click(function () {
            Binnacle_Modal.open();
        });
        
        $('[action="action-refresh"]').click(function () {
            self.refresDataTable(false);
        });


        $('[name="accion"]').multiselect({
            enableClickableOptGroups: true, buttonWidth: '100%',
            buttonText: function (options, select) {
                if (options.length === 0) {
                    return 'Nada Seleccionado';
                }
                else if (options.length > 3) {
                    return options.length + ' Seleccionado!';
                }
                else {
                    var labels = [];
                    options.each(function () {
                        if ($(this).attr('label') !== undefined) {
                            labels.push($(this).attr('label'));
                        }
                        else {
                            labels.push($(this).html());
                        }
                    });
                    return labels.join(' , ') + '';
                }
            },
            onChange: function (option, checked, select)
            {
                cboAccion = self.getValueFilterByElement('accion');
                self.refresDataTable(true);
            }
        });
        
        $('[name="date_begin"]').change(function () {
            self.refresDataTable(true);
        });

        $('[name="date_end"]').change(function () {
            self.refresDataTable(true);
        });


        Binnacle_Modal.init();
    },
    refresDataTable: function (isDraw /*=true*/)
    {
        var self = this;

        setInterval(self.$table.dataTable().fnDraw(isDraw), 3000);
    },
    getValueFilterByElement: function (element)
    {
        var valor = [];
        $('[name="' + element + '"] option:selected').each(function () {
            valor.push($(this).attr('value'));
        });
        return valor;
    }
};

var Binnacle_Modal = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal');

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
    //=============================================================
    //=============================================================

    open: function (id_binnacle/*=0*/, isView/*=false*/)
    {
        var self = this;

        id_binnacle = typeof id_binnacle == 'undefined' ? 0 : id_binnacle;
        isView = typeof isView == 'boolean' ? isView : false;

        self.$modal.modal('show');
        self.dataLoad(id_binnacle, isView);
    },
    dataLoad: function (id_binnacle, isView)
    {
        var self = this;

        self.formReset();

        self.formLoading('load');
        self.formType('new');
        self.formReadOnly(true);

        if (id_binnacle == 0)
        {
            self.formLoading('none');

            if (!isView)
            {
                self.formReadOnly(false);
            }
        }
        else
        {
            Binnacle_Model.loadBinnacle(id_binnacle, function (res) {
                if (!res.isSuccess)
                {
                    Core.Notification.error(res.message);
                    self.close();
                    return;
                }

                self.data(res.forms.binnacle);
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
            var id_binnacle = form_data.id_binnacle.value;
            var url         = form_data.url.value;
            var username    = form_data.username.value;
            var info        = form_data.info.value;
            var date_time   = form_data.date_time.value;
            var action      = form_data.action.value;
            var time        = form_data.time.value;
            

            $('[name="id_binnacle"]', self.$modal).val(id_binnacle);
            $('#url', self.$modal).html(url);
            $('#username', self.$modal).html(username);
            $('#info', self.$modal).html(info);
            $('#date_time', self.$modal).html(date_time);
            $('#action', self.$modal).html(Binnacle_View.dtActionTable(action));
            $('#time', self.$modal).html('<i class="icon-clock"></i> ' + time);

            $.uniform.update();

            return;
        }

        form_data = {
            id_binnacle: $('[name="id_binnacle"]', self.$modal).val()
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
        this.data(Binnacle_Base.binnacle_form_default);
    },
    errorClear: function ()
    {
        this.formError(Binnacle_Base.binnacle_form_default);
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

            if (Binnacle_Base.permissions.update)
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
    }
};




Core.addInit(function () {
    Binnacle_Controller.init();
});