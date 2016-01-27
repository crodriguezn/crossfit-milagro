var Company_Model = {
    loadCompany: function (fResponse)
    {
        $.ajax({
            url: Core.site_url(Administration_Company_Base.linkx + '/process/load-company'),
            method: 'post',
            dataType: 'json',
            data: {},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    uploadLogo: function (data, fResponse)
    {
        $.ajax({
            method: 'post',
            dataType: 'json',
            url: Core.site_url(Administration_Company_Base.linkx + '/process/upload-company-logo'),
            data: data,
            //use contentType, processData for sure.
            contentType: false,
            processData: false,
            beforeSend: function () {
                Company_Controller.beforeProcessBar();
                //console.log('Hold on...');
            },
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                //console.log(myXhr);
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', Company_Controller.uploadProgressBar, false);
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
    }
};

var Company_Branch_Model = {
    saveCompanyBranch: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(Administration_Company_Base.linkx + '/process/save-company-branch'),
            method: 'post',
            dataType: 'json',
            data: data,
            success: function (data, textStatus, jqXHR)
            {
                fResponse(data);
            }
        });
    },
    loadCompanyBranch: function (id_company_branch, fResponse)
    {
        $.ajax({
            url: Core.site_url(Administration_Company_Base.linkx + '/process/load-company-branch'),
            method: 'post',
            dataType: 'json',
            data: {id_company_branch: id_company_branch},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    loadPais: function (fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(Administration_Company_Base.linkx + '/process/load-pais'),
                {},
                fSuccess,
                fFail
                );
    },
    loadProvincia: function (id_pais, fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(Administration_Company_Base.linkx + '/process/load-provincia'),
                {id_pais: id_pais},
        fSuccess,
                fFail
                );
    },
    loadCiudad: function (id_provincia, fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(Administration_Company_Base.linkx + '/process/load-ciudad'),
                {id_provincia: id_provincia},
        fSuccess,
                fFail
                );
    }
};