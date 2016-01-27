var Log_Model = {
    loadFile: function (path, fResponse)
    {
        $.ajax({
            url: Core.site_url(Log_Base.linkx + '/process/load-file'),
            method: 'post',
            dataType: 'json',
            data: {path: path},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    }
};