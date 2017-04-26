var SettingParam_Model = {
    loadSettingParam: function (fResponse)
    {
        $.ajax({
            url: Core.site_url(SettingParam_Base.linkx + '/process/load-param'),
            method: 'post',
            dataType: 'json',
            data: {},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    saveSettingParam: function (data, fResponse)
    {
        $.ajax({
            method: 'post',
            dataType: 'json',
            url: Core.site_url(SettingParam_Base.linkx + '/process/save-param'),
            data: data,
            //use contentType, processData for sure.
            contentType: false,
            processData: false,
            beforeSend: function () {
                //Company_Controller.beforeProcessBar();
                //console.log('Hold on...');
            },
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                //console.log(myXhr);
//                if (myXhr.upload) {
//                    myXhr.upload.addEventListener('progress', Company_Controller.uploadProgressBar, false);
//                }
                return myXhr;
            },
            success: function (data, textStatus, jqXHR) {
                fResponse(data);
            },
            error: function () {
                //$(".modal .ajax_data").html("<pre>Sorry! Couldn't process your request.</pre>");// 
                //$('#done').hide();
                //console.log('error');
                Core.Notification.error('Ocurrio un error en el envio');
            }
        });
    }
};
