MY_Layout_Model = {
    init: function () {

    },
    updatePerfilSession: function (id_profile, fResponse)
    {
        $.ajax({
            async: false,
            url: Core.site_url('app/layoutx/process/update-profile-session'),
            method: 'post',
            dataType: 'json',
            data: {id_profile: id_profile},
            success: function (res, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(res);
            }
        });
    },
    updateSedeSession: function (id_company_branch, fResponse)
    {
        $.ajax({
            async: false,
            url: Core.site_url('app/layoutx/process/update-sede-session'),
            method: 'post',
            dataType: 'json',
            data: {id_company_branch: id_company_branch},
            success: function (res, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(res);
            }
        });
    }
};