$.fn.modal.Constructor.prototype.enforceFocus = function () {
};
var ClassScheduling_Controller = {
//************************************************
// FUNCTION **************************************
//************************************************
    init: function ()
    {

        var self = this;

        self.$calendar = $('.fullcalendar');
        self.$modal_view_info = $('#form_modal_view_info');
        //self.$modal_new_acti = $('#form_modal_new_activity');

        if (!ClassScheduling_Base.permissions.create) {
            $('.panel-toolbar').hide();
        }

        self.$calendar.fullCalendar({
            header: {
                left: 'prev,next,today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,basicWeek,basicDay'
            },
            buttonText: {
                prev: '<i class="icon-previous"></i>',
                next: '<i class="icon-next"></i>',
                today: 'Hoy',
                month: 'Mes',
                agendaWeek: 'Semana',
                agendaDay: 'Día',
                basicWeek: 'Básico Semana',
                basicDay: 'Básico Día'
            },
            allDayText: "Todo Día",
            firstDay: 1,
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            ,
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul',
                'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
            ,
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles',
                'Jueves', 'Viernes', 'Sabado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie',
                'Jue', 'Vie', 'Sab'],
            weekNumberTitle: "S",

            dragOpacity: {
                agenda: .5,
                '': 1.0
            },
            //buttonIcons: false, // show the prev/next text
            //weekNumbers: true,
            //navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            startParam: 'start',
            endParam: 'end',
            //selectable: true,
            //selectHelper: true,
            minTime: 5,
            maxTime: 23,
            defaultView: 'agendaWeek',
            viewRender: function (view, element)
            {
                //console.log(view);
                //console.log(element);
                //alert(view.name);
                if (view.name == "month") {


                }
                self.refreshCalendar();
            },
            loading: function (isLoading, view)
            {
                if (isLoading == true)
                {
                    $('.action-popup-new').hide();
                    Core.Loading.wait(true, self.$calendar);

                } else
                {
                    $('.action-popup-new').show();
                    Core.Loading.wait(false, self.$calendar);
                }
            },
            eventClick: function (calEvent, jsEvent, view) {
                if (view.name == 'agendaWeek' || view.name == 'agendaDay' || view.name == 'basicWeek' || view.name == 'basicDay')
                {
                    $('.activity-titulo', self.$modal_view_info).html(calEvent.title);
                    $('.activity-fecha', self.$modal_view_info).html(calEvent.fecha);
                    $('.activity-inicio', self.$modal_view_info).html(calEvent.inicio);
                    $('.activity-fin', self.$modal_view_info).html(calEvent.fin);
                    $('.activity-entrenador', self.$modal_view_info).html(calEvent.entrenador);
                    self.$modal_view_info.modal('show');
                }
                if (view.name == 'month')
                {
                    console.log(calEvent);
                    console.log(jsEvent);
                }
            },
            viewDisplay: function (view) {
                if (view.name == 'month') {
                    //Asignamos eventos para Vista Mes
                    //alert('Mes');

                }
            },

            eventSources: [
                {
                    events: function (start, end, callback)
                    {
                        var viewEvent = '';
                        var view = self.$calendar.fullCalendar('getView');

                        viewEvent = view.name;

                        var data = {

                            start: start.getTime(),
                            end: end.getTime(),
                            viewEvent:viewEvent
                        };
                        ClassScheduling_Model.listProgramacionClass(data, function (res) {
                            if (!res.isSuccess)
                            {
                                Core.Notification.error(res.message);
                                return;
                            }
                            var events = [];
                            $(res.aaData).each(function () {
                                events.push(this);
                            });
                            callback(events);
                        });
                    },
                    color: '#D0A9F5', // an option!
                    textColor: 'black'  // an option!
                }
            ],
            eventRender: function (event, element, view) {


                if (view.name == 'month')
                {
                    //var el = element.html();
                    //element.html("abierto");
                    //element.attr(event.tip); 
                }
            },
            dayClick: function (date, allDay, jsEvent, view)
            {
                if (ClassScheduling_Base.permissions.update)
                {
                    /*if (allDay)
                     {
                     alert('Clicked on the entire day: ' + date);
                     } else
                     {
                     alert('Clicked on the slot: ' + date);
                     }
                     
                     alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                     
                     alert('Current view: ' + view.name);
                     
                     // change the day's background color just for fun
                     $(this).css('background-color', 'red');*/

                    //console.log(moment("Sunday, February 28, 2010").format('MM/DD/YYYY'))
                    //console.log(moment(date).format('YYYY/MM/DD'))
                    //console.log(date);
                    //self.$calendar.fullCalendar('changeView', 'agendaDay');
                    //self.$calendar.fullCalendar('gotoDate', date);
                    
                    ClassScheduling_Modal.open(moment(date).format('YYYY-MM-DD'), true);
                }
            }
        });
        self.$calendar.fullCalendar('refresh');

        $('[action="action-refresh"]').click(function () {
            //window.location.href = ClassScheduling_Base.link;
            self.refreshCalendar();
        });

        $('[action="action-print"]').click(function () {
            //window.location.href = ClassScheduling_Base.link;
            window.print();
        });

        if (ClassScheduling_Base.permissions.create)
        {
            $('.action-popup-new').click(function () {
                //Modal_ScheduleClass.open();
                //var d = self.$calendar.fullCalendar('getDate');
                //alert("The current date of the calendar is " + d);
                /*self.$modal_new_acti
                 .off('shown.bs.modal')
                 .on('shown.bs.modal', function () {
                 //self.initLoadComponents(function () {
                 //fLoad();
                 //});
                 })
                 .modal('show');*/
                ClassScheduling_Modal.open();
            });
        }

        ClassScheduling_Modal.init();
    },
    refreshCalendar: function ()
    {
        var self = this;
        self.$calendar.fullCalendar('refetchEvents');
    }

};

