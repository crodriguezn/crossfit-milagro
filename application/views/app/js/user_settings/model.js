var UserSettings_Model = {
    loadAcount: function (id_user, fResponse)
    {
        $.ajax({
            url: Core.site_url(UserSettings_Base.linkx + '/process/load-acount'),
            method: 'post',
            dataType: 'json',
            data: {id_user: id_user},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    loadComponents: function (fResponse)
    {
        $.ajax({
            url: Core.site_url(UserSettings_Base.linkx + '/process/load-components'),
            method: 'post',
            dataType: 'json',
            data: {},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    loadPais: function (fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(UserSettings_Base.linkx + '/process/load-pais'),
                {},
                fSuccess,
                fFail
                );
    },
    loadProvincia: function (id_pais, fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(UserSettings_Base.linkx + '/process/load-provincia'),
                {id_pais: id_pais},
        fSuccess,
                fFail
                );
    },
    loadCiudad: function (id_provincia, fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(UserSettings_Base.linkx + '/process/load-ciudad'),
                {id_provincia: id_provincia},
        fSuccess,
                fFail
                );
    },
    saveAcount: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(UserSettings_Base.linkx + '/process/save-acount'),
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