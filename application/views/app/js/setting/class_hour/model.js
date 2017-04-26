var ScheduleClass_Model = {
    loadSchedule: function (id_schedule, fResponse)
    {
        $.ajax({
            url: Core.site_url(Schedule_Class_Base.linkx + '/process/load-hour-class'),
            method: 'post',
            dataType: 'json',
            data: {id_schedule: id_schedule},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    saveSchedule: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(Schedule_Class_Base.linkx + '/process/save-hour-class'),
            method: 'post',
            dataType: 'json',
            data: data,
            success: function (data, textStatus, jqXHR)
            {
                fResponse(data);
            }
        });
    }
};