var MY_Layout_Controller = {
    init: function()
    {
        this._init();

        Flash_Handler.init();
        //Modal_My_Data.init();
        Modal_Password.init();
    },
    _init: function()
    {
        var self = this;
        
        $('[action="action-layout-my-data"]').attr({
            'href':'javascript:void(0);'
        }).click(function(){
            Modal_My_Data.open();
        });
        
        $('[action="action-layout-password"]').attr({
            'href':'javascript:void(0);'
        }).click(function(){
            Modal_Password.open();
        });
        
        $('#navbar-perfiles select').change(function(){
            self.updatePerfilSession( $(this).select2('val') );
        });
        
        $('#navbar-sedes select').change(function(){
            self.updateSedeSession( $(this).select2('val') );
        });
    },
    updatePerfilSession: function(id_profile)
    {
        Core.Loading.wait();
        MY_Layout_Model.updatePerfilSession(id_profile, function(res){
            
            if( res.isSuccess )
            {
                //Core.Notification.success(res.message);
                location.reload();
            }
            else
            {
                Core.Loading.wait(false);
                Core.Notification.error(res.message);
                setTimeout(function(){ location.reload(); }, 1000);
            }
        });
    },
    updateSedeSession: function(id_company_branch)
    {
        Core.Loading.wait();
        MY_Layout_Model.updateSedeSession(id_company_branch, function(res){
            
            if( res.isSuccess )
            {
                Core.Notification.success(res.message);
                location.reload();
            }
            else
            {
                Core.Loading.wait(false);
                Core.Notification.error(res.message);
                setTimeout(function(){ location.reload(); }, 1000);
            }
        });
    }
};

var Flash_Handler = {
    init: function()
    {
        if( MY_Layout_Base.flash_type == 'success' )
        {
            Core.Notification.success(MY_Layout_Base.flash_message);
        }
        else if( MY_Layout_Base.flash_type == 'info' )
        {
            Core.Notification.info(MY_Layout_Base.flash_message);
        }
        else if( MY_Layout_Base.flash_type == 'warning' )
        {
            Core.Notification.warning(MY_Layout_Base.flash_message);
        }
        else if( MY_Layout_Base.flash_type == 'error' )
        {
            Core.Notification.error(MY_Layout_Base.flash_message);
        }
    }
};

