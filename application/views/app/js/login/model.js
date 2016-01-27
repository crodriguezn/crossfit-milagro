Login.Model = {
    checkLogin: function(data, fResponse)
    {
        $.ajax({
            url: Core.site_url( 'app/loginx/process/check' ), method: 'post', dataType: 'json',
            data: data,
            success: function(res, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(res);
            }
        });
    },
    requestCaptcha: function(fResponse)
    {
        $.ajax({
            url: Core.site_url('app/loginx/process/get-captcha'), method: 'post', dataType: 'json',
            data: {},
            success: function(res, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(res);
            }
        });
    }
};


