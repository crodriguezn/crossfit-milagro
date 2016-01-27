var Login_Advanced = {
    init: function()
    {
        this.Controller.init();
    }
};

Login_Advanced.Controller = {
    init: function()
    {
        var self = this;
        $('.action-login').click(function() {
            self.checkLogin();
        });
        
        $('.action-cancel').click(function() {
            self.checkCancel();
        });
        
        $('.alert.alert-danger').hide();
        self.setLoading(false);
        
    },
    checkCancel: function()
    {
        location.href = Core.site_url('app/logout');
    },
    checkLogin: function()
    {
        var self = this;
        self.setLoading(true);
        
        var data = {
            username : $('[name="username"]').val(),
            password : $('[name="password"]').val()
        };
        
        Login_Advanced.Model.checkLogin(data, function(res) {
            if( res.isSuccess )
            {
                location.href = Core.site_url('app/dashboard');
            }
            else
            {
                Core.Notification.error(res.message);
                self.setLoading(false);
            }
        });
    }, 
    setLoading: function(isLoading)
    {
        var $form = $('form');
        if (isLoading)
        {
            $('.loading', $form).show();
            $('button[type="submit"]', $form).addClass('disabled');
            $('input[type="text"]', $form).attr({readonly: 'readonly'});
            $('input[type="password"]', $form).attr({readonly: 'readonly'});
            $('.alert.alert-danger').hide();
        }
        else
        {
            $('.loading', $form).hide();
            $('button[type="submit"]', $form).removeClass('disabled');
            $('input[type="text"]', $form).removeAttr('readonly');
            $('input[type="password"]', $form).removeAttr('readonly');
        }
    }
};

Core.addInit(function() {
    Login_Advanced.init();
   
});