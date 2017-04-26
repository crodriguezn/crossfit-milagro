var ClassScheduling_Model = {
    listProgramacionClass: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(ClassScheduling_Base.linkx + '/process/list-programacion-clases'),
            method: 'get',
            dataType: 'json',
            data: data,
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });

    },
    loadProgramacionClass: function (start_day, fResponse)
    {
        $.ajax({
            url: Core.site_url(ClassScheduling_Base.linkx + '/process/load-programacion-clases'),
            method: 'post',
            dataType: 'json',
            data: {start_day: start_day},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    saveProgramacion: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(ClassScheduling_Base.linkx + '/process/save-programacion-clases'),
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