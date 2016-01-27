var Report_Model = {
    loadGrupo: function (id_rpte, fResponse)
    {
        $.ajax({
            url: Core.site_url(Reporte_Base.linkx + '/process/load-grupo'),
            method: 'post', 
            dataType: 'json',
            data: {id_rpte: id_rpte},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    
};