$.fn.modal.Constructor.prototype.enforceFocus = function () {
};

var Schedule_Class_Controller = {
    init: function ()
    {
        var self = this;
        self.$table = $('.datatable table');


        if (!Schedule_Class_Base.permissions.create) {
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
            sAjaxSource: Core.site_url(Schedule_Class_Base.linkx + "/process/list-hour-class"),
            fnServerParams: function (aoData)
            {

                Core.Loading.wait(true, $('tbody', $(this)));
            },
            aoColumnDefs: [
                {sClass: "center", "aTargets": [0]},
                {sClass: "center", "aTargets": [1]},
                {sClass: "center", "aTargets": [2]},
                {sClass: "center", "aTargets": [3]},
                {
                    aTargets: [2], mRender: function (data, type, row)
                    {
                        return '<input type="hidden" class="dt-col-state" value="' + (data) + '" />';
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

                    var html = Schedule_Class_View.dtStateTable(data);

                    var $html = $(html);

                    $(this).after($html);
                });

                // aTargets: [3]
                $('.dt-col-option').each(function () {
                    var data = $(this).val();

                    var html = Schedule_Class_View.dtOptionsTable();
                    var $html = $(html);

                    $('.dt-action-view', $html).click(function () {
                        Modal_ScheduleClass.open(data, true);
                    });
                    if (Schedule_Class_Base.permissions.update)
                    {
                        $('.dt-action-edit', $html).click(function () {
                            Modal_ScheduleClass.open(data);
                        });
                    }
                    $(this).after($html);
                });
                $('.tip').tooltip();
            }

        });

        if (Schedule_Class_Base.permissions.create)
        {
            $('.action-popup-new').click(function () {
                Modal_ScheduleClass.open();
            });
        }
        $('[action="action-refresh"]').click(function () {
            self.refresDataTable(false);
        });

        Modal_ScheduleClass.init();

    },
    refresDataTable: function (isDraw /*=true*/)
    {
        var self = this;

        setInterval(self.$table.dataTable().fnDraw(isDraw), 3000);
    }

};

Modal_ScheduleClass = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal');

        $('button.action-save', self.$modal).click(function () {
            if (Schedule_Class_Base.permissions.update || Schedule_Class_Base.permissions.create)
            {
                self.actionSave();
            }
        });

        $('button.action-edit', self.$modal).click(function () {
            if (Schedule_Class_Base.permissions.update)
            {
                self.formReadOnly(false);
                self.formType('edit');
            }
        });



        self.$modal.on("show.bs.modal", function () {
            //alert('show form');
        });

        self.$modal.on("hidden.bs.modal", function () {
            self.formReset();
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
        self.dataDefault();
        self.errorClear();
        self.formReadOnly(false);
        self.formLoading('none');

    },
    dataDefault: function ()
    {
        this.data(Schedule_Class_Base.schedule_class_form_default);
    },
    errorClear: function ()
    {
        this.formError(Schedule_Class_Base.schedule_class_form_default);
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
        } else if (type == 'edit')
        {
            $('.modal-title span', self.$modal).html('Editar');

            $('.action-save', self.$modal).show();
            $('.action-edit', self.$modal).hide();

            self.formReadOnly(false);

        } else if (type == 'view')
        {
            $('.modal-title span', self.$modal).html('Ver');

            $('.action-save', self.$modal).hide();
            if (Schedule_Class_Base.permissions.update)
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
        $('[name="start_hour"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="final_hour"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="isActive"]', self.$modal).prop('disabled', isFormReadOnly);

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
    open: function (id_schedule/*=0*/, isView/*=false*/)
    {
        var self = this;

        id_schedule = typeof id_schedule == 'undefined' ? 0 : id_schedule;
        isView = typeof isView == 'boolean' ? isView : false;

        self.formReset();
        //self.$modal.modal('show');
        self.formLoading('load');
        self.formReadOnly(true);

        if (id_schedule == 0)
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
            self.dataLoad(id_schedule);
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
                    //self.initLoadComponents(function () {
                    fLoad();
                    //});
                })
                .modal('show');
    },
    dataLoad: function (id_schedule)
    {
        var self = this;
        ScheduleClass_Model.loadSchedule(id_schedule, function (res) {
            if (!res.isSuccess)
            {
                Core.Notification.error(res.message);
                self.close();
                return;
            }
            self.data(res.forms.schedule);
        }, function () {
            self.close();
        });
    },
    data: function (data/*=UNDEFINED*/)
    {
        var self = this;

        if (data)
        {
            var id_form = data.id_form.value;
            var id_schedule = data.id_schedule.value;
            var start_hour = data.start_hour.value;
            var final_hour = data.final_hour.value;
            var isActive = (data.isActive.value == 0) ? false : true;
            $('[name="id_form"]', self.$modal).val(id_form);
            $('[name="id_schedule"]', self.$modal).val(id_schedule);
            $('[name="start_hour"]', self.$modal).val(start_hour);
            $('[name="final_hour"]', self.$modal).val(final_hour);
            $('[name="isActive"]', self.$modal).prop('checked', isActive);
            $.uniform.update();
            return;
        }
        data = {
            id_form: $('[name="id_form"]', self.$modal).val(),
            id_schedule: $('[name="id_schedule"]', self.$modal).val(),
            start_hour: $('[name="start_hour"]', self.$modal).val(),
            final_hour: $('[name="final_hour"]', self.$modal).val(),
            isActive: $('[name="isActive"]', self.$modal).prop('checked') ? 1 : 0
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
        ScheduleClass_Model.saveSchedule(data, function (res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
                self.close();
                Schedule_Class_Controller.refresDataTable(false);
            } else
            {
                Core.Notification.error(res.message);
                self.formLoading('none');
                self.formError(res.forms.schedule);
                self.formReadOnly(false);
            }

        });
    }
};

Core.addInit(function () {
    Schedule_Class_Controller.init();
});