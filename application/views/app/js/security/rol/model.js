var Rol_Model = {
    loadRol: function (id_rol, fResponse)
    {
        $.ajax({
            url: Core.site_url(Rol_Base.linkx + '/process/load-rol'),
            method: 'post',
            dataType: 'json',
            data: {id_rol: id_rol},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    saveRol: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(Rol_Base.linkx + '/process/save-rol'),
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