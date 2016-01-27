var View_Module = {
    dtStateTable: function( data )
    {
        return data==1 ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
    },
    dtOptionsTable: function()
    {
        var html = ''+
            '<div class="table-controls">'+
                '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-view" href="javascript:;" data-original-title="Ver"><i class="icon-search3"></i></a> ';
        
        /*if( oPermissions.canEdit )
        {*/
            html +=
                '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit" href="javascript:;" data-original-title="Editar"><i class="icon-pencil"></i></a>';
        //}
        
        html +=
            '</div>';
    
        return html;
    },
    trPermission: function()
    {
        return ""+
            '<tr>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '<td>'+
                    '<div class="table-controls">'+
                        '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit-permission" href="javascript:;" data-original-title="Editar"><i class="icon-pencil"></i></a> '+
                        //'<a title="" class="btn btn-danger btn-icon btn-xs tip dt-action-remove-permission" href="javascript:;" data-original-title="Edit entry"><i class="icon-remove"></i></a>'+
                    '</div>'+
                    '<div class="hide">'+
                        '<input type="text" name="permission_id" value="" />'+
                        '<input type="text" name="permission_name" value="" />'+
                        '<input type="text" name="permission_name_key" value="" />'+
                        '<input type="text" name="permission_description" value="" />'+
                    '</div>'+
                '</td>'+
            '</tr>';
    },
    buildTableModules: function( data )
    {
        var html = "";
        
        if( data.length > 0 )
        {
            $.each(data, function( index, value ){
                
            });
        }
        
        return html;
    },
    buildTableModulesTR: function( data )
    {
        
    },
    buildTableModulesTD: function( data )
    {
        
    },
    trRol: function()
    {
        return ""+
            '<tr>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '<td>'+
                    '<div class="table-controls">'+
                        '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit-permission" href="javascript:;" data-original-title="Edit entry"><i class="icon-pencil"></i></a> '+
                        //'<a title="" class="btn btn-danger btn-icon btn-xs tip dt-action-remove-permission" href="javascript:;" data-original-title="Edit entry"><i class="icon-remove"></i></a>'+
                    '</div>'
                '</td>'+
            '</tr>';
    },
};