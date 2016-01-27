var Panel_Control_Model = {
    loadDay: function (year, month, fResponse)
    {
        $.ajax({
            url: Core.site_url(Panel_Control_Base.linkx + '/process/load-day'),
            method: 'post',
            dataType: 'json',
            data: {year: year, month: month},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
};