var Calendar_Model = {
    loadBinnacle: function (id_binnacle, fResponse)
    {
        $.ajax({
            url: Core.site_url(Binnacle_Base.linkx + '/process/load-binnacle'),
            method: 'post',
            dataType: 'json',
            data: {id_binnacle: id_binnacle},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    }
};