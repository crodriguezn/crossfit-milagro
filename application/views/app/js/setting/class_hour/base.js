var Schedule_Class_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    schedule_class_form_default: $.parseJSON('<?php echo json_encode($schedule_class_form_default); ?>'),
};

/* --VARIABLE DE ENTIDAD--  */
var eSchedule = function ()
{
    var self = this;
    var start_hour, final_hour, isActive, id_schedule;
    self.init = function (data/*=undefined*/, useDefault/*=false*/)/*contrutor de la entidad*/
    {
        if (useDefault)
        {
            data = Schedule_Class_Base.schedule_class_form_default;
        }
        self.id_schedule = data.id_schedule.value;
        self.start_hour = data.start_hour.value;
        self.final_hour = data.final_hour.value;
        self.isActive = data.isActive.value;

    };
    function __construct()
    {
        self.init(Schedule_Class_Base.schedule_class_form_default, true);
    }
    ;
    __construct();
};
