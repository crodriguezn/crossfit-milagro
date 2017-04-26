var Customer_Crossfit_View = {
    dtImagenTable: function (path, title)
    {
        var html = '';
        html += '<a href="' + path + '" class="lightbox" title="' + title + '">';
        html += '<img src="' + path + '" alt="" class="img-media">';
        html += '</a>';
        return html;
    },
    dtDetalleTable: function (birthday, registration, location)
    {
        var html = '<span><strong>Cumpleaños:</strong> ' + (birthday) + '</span>';
        html += '<span><strong>Con nosotros desde:</strong> ' + (registration) + '</span>';
        html += '<span><strong>Localidad:</strong> <a href="javascript:;">' + (location) + '</a></span>';
        return html;
    },
    dtOptionsTable: function ()
    {
        var html = '' +
                '<div class="table-controls">' +
                '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-view" href="javascript:;" data-original-title="Visualizar"><i class="icon-search3"></i></a> ';

        if (Customer_Crossfit_Base.permissions.update)
        {
            html +=
                    '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit" href="javascript:;" data-original-title="Actualizar"><i class="icon-pencil"></i></a> ';

        }
        if (Customer_Crossfit_Base.permissions.access_imc)
        {
            html +=
                    '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-biotipo" href="javascript:;" data-original-title="Control de IMC"><i class="icon-rulers"></i></a>';
        }
        html +=
                '</div>';

        return html;
    }
};


