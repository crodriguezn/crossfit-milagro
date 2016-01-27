var UProfile_Model = {
    loadProfile: function (fResponse)
    {
        $.ajax({
            url: Core.site_url(UserProfile_Base.linkx + '/process/load-profile'),
            method: 'post',
            dataType: 'json',
            data: {},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    saveProfile: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(UserProfile_Base.linkx + '/process/save-profile'),
            method: 'post',
            dataType: 'json',
            data: data,
            success: function (data, textStatus, jqXHR)
            {
                fResponse(data);
            }
        });
    },
    loadComponents: function (fResponse)
    {
        $.ajax({
            url: Core.site_url(UserProfile_Base.linkx + '/process/load-components'),
            method: 'post',
            dataType: 'json',
            data: {},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    loadPais: function (fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(UserProfile_Base.linkx + '/process/load-pais'),
                {},
                fSuccess,
                fFail
                );
    },
    loadProvincia: function (id_pais, fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(UserProfile_Base.linkx + '/process/load-provincia'),
                {id_pais: id_pais},
        fSuccess,
                fFail
                );
    },
    loadCiudad: function (id_provincia, fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(UserProfile_Base.linkx + '/process/load-ciudad'),
                {id_provincia: id_provincia},
        fSuccess,
                fFail
                );
    },
    uploadLogo: function (data, fResponse)
    {
        var self = this;
        $.ajax({
            method: 'post',
            dataType: 'json',
            url: Core.site_url(UserProfile_Base.linkx + '/process/upload-picture-profile'),
            data: data,
            //use contentType, processData for sure.
            contentType: false,
            processData: false,
            beforeSend: function () {
                Modal_Picture.beforeProcessBar();
                //console.log('Hold on...');
            },
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                //console.log(myXhr);
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', Modal_Picture.uploadProgressBar, false);
                }
                return myXhr;
            },
            success: function (data, textStatus, jqXHR) {
                fResponse(data);
            },
            error: function () {
                //$(".modal .ajax_data").html("<pre>Sorry! Couldn't process your request.</pre>");// 
                //$('#done').hide();
                console.log('error');
            }
        });
    },
    loadPictureProfile: function (fResponse)//OK
    {
        $.ajax({
            url: Core.site_url(UserProfile_Base.linkx + '/process/load-picture-profile'),
            method: 'post',
            dataType: 'json',
            data: {},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    deletePictureProfile: function (fResponse)//OK
    {
        $.ajax({
            url: Core.site_url(UserProfile_Base.linkx + '/process/delete-picture-profile'),
            method: 'post',
            dataType: 'json',
            data: {},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    }

};

var PUser_Model = {
    saveUser: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(UserProfile_Base.linkx + '/process/save-user'),
            method: 'post',
            dataType: 'json',
            data: data,
            success: function (data, textStatus, jqXHR)
            {
                fResponse(data);
            }
        });
    },
};