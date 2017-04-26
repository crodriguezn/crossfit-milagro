var UserSettings_View = {
    dtOptionsTable: function()
    {
        var html = ''+
            '<div class="table-controls">'+
                '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-view" href="javascript:;" data-original-title="Visualizar"><i class="icon-search3"></i></a> ';
        
        if( UserSettings_Base.permissions.update )
        {
            html +=
                '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit" href="javascript:;" data-original-title="Actualizar"><i class="icon-pencil"></i></a>';
        }
        
        html +=
            '</div>';
    
        return html;
    }
};


