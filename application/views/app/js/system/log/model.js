var Log_Model = {
    loadFile: function (path, fResponse)
    {
        $.ajax({
            url: Core.site_url(Log_Base.linkx + '/process/load-file'),
            method: 'post',
            dataType: 'json',
            cache: false,
            data: {path: path},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    loadFileT: function (path, fResponse)
    {
        $.ajax({
            url: Core.site_url(Log_Base.linkx + '/process/load-file-t'),
            method: 'post',
            data: {path: path},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    }
};