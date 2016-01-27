var BackUp_Model = {
    backup: function( fResponse)
    {
        $.ajax({
            url: Core.site_url('app/system_db_back_upx/process/backup'), method:'post', dataType:'json',
            data: {},
            success: function(data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse( data );
            }
        });
    }
};