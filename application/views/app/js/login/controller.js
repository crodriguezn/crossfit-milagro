var Login = {
    init: function()
    {
        this.Controller.init();
    }
};

Login.Controller = {
    init: function()
    {
        var self = this;
        $('.action-login').click(function() {
            self.checkLogin();
        });
        
        $('.alert.alert-danger').hide();
        self.setLoading(false);
        
        $('.img-captcha').click(function() {
            self.createCaptcha();
        }).css({cursor: 'pointer'});
        
        self.createCaptcha();
    }, 
    checkLogin: function()
    {
        var self = this;
        self.setLoading(true);
        
        var data = {
            username : $('[name="username"]').val(),
            password : $('[name="password"]').val(),
            security : $('[name="security"]').val()
            //login_type: Layout_Global.login_type
        };
        
        Login.Model.checkLogin(data, function(res) {
            if( res.isSuccess )
            {
                location.href = Core.site_url('app/dashboard');
            }
            else
            {
                self.createCaptcha();
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
    }, 
    createCaptcha: function()
    {
        $('.img-captcha').attr('src', Core.site_url( 'app/login/image_captcha/'+( (new Date()).getTime() ) ));
    }
};
var Modal_Register = {
    init: function()
    {
        var self = this;
        self.$modal = $('#modal-register');

        $('input[name="birthday"]', self.$modal).datepicker();
        
        $('#login-register').click(function() {
            self.open();
        });
        
        // MODAL
        self.$modal.on("show.bs.modal", function() {
            //alert('show form');
        });
        
        self.$modal.on("hidden.bs.modal", function() {
            self.formReset();
            //self.setData(null);
        });
        
        $('#btnRegistar', self.$modal).click(function() {
            self.actionSave();
        });
        
        self.formReset();
    },
    open: function()
    {
        var self = this;
        
        self.$modal.modal('show');
    },
    close: function()
    {
        var self = this;
        
        self.formReset();
        
        self.$modal.modal('hide');
    },
    //====================
    // FORM
    //====================
    formReset: function()
    {
        var self = this;
        
        self.formSetData(null);
        self.formSetErrors([]);
        self.formSetReadOnly(false);
        self.formLoading('none');
    },
    formSetData: function(res)
    {
        var self = this;
        
        var name = '', surname = '', document = '', birthday = '', gender = '', phone = '', address = '', username = '',
            profile = '', password = '', verifypassword = '', email = '', verifyemail = '';
        
        if( res != null )
        {
            if( res.forms.module.name ){ name = res.forms.module.name; }
            if( res.forms.module.surname ) { surname = res.forms.module.surname; }
            if( res.forms.module.document ) { document = res.forms.module.document; }
            if( res.forms.module.birthday ) { birthday = res.forms.module.birthday; }
            if( res.forms.module.gender ) { gender = res.forms.module.gender; }
            if( res.forms.module.phone ) { phone = res.forms.module.phone; }
            if( res.forms.module.address ) { address = res.forms.module.address; }
            if( res.forms.module.username ) { username = res.forms.module.username; }
            if( res.forms.module.profile ) { profile = res.forms.module.profile; }
            if( res.forms.module.password ) { password = res.forms.module.password; }
            if( res.forms.module.verifypassword ) { verifypassword = res.forms.module.verifypassword; }
            if( res.forms.module.email ) { email = res.forms.module.email; }
            if( res.forms.module.verifyemail ) { verifyemail = res.forms.module.verifyemail; }
        }
        
        $('[name="name"]', self.$modal).val(name);
        $('[name="surname"]', self.$modal).val(surname);
        $('[name="document"]', self.$modal).val(document);
        $('[name="birthday"]', self.$modal).val(birthday);
        $('[name="gender"]', self.$modal).select2('val', $('[name="gender"] option:nth-child(1)',self.$modal).attr('value') );
        $('[name="phone"]', self.$modal).val(phone);
        $('[name="address"]', self.$modal).val(address);
        $('[name="username"]', self.$modal).val(username);
        $('[name="profile"]', self.$modal).val(profile);
        $('[name="password"]', self.$modal).val(password);
        $('[name="verifypassword"]', self.$modal).val(verifypassword);
        $('[name="email"]', self.$modal).val(email);
        $('[name="verifyemail"]', self.$modal).val(verifyemail);
        
        $.uniform.update();
    },
    formSetErrors: function(form_errors)
    {
        var self = this;
        /*
         form_errors: {
         NAME_FIELD1:MESSAGE1, NAME_FIELD2:MESSAGE2
         ...
         }
         */
        var $form_group = $('.form-group', self.$modal);
        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();
        for (var field_name in form_errors)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$modal).closest('.form-group');
            $form_group.addClass('has-error');
            $('.label-danger', $form_group).html(form_errors[field_name]).show();
        }
    },
    formSetReadOnly: function(isFormReadOnly)
    {
        var self = this;
        $('input[name="name"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="surname"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="document"]', self.$modal).prop('readonly', isFormReadOnly);
        $('select[name="gender"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="birthday"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="phone"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="address"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="username"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="profile"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="password"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="verifypassword"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="email"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="verifyemail"]', self.$modal).prop('readonly', isFormReadOnly);
        
        $.uniform.update();
    },
    formGetData: function()
    {
        var self = this;
        
        var data = {};
        data['name'] = $('[name="name"]', self.$modal).val();
        data['surname'] = $('[name="surname"]', self.$modal).val();
        data['document'] = $('[name="document"]', self.$modal).val();
        data['gender'] = $('[name="gender"]', self.$modal).select2('val');
        data['birthday'] = $('[name="birthday"]', self.$modal).val();
        data['phone'] = $('[name="phone"]', self.$modal).val();
        data['address'] = $('[name="address"]', self.$modal).val();
        data['username'] = $('[name="username"]', self.$modal).val();
        data['profile'] = $('[name="profile"]', self.$modal).val();
        data['password'] = $('[name="password"]', self.$modal).val();
        data['verifypassword'] = $('[name="verifypassword"]', self.$modal).val();
        data['email'] = $('[name="email"]', self.$modal).val();
        data['verifyemail'] = $('[name="verifyemail"]', self.$modal).val();
        
        return data;
    },
    formLoading: function( key )
    {
        var self = this;
        
        switch(key)
        {
            case 'save':
                $('.loading .text', self.$modal).html('Guardando...');
                $('.loading', self.$modal).show();
                $('.action-save, .action-edit, .action-close').addClass('disabled');
                break;
            case 'load':
                $('.loading .text', self.$modal).html('Cargando...');
                $('.loading', self.$modal).show();
                $('.action-save, .action-edit, .action-close').addClass('disabled');
                break;
            case 'none':
                $('.loading .text', self.$modal).html('');
                $('.loading', self.$modal).hide();
                $('.action-save, .action-edit, .action-close').removeClass('disabled');
                break;
        }
        
        $.uniform.update();
    },
    //====================
    // ACTIONS
    //====================
    actionSave: function()
    {
        var self = this;
        
        var data = self.formGetData();
        
        self.formSetReadOnly(true);
        self.formLoading('save');
        Core.Ajax.post(Core.site_url('app/loginx/process/register-representante-legal'), data, function(res) {
            if (res.isSuccess)
            {
                Core.Notification.success(res.message);
                self.close();
            }
            else
            {
                Core.Notification.error(res.message);
                self.formSetErrors(res.forms.register.errors);
            }
            
            self.formSetReadOnly(false);
            self.formLoading('none');
        });
    }
};

Core.addInit(function() {
    Login.init();
    this.Modal_Register.init();
    //Register.init();
});