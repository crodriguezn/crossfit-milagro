

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
            $('.view_range_fecha', self.$page).show();
            $('.view_fecha', self.$page).hide();
            $('[name="rpte_grupo"]', self.$page).select2('val', {});
            if ($(this).val() == 'RPTE_RESUMEN_GRUPOS_CAMARAS')
            {
                self.loadGrupo($(this).val());
            }
        });
        $('.view_range_fecha', self.$page).show();
        $('.view_fecha', self.$page).hide();
        $('[name=rpte_grupo]', self.$page).change(function () {

            var valor = $('[name="rpte_grupo"]', self.$page).select2('val');

            if (valor == '3')
            {
                $('.view_range_fecha', self.$page).hide();
                $('.view_fecha', self.$page).show();
            }
            else
            {
                $('.view_fecha', self.$page).hide();
                $('.view_range_fecha', self.$page).show();
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
        if (rpte_grupo != 3)
        {
            if ($.isEmptyObject(date_begin))
            {
                data['date_begin'] = 'Campo no debe estar vacio';
            }
            if ($.isEmptyObject(date_end))
            {
                data['date_end'] = 'Campo no debe estar vacio';
            }
            if ($.isEmptyObject(rpte_tipo))
            {
                data['rpte_tipo'] = 'Campo no debe estar vacio';
            }
            else if (rpte_tipo == 'RPTE_RESUMEN_GRUPOS_CAMARAS')
            {
                if ($.isEmptyObject(rpte_grupo))
                {
                    data['rpte_grupo'] = 'Campo no debe estar vacio';
                }
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
        var rpte_t_descarga = $('[name="rpte_t_descarga"]', self.$page).select2('val');
        if (rpte_grupo == 3)
        {
            var year = $('[name="year"]', self.$page).select2('val');
            var month = $('[name="month"]', self.$page).select2('val');
            var date_begin = year + '-' + month;
            var date_end = year + '-' + month;
        }

        if (self.validarFilds())
        {
            $(location).attr('href', Core.site_url(Reporte_Base.link + '/printReport/' + date_begin + '/' + date_end) + '/' + rpte_tipo + '/' + rpte_grupo + '/' + rpte_t_descarga);
        }

    }
    ,
    loadGrupo: function (id_rpte)
    {
        var self = this;
        Report_Model.loadGrupo(id_rpte, function (res) {
            var html = '';
            if (res.data && res.data.combo && res.data.combo.length > 0)
            {
                $.each(res.data.combo, function (idx, Obj)
                {
                    html += '<option value="' + (Obj.code) + '" >' + (Obj.name) + '</option>';
                });

                $('[name="rpte_grupo"]', self.$page)
                        .html(html)
                        .change();
            }
            else
            {
                html += '<option value="0" selected="selected" > NO EXISTE GRUPOS </option>';
                $('[name="rpte_grupo"]', self.$page)
                        .html(html)
                        .change();
                $.uniform.update();
            }

            $.uniform.update();
        }, function () {
            console.log('fun');
        });
        $('.view_grupo', self.$page).show();
    }
};

Core.addInit(function ()
{
    myController.init();
});