var Modal_My_Data = {
    init: function()
    {
        var self = this;
        
        self.$modal = $('#layout-my-data-modal');
        
        self.$modal.on("show.bs.modal", function() {
            //alert('show form');
        });
        
        self.$modal.on("hidden.bs.modal", function() {
            self.formReset();
        });
        
        // ACTIONS
        
        $('.action-save', self.$modal).click(function(){
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
        this.formSetData(null);
        this.formSetErrors([]);
        this.formSetReadOnly(false);
        this.formSetLoading(false);
    },
    formSetData: function( res )
    {
        var self = this;
        
        var password_current = '';
        var password_new = '';
        var password_new_repeat = '';

        if( res != null )
        {
            if( res.forms.module.password_current ){ password_current = res.forms.module.password_current };
            if( res.forms.module.password_new ){ password_new = res.forms.module.password_new };
            if( res.forms.module.password_new_repeat ){ password_new_repeat = res.forms.module.password_new_repeat };
        }

        $('input[name="password_current"]', self.$modal).val( password_current );
        $('input[name="password_new"]', self.$modal).val( password_new );
        $('input[name="password_new_repeat"]', self.$modal).val( password_new_repeat );
        
        //$.uniform.update();
    },
    formGetData: function()
    {
        var self = this;
        
        /*return {
            password_current: $('[name="password_current"]', self.$modal).val(),
            password_new: $('[name="password_new"]', self.$modal).val(),
            password_new_repeat: $('[name="password_new_repeat"]', self.$modal).val()
        };*/
        
        var data = {};
        
        data['password_current'] = $('[name="password_current"]', self.$modal).val();
        data['password_new'] = $('[name="password_new"]', self.$modal).val();
        data['password_new_repeat'] = $('[name="password_new_repeat"]', self.$modal).val();
        
        return data;
    },
    formSetErrors: function( data )
    {
        var self = this;
        
        /*
        data: {
            NAME_FIELD1:MESSAGE1, NAME_FIELD2:MESSAGE2
            ...
        }
        */
        console.log(data);
        var $form_group = $('.form-group', self.$modal);
        
        $form_group.removeClass('has-error');
        $('.label-danger', $form_group ).html('').hide();
        
        for( var field_name in data )
        {
            if( data[field_name].length > 0 )
            {
                var $form_group = $('[name="'+( field_name )+'"]', self.$modal).closest('.form-group');
                if (!$.isEmptyObject(data[field_name].error))
                {
                    $form_group.addClass('has-error');
                    $('.label-danger', $form_group).html(data[field_name].error).show();
                }
               
            }
        }
    },
    formSetReadOnly: function( isFormReadOnly )
    {
        var self = this;

        $('input[name="password_current"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="password_new"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="password_new_repeat"]', self.$modal).prop('readonly', isFormReadOnly);
    },
    formSetLoading: function( isShow )
    {
        var self = this;
        
        var $elLoading = $('.modal-dialog', self.$modal);
        
        Core.Loading.show($elLoading, isShow);
    },
    //====================
    // ACTIONS
    //====================
    actionSave: function()
    {
        var self = this;
        
        var data = self.formGetData();
        
        self.formSetLoading(true);
        
        Core.Ajax.post( Core.site_url('app/layoutx/process/update-password'), data, function(res){
            console.log(res);
            if( res.isSuccess )
            {
                Core.Notification.success( res.message );
                self.close();
            }
            else
            {
                Core.Notification.error( res.message );
                
                self.formSetErrors( res.forms.change_password );
            }
            
            self.formSetLoading(false);
        });
    }
};

var Modal_Password = {
    init: function()
    {
        var self = this;
        
        self.$modal = $('#layout-password-modal');
        
        self.$modal.on("show.bs.modal", function() {
            //alert('show form');
        });
        
        self.$modal.on("hidden.bs.modal", function() {
            self.formReset();
        });
        
        // ACTIONS
        
        $('.action-save', self.$modal).click(function(){
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
        this.formSetData(null);
        this.formSetErrors([]);
        this.formSetReadOnly(false);
        this.formSetLoading(false);
    },
    formSetData: function( res )
    {
        var self = this;
        
        var password_current = '';
        var password_new = '';
        var password_new_repeat = '';

        if( res != null )
        {
            if( res.forms.module.password_current ){ password_current = res.forms.module.password_current };
            if( res.forms.module.password_new ){ password_new = res.forms.module.password_new };
            if( res.forms.module.password_new_repeat ){ password_new_repeat = res.forms.module.password_new_repeat };
        }

        $('input[name="password_current"]', self.$modal).val( password_current );
        $('input[name="password_new"]', self.$modal).val( password_new );
        $('input[name="password_new_repeat"]', self.$modal).val( password_new_repeat );
        
        //$.uniform.update();
    },
    formGetData: function()
    {
        var self = this;
        
        /*return {
            password_current: $('[name="password_current"]', self.$modal).val(),
            password_new: $('[name="password_new"]', self.$modal).val(),
            password_new_repeat: $('[name="password_new_repeat"]', self.$modal).val()
        };*/
        
        var data = {};
        
        data['password_current'] = $('[name="password_current"]', self.$modal).val();
        data['password_new'] = $('[name="password_new"]', self.$modal).val();
        data['password_new_repeat'] = $('[name="password_new_repeat"]', self.$modal).val();
        
        return data;
    },
    formSetErrors: function( data )
    {
        var self = this;
        
        /*
        data: {
            NAME_FIELD1:MESSAGE1, NAME_FIELD2:MESSAGE2
            ...
        }
        */
        
        var $form_group = $('.form-group', self.$modal);
        
        $form_group.removeClass('has-error');
        $('.label-danger', $form_group ).html('').hide();
        
        for (var field_name in data)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$modal).closest('.form-group');
            if (!$.isEmptyObject(data[field_name].error))
            {
                $form_group.addClass('has-error');
                $('.label-danger', $form_group).html(data[field_name].error).show();
            }

        }
    },
    formSetReadOnly: function( isFormReadOnly )
    {
        var self = this;

        $('input[name="password_current"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="password_new"]', self.$modal).prop('readonly', isFormReadOnly);
        $('input[name="password_new_repeat"]', self.$modal).prop('readonly', isFormReadOnly);
    },
    formSetLoading: function( isShow )
    {
        var self = this;
        
        var $elLoading = $('.modal-dialog', self.$modal);
        
        Core.Loading.show($elLoading, isShow);
    },
    //====================
    // ACTIONS
    //====================
    actionSave: function()
    {
        var self = this;
        
        var data = self.formGetData();
        
        self.formSetLoading(true);
        
        Core.Ajax.post( Core.site_url('app/layoutx/process/update-password'), data, function(res){
            
            if( res.isSuccess )
            {
                Core.Notification.success( res.message );
                self.close();
            }
            else
            {
                Core.Notification.error( res.message );
                self.formSetErrors( res.forms.change_password );
            }
            
            self.formSetLoading(false);
        });
    }
};

Core.addInit(function(){
    MY_Layout_Controller.init();
});