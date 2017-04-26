var Activity_View = {
    actionTable: function (action, ip, browser)
    {
        var html = '';
        if (action == 0)
        {
            //html = '<span class="label label-default"><i class="icon-question4"></>Default</span>';
            html = 'Acción desconocida desde la IP ' + ip + ' y Navegador: ' + browser;
        }
        if (action == 1)
        {
            //html = '<span class="label label-primary"><i class="icon-bug"></i>Debug</span>';
            html = 'Inicio sesión desde la IP ' + ip + ' y Navegador: ' + browser;
        }
        if (action == 2)
        {
            //html = '<span class="label label-success"><i class="icon-plus-circle"></i>Insert</span>';
            html = 'Inserto un nuevo registro desde la IP ' + ip + ' y Navegador: ' + browser;
        }
        if (action == 3)
        {
            //html = '<span class="label label-warning"><i class="icon-pencil"></i>Update</span>';
            html = 'Actualizo un registro desde la IP ' + ip + ' y Navegador: ' + browser;
        }
        if (action == 4)
        {
            //html = '<span class="label label-danger"><i class="icon-remove"></i>Delete</span>';
            html = 'Elimino un registro desde la IP ' + ip + ' y Navegador: ' + browser;
        }
        return html;
    }
};