var Listing_Model = {
    saveProfilePermission: function(data, fResponse)
    {
        $.ajax({
            url: Core.site_url( Listing_Base.linkx + '/process/save-profile-permission'), 
            method:'post', 
            dataType:'json',
            data: data,
            success: function(data, textStatus, jqXHR)
            {
                fResponse( data );
            }
        });
    }
};