

var myController = {
    init: function ()
    {
        var self = this;
        self.$page = $('#frm');
        $('.action-desacargar', self.$page).click(function ()
        {
            self.descargar();
        });
        $('.view_grupo', self.$page).hide();
        $('[name=rpte_tipo]', self.$page).change(function () {
            $('.view_grupo', self.$page).hide();
            $('[name="rpte_grupo"]', self.$page).select2('val', {});
            if ($(this).val() == 'RPTE_GRUPOS_CAMARAS')
            {
                $('.view_grupo', self.$page).show();
            }
        });
        self.formError([]);
    }
    ,
    formError: function (data)
    {
        var self = this;

        /*
         data: {
         NAME_FIELD1:MESSAGE1, NAME_FIELD2:MESSAGE2
         ...
         }
         */

        var $form_group = $('.form-group', self.$page);

        $form_group.removeClass('has-error');
        $('.label-danger', $form_group).html('').hide();

        for (var field_name in data)
        {
            var $form_group = $('[name="' + (field_name) + '"]', self.$page).closest('.form-group');
            $form_group.addClass('has-error');
            $('.label-danger', $form_group).html(data[field_name]).show();
        }
    },
    validarFilds: function ()
    {
        var self = this;
        var data = [];
        var date_begin = $('[name="date_begin"]', self.$page).val();
        var date_end = $('[name="date_end"]', self.$page).val();
        var rpte_tipo = $('[name="rpte_tipo"]', self.$page).select2('val');
        var rpte_grupo = $('[name="rpte_grupo"]', self.$page).select2('val');
        if ($.isEmptyObject(date_begin))
        {
            data['date_begin']= 'Campo no debe estar vacio';
        }
        if ($.isEmptyObject(date_end))
        {
            data['date_end']= 'Campo no debe estar vacio';
        }
        if ($.isEmptyObject(rpte_tipo))
        {
            data['rpte_tipo']= 'Campo no debe estar vacio';
        }
        else if (rpte_tipo == 'RPTE_GRUPOS_CAMARAS')
        {
            if ($.isEmptyObject(rpte_grupo))
            {
                data['rpte_grupo']= 'Campo no debe estar vacio';
            }
        }
        console.log(data);
        if (!$.isEmptyObject(data))
        {
            self.formError(data);
            return false;
        }
        self.formError([]);
        return true;
    }
    ,
    descargar: function ()
    {
        var self = this;
        var date_begin = $('[name="date_begin"]', self.$page).val();
        var date_end = $('[name="date_end"]', self.$page).val();
        var rpte_tipo = $('[name="rpte_tipo"]', self.$page).select2('val');
        var rpte_grupo = $('[name="rpte_grupo"]', self.$page).select2('val');

        var grupo = '';
        var total = (rpte_grupo.length - 1);
        $.each(rpte_grupo, function (index, value) {

            if (total == index)
            {
                grupo += value;
            }
            else
            {
                grupo += value + '-';
            }
        });
        if (self.validarFilds())
        {
            $(location).attr('href', Core.site_url('public/reporte/printReport/' + date_begin + '/' + date_end) + '/' + rpte_tipo + '/' + grupo);
        }

    }
};

Core.addInit(function ()
{
    myController.init();
});