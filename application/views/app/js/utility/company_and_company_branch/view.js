var Company_View = {
};

var Company_Branch_View = {
    dtStateTable: function (data)
    {
        return data == 1 ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
    },
    dtOptionsTable: function ()
    {
        var html = '' +
                '<div class="table-controls">' +
                '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-view" href="javascript:;" data-original-title="Edit entry"><i class="icon-search3"></i></a> ';

        if (Administration_Company_Base.permissions.update_branch)
        {
            html +=
                    '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit" href="javascript:;" data-original-title="Edit entry"><i class="icon-pencil3"></i></a>';
        }

        html +=
                '</div>';


        return html;
    }
};