ClassScheduling_Modal = {
    init: function ()
    {
        var self = this;

        self.$modal = $('#form_modal_new_activity');

        $('button.action-save', self.$modal).click(function () {
            if (ClassScheduling_Base.permissions.create || ClassScheduling_Base.permissions.update)
            {
                self.actionSave();
            }
        });

        $('button.action-edit', self.$modal).click(function () {
            if (ClassScheduling_Base.permissions.update)
            {
                self.formReadOnly(false);
                self.formType('edit');
            }
        });

        $('[name="id_hour_all"]', self.$modal).on('change', function () {
            $('input[name="id_hours[]"]', self.$modal).prop('checked', $(this).prop("checked"));

            $('input[name="id_hours[]"]', self.$modal).each(function (index)
            {
                var $td = $(this, self.$modal).closest('tr');
                if (this.checked)
                {
                    $td.css("background-color", "#ECF8E0");
                } else
                {
                    $td.css("background-color", "#FFFFFF");
                }
            });

            $.uniform.update();
        });

        $('[name="id_hours[]"]').on('change', function () {
            // From the other examples
            var $td = $(this, self.$modal).closest('tr');
            if (this.checked)
            {
                $td.css("background-color", "#ECF8E0");
            } else
            {
                $td.css("background-color", "#FFFFFF");
            }
            $.uniform.update();
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
        var self = this;
        self.data(ClassScheduling_Base.class_scheduling_form_default);
        $('input[name="id_hours[]"]', self.$modal).prop('checked', true);

        $('input[name="id_hours[]"]', self.$modal).each(function (index)
        {
            var $td = $(this, self.$modal).closest('tr');
            if (this.checked)
            {
                $td.css("background-color", "#ECF8E0");
            } else
            {
                $td.css("background-color", "#FFFFFF");
            }
        });

        $.uniform.update();
    },
    errorClear: function ()
    {
        this.formError(ClassScheduling_Base.class_scheduling_form_default);
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
            if (ClassScheduling_Base.permissions.update)
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

        $('[name="name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="start_day"]', self.$modal).prop('readonly', isFormReadOnly);
        $('[name="isActive"]', self.$modal).prop('disabled', isFormReadOnly);
        $('[name="id_hours[]"]', self.$modal).prop('disabled', isFormReadOnly);
        $('[name="id_hour_all"]', self.$modal).prop('disabled', isFormReadOnly);
        $('select[name="id_coach"]', self.$modal).select2('enable', !isFormReadOnly);
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

        var $class_error = $('.class-error', self.$modal);

        $class_error.removeClass('has-error');
        $('.label-danger', $class_error).html('').hide();

        for (var field_name in data)
        {
            var $class_error = $('[name="' + (field_name) + '"]', self.$modal).closest('.class-error');
            if (!$.isEmptyObject(data[field_name].error))
            {
                $class_error.addClass('has-error');
                $('.label-danger', $class_error).html(data[field_name].error).show();
            }
        }
    },
    //=============================================================
    //=============================================================

    open: function (date/*=0*/, isView/*=false*/)
    {
        var self = this;


        date = typeof date == 'undefined' ? 0 : date;
        isView = typeof isView == 'boolean' ? isView : false;

        self.$modal.modal('show');
        self.dataLoad(date, isView);
    },
    dataLoad: function (date, isView)
    {
        var self = this;

        self.formReset();

        self.formLoading('load');
        self.formType('new');
        self.formReadOnly(true);
        $('[name="start_day"]', self.$modal).val(date);
        if (date == 0)
        {
            self.formLoading('none');

            if (!isView)
            {
                self.formReadOnly(false);
            }
        } else
        {
            ClassScheduling_Model.loadProgramacionClass(date, function (res) {
                if (!res.isSuccess)
                {
                    Core.Notification.error(res.message);
                    self.close();
                    return;
                }

                self.data(res.forms.programacion_clases);
                $('[name="start_day"]', self.$modal).val(date);
                self.formLoading('none');
                if (isView)
                {
                    self.formType('view');
                } else
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
            var id_form = form_data.id_form.value;
            var id_schedule = form_data.id_schedule.value;
            var name = form_data.name.value;
            var start_day = form_data.start_day.value;
            var isActive = (form_data.isActive.value == 0) ? false : true;

            $('[name="id_form"]', self.$modal).val(id_form);
            $('[name="id_schedule"]', self.$modal).val(id_schedule);
            $('[name="name"]', self.$modal).val(name);
            $('[name="start_day"]', self.$modal).val(start_day);
            $('[name="isActive"]', self.$modal).prop('checked', isActive);

            self.arrData(form_data.arrData.value);

            $.uniform.update();

            return;
        }

        form_data = {
            id_form: $('[name="id_form"]', self.$modal).val(),
            id_schedule: $('[name="id_schedule"]', self.$modal).val(),
            name: $('input[name="name"]', self.$modal).val(),
            start_day: $('input[name="start_day"]', self.$modal).val(),
            isActive: $('[name="isActive"]', self.$modal).prop('checked') ? 1 : 0,
            arrData: self.arrData()
        };

        return form_data;
    },
    arrData: function (data_values/*=UNDEFINED*/)
    {
        var self = this;


        if (data_values)
        {
            // modules
            $.each(data_values, function (index, value) {
                $('input[name="id_hours[]"][_id_hour="' + (value.id_hour) + '"]', self.$modal).prop('checked', value.isActive == true ? 1 : 0);
                var $td = $('input[name="id_hours[]"][_id_hour="' + (value.id_hour) + '"]', self.$modal).closest('tr');
                if (value.isActive == true)
                {
                    $td.css("background-color", "#ECF8E0");
                } else
                {
                    $td.css("background-color", "#FFFFFF");
                }

                $('select[name="id_coach"][_id_coach="' + (value.id_hour) + '"]', self.$modal).select2('val', value.id_coach);
            });

            return;
        }

        data_values = [];

        $('table[class="table"] tbody tr', self.$modal).each(function (index)
        {
            var id_coach, id_hour, isActive;
            $(this).children("td").each(function (index2)
            {
                switch (index2)
                {
                    case 0:
                        id_coach = $('[name="id_coach"]', this).select2('val');
                        break;
                    case 3:
                        isActive = $('[name="id_hours[]"]', this).prop('checked') ? 1 : 0;
                        id_hour = $('[name="id_hours[]"]', this).attr('_id_hour');
                        break;
                }
                //$(this).css("background-color", "#ECF8E0");
            });
            //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
            data_values.push({id_coach: id_coach, isActive: isActive, id_hour: id_hour});
        });

        return data_values;
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

        ClassScheduling_Model.saveProgramacion(data, function (data) {
            if (data.isSuccess)
            {
                Core.Notification.success(data.message);
                self.close();
                ClassScheduling_Controller.refreshCalendar();
            } else
            {
                Core.Notification.error(data.message);
                self.formLoading('none');
                self.formError(data.forms.programacion_clases);
                self.formReadOnly(false);
            }
        });
    }

};

Core.addInit(function () {
    ClassScheduling_Controller.init();
});