var Profile_Model = {
    loadProfile: function(id_profile, fResponse)
    {
        $.ajax({
            url: Core.site_url( Profile_Base.linkx + '/process/load-profile'), 
            method:'post', 
            dataType:'json',
            data: { id_profile:id_profile },
            success: function(data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse( data );
            }
        });
    },
    saveProfile: function(data, fResponse)
    {
        $.ajax({
            url: Core.site_url( Profile_Base.linkx + '/process/save-profile'), 
            method:'post', 
            dataType:'json',
            data: data,
            success: function(data, textStatus, jqXHR)
            {
                fResponse( data );
            }
        });
    },
    saveProfilePermission: function(data, fResponse)
    {
        $.ajax({
            url: Core.site_url( Profile_Base.linkx + '/process/save-profile-permission'), 
            method:'post', 
            dataType:'json',
            data: data,
            success: function(data, textStatus, jqXHR)
            {
                fResponse( data );
            }
        });
    }
    ,
    loadComponentsModalRoles: function( fSuccess, fFail )//OK
    {
        Core.Ajax.post(
            Core.site_url( Profile_Base.linkx + '/process/load-components-modal-rol'),
            {},
            fSuccess,
            fFail
        );
    }
};