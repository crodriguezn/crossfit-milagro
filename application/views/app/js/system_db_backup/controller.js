var BackUp_Controller = {
    init: function ()
    {
        var self = this;
        $('.db-backup').click(function () {
            self.backup();
        });
    }
    ,
    backup: function ()
    {
        var accion = $('[name="accion"]').select2('val');
        if (accion == 'NO_DOWNLOAD')
        {
            BackUp_Model.backup(function (oRes)
            {
                if (oRes.isSuccess)
                {
                    Core.Notification.success(oRes.message);
                }
                else
                {
                    Core.Notification.error(oRes.message);
                }

            });
        }
        else if (accion == 'DOWNLOAD')
        {
            $(location).attr('href', Core.site_url('app/system_db_back_up/backup' + '/' + accion));
        }
    }

};


Core.addInit(function () {
    BackUp_Controller.init();
});