var Calendar_View = {
    dtActionTable: function( data )
    {
        var html = '';
        if(data==0)
        {
            html = '<span class="label label-default"><i class="icon-question4"></>&nbsp; Default</span>';
        }
        if(data==1)
        {
            html = '<span class="label label-primary"><i class="icon-bug"></i>&nbsp; Debug</span>';
        }
        if(data==2)
        {
            html = '<span class="label label-success"><i class="icon-plus-circle"></i>&nbsp; Insert</span>';
        }
        if(data==3)
        {
            html = '<span class="label label-warning"><i class="icon-pencil"></i>&nbsp; Update</span>';
        }
        if(data==4)
        {
            html = '<span class="label label-danger"><i class="icon-remove"></i>&nbsp; Delete</span>';
        }
        return html;
    },
    dtOptionsTable: function()
    {
        var html = ''+
            '<div class="table-controls">';
        if( Binnacle_Base.permissions.view)
        {
            html += '<a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-view" href="javascript:;" data-original-title="Visualizar"><i class="icon-search3"></i></a>';
        }
        html +=
            '</div>';
    
        return html;
    }
};