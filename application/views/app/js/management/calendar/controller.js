$.fn.modal.Constructor.prototype.enforceFocus = function () {
};
var Calendar_Controller = {
//************************************************
// FUNCTION **************************************
//************************************************
    init: function ()
    {

        var self = this;
        self.$calendar = $('.fullcalendar');
        self.$modal_view_info = $('#form_modal_view_info');
        self.$modal_new_acti = $('#form_modal_new_activity');
        self.$calendar.fullCalendar({

            header: {
                left: 'prev,next,today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                prev: '<i class="icon-previous"></i>',
                next: '<i class="icon-next"></i>',
                today: 'Hoy',
                month: 'Mes',
                agendaWeek: 'Semana',
                agendaDay: 'Día'
            },
            allDayText: "Todo el Día",
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
                // for agendaWeek and agendaDay
                agenda: .5,

                // for all other views
                '': 1.0
            },
            //buttonIcons: false, // show the prev/next text
            //weekNumbers: true,
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            startParam: 'start',
            endParam: 'end',
            selectable: true,
            selectHelper: true,
            minTime: 5,
            maxTime: 23,
            /*viewDisplay: function (view) {
             alert('The new title of the view is ' + view.title);
             },*/
            viewRender: function (view, element)
            {
                console.log(view);
                console.log(element);
            },
            loading: function (isLoading, view)
            {
                if (isLoading == true)
                {
                    Core.Loading.wait(true, self.$calendar);
                } else
                {
                    Core.Loading.wait(false, self.$calendar);
                }

            },
            eventClick: function (calEvent, jsEvent, view) {
                //alert(calEvent.title, jsEvent, view);
                $('.activity-titulo', self.$modal_view_info).html(calEvent.title);
                $('.activity-fecha', self.$modal_view_info).html(calEvent.fecha);
                $('.activity-inicio', self.$modal_view_info).html(calEvent.inicio);
                $('.activity-fin', self.$modal_view_info).html(calEvent.fin);
                $('.activity-entrenador', self.$modal_view_info).html(calEvent.entrenador);
                self.$modal_view_info.modal('show');
                //calEvent.title = "CLICKED!";

                //self.$calendar.fullCalendar('updateEvent', calEvent);
                /*$('#fc_edit').click();
                 $('#edit').val(calEvent.id);
                 $('#elim').val(calEvent.id);
                 document.getElementById("organizador").innerHTML = (calEvent.organizador);
                 document.getElementById("titulo").innerHTML = (calEvent.title);
                 document.getElementById("lugar").innerHTML = (calEvent.lugar);
                 document.getElementById("fecha").innerHTML = (calEvent.fecha);
                 document.getElementById("inicio").innerHTML = (calEvent.inicio);
                 document.getElementById("fin").innerHTML = (calEvent.fin);
                 categoryClass = $("#event_type").val();
                 
                 $(".antosubmit2").on("click", function () {
                 calEvent.title = $("#title2").val();
                 calEvent.start = $("#descr2").val();
                 calendar.fullCalendar('updateEvent', calEvent);
                 $('.antoclose2').click();
                 });
                 calendar.fullCalendar('unselect');*/
            },
            eventSources: [

                // your event source
                {
                    url: Calendar_Base.linkx + '/process/load-cliente-crossfit', // use the `url` property
                    color: '#D0A9F5', // an option!
                    textColor: 'black'  // an option!
                },
                {
                    url: Calendar_Base.linkx + '/process/load-programacion-clases', // use the `url` property
                    color: '#81F7F3', // an option!
                    textColor: 'black'  // an option!
                }

                // any other sources...

            ],
            dayClick: function (date, allDay, jsEvent, view) {

                if (allDay) {
                    alert('Clicked on the entire day: ' + date);
                } else {
                    alert('Clicked on the slot: ' + date);
                }

                alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

                alert('Current view: ' + view.name);

                // change the day's background color just for fun
                $(this).css('background-color', 'red');

            },
            /*eventResize: function (event, dayDelta, minuteDelta, revertFunc) {
             
             alert(
             "The end date of " + event.title + "has been moved " +
             dayDelta + " days and " +
             minuteDelta + " minutes."
             );
             
             if (!confirm("is this okay?")) {
             revertFunc();
             }
             
             }*/


        });
        self.$calendar.fullCalendar('refresh');

        $('[action="action-refresh"]').click(function () {
            //alert('entro');
            //self.$calendar.fullCalendar('refetchEvents'); 
            //self.$calendar.fullCalendar('refresh'); 
            //self.$calendar.fullCalendar('render');
            window.location.href = Calendar_Base.link;
        });

        $('.action-popup-new').click(function () {
            //Modal_ScheduleClass.open();
            var d = self.$calendar.fullCalendar('getDate');
            alert("The current date of the calendar is " + d);
            self.$modal_new_acti
                    .off('shown.bs.modal')
                    .on('shown.bs.modal', function () {
                        //self.initLoadComponents(function () {
                        //fLoad();
                        //});
                    })
                    .modal('show');
        });

    }


};
Core.addInit(function () {
    Calendar_Controller.init();
});