var Schedule_Class_View = {
    dtStateTable: function (data)
    {
        return data == 1 ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
    },
    dtOptionsTable: function ()
    {
        var html = '' +
                '<div class="table-controls">' +
                '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-view" href="javascript:;" data-original-title="Visualizar"><i class="icon-search3"></i></a> ';

        if (Schedule_Class_Base.permissions.update)
        {
            html +=
                    '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit" href="javascript:;" data-original-title="Actualizar"><i class="icon-pencil"></i></a> ';

        }
        html +=
                '</div>';

        return html;
    }
};


