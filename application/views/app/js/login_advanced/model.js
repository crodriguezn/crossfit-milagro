Login_Advanced.Model = {
    checkLogin: function(data, fResponse)
    {
        $.ajax({
            url: Core.site_url( 'app/login_advancedx/process/check' ), method: 'post', dataType: 'json',
            data: data,
            success: function(res, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(res);
            }
        });
    }
};


