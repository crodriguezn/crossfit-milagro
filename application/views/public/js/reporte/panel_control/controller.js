

var myController = {
    init: function ()
    {
        var self = this;
        self.$page = $('#frm');
        $('.action-desacargar', self.$page).click(function ()
        {
            self.descargar();
        });
        var year = $('[name="year"]', self.$page).val();
        var month = $('[name="year"]', self.$page).val();
        self.load_Day(year, month);
        $('.view_sub_informacion', self.$page).hide();
        $('[name=rpte_tipo_informacion]', self.$page).change(function () {
            $('.view_sub_informacion', self.$page).hide();
            $('.view_day', self.$page).hide();
            $('.view_day_week', self.$page).hide();
            var valor = $(this).val();
            if (valor == 'INFORMATION_BY_HOUR')
            {
                $('.view_sub_informacion', self.$page).show();
                if ($('[name=rpte_tipo_sub_informacion]', self.$page).val() == 'PROMEDIO_BY_HOUR_DATE')
                {
                    $('.view_day', self.$page).show();
                }
                if ($('[name=rpte_tipo_sub_informacion]', self.$page).val() == 'PROMEDIO_BY_HOUR_DAY_FROM_DAY_WEEK')
                {
                    $('.view_day_week', self.$page).show();
                }
            }
        });

        $('.view_day', self.$page).hide();
        $('.view_day_week', self.$page).hide();
        $('[name=rpte_tipo_sub_informacion]', self.$page).change(function () {
            $('.view_day', self.$page).hide();
            $('.view_day_week', self.$page).hide();
            var valor = $(this).val();
            if (valor == 'PROMEDIO_BY_HOUR_DATE')
            {
                $('.view_day', self.$page).show();
            }
            if (valor == 'PROMEDIO_BY_HOUR_DAY_FROM_DAY_WEEK')
            {
                $('.view_day_week', self.$page).show();
            }
        });

        $('[name="year"]', self.$page).change(function () {
            $('.view_day', self.$page).hide();
            if ($('[name="rpte_tipo_informacion"]', self.$page).val() == 'INFORMATION_BY_HOUR')
            {
                if ($('[name=rpte_tipo_sub_informacion]', self.$page).val() == 'PROMEDIO_BY_HOUR_DATE')
                {
                    $('.view_day', self.$page).show();
                    var year = $('[name="year"]', self.$page).val();
                    var month = $('[name="year"]', self.$page).val();
                    self.load_Day(year, month);
                }
            }

        });

        $('[name="month"]', self.$page).change(function () {
            $('.view_day', self.$page).hide();
            if ($('[name="rpte_tipo_informacion"]', self.$page).val() == 'INFORMATION_BY_HOUR')
            {
                if ($('[name=rpte_tipo_sub_informacion]', self.$page).val() == 'PROMEDIO_BY_HOUR_DATE')
                {
                    $('.view_day', self.$page).show();
                    var year = $('[name="year"]', self.$page).val();
                    var month = $('[name="year"]', self.$page).val();
                    self.load_Day(year, month);
                }
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
        var rpte_tipo_informacion = $('[name="rpte_tipo_informacion"]', self.$page).select2('val');
        var rpte_tipo_sub_informacion = $('[name="rpte_tipo_sub_informacion"]', self.$page).select2('val');
        var year = $('[name="year"]', self.$page).select2('val');
        var month = $('[name="month"]', self.$page).select2('val');
        var day = $('[name="day"]', self.$page).select2('val');
        var day_week = $('[name="day_week"]', self.$page).select2('val');
        var rpte_tipo = $('[name="rpte_tipo"]', self.$page).select2('val');
        var rpte_t_descarga = $('[name="rpte_t_descarga"]', self.$page).select2('val');

        //var rpte_grupo = $('[name="rpte_grupo"]', self.$page).select2('val');
        if ($.isEmptyObject(rpte_tipo_informacion))
        {
            data['rpte_tipo_informacion'] = 'Campo no debe estar vacio';
        }
        else
        {
            if ($.isEmptyObject(rpte_tipo_sub_informacion))
            {
                data['rpte_tipo_sub_informacion'] = 'Campo no debe estar vacio';
            }
            else
            {
                if (rpte_tipo_sub_informacion == 'PROMEDIO_BY_HOUR_DAY_FROM_DAY_WEEK')
                {
                    if ($.isEmptyObject(day_week))
                    {
                        data['day_week'] = 'Campo no debe estar vacio';
                    }
                }
                if (rpte_tipo_sub_informacion == 'PROMEDIO_BY_HOUR_DATE')
                {
                    if ($.isEmptyObject(day))
                    {
                        data['day'] = 'Campo no debe estar vacio';
                    }
                }
            }
        }
        if ($.isEmptyObject(year))
        {
            data['year'] = 'Campo no debe estar vacio';
        }
        if ($.isEmptyObject(month))
        {
            data['month'] = 'Campo no debe estar vacio';
        }
        if ($.isEmptyObject(rpte_tipo))
        {
            data['rpte_tipo'] = 'Campo no debe estar vacio';
        }

        if ($.isEmptyObject(rpte_t_descarga))
        {
            data['rpte_t_descarga'] = 'Campo no debe estar vacio';
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
        var rpte_tipo_informacion = $('[name="rpte_tipo_informacion"]', self.$page).select2('val');
        var rpte_tipo_sub_informacion = $('[name="rpte_tipo_sub_informacion"]', self.$page).select2('val');
        var year = $('[name="year"]', self.$page).select2('val');
        var month = $('[name="month"]', self.$page).select2('val');
        var day = $('[name="day"]', self.$page).select2('val');
        var day_week = $('[name="day_week"]', self.$page).select2('val');
        var rpte_tipo = $('[name="rpte_tipo"]', self.$page).select2('val');
        var rpte_t_descarga = $('[name="rpte_t_descarga"]', self.$page).select2('val');

        var grupo = '';
        /*var total = (rpte_grupo.length - 1);
         $.each(rpte_grupo, function (index, value) {
         
         if (total == index)
         {
         grupo += value;
         }
         else
         {
         grupo += value + '-';
         }
         });*/
        if (self.validarFilds())
        {
            $(location).attr('href', Core.site_url(Panel_Control_Base.link + '/printReport/' + rpte_tipo_informacion + '/' + rpte_tipo_sub_informacion + '/' + year + '/' + month + '/' + day + '/' + day_week + '/' + rpte_tipo + '/' + rpte_t_descarga));
        }

    }
    ,
    load_Day: function (year, month)
    {
        var self = this;
        Panel_Control_Model.loadDay(year, month, function (res) {
            var html = '';
            if (res.data && res.data.day && res.data.day.length > 0)
            {
                $.each(res.data.day, function (idx, Obj)
                {
                    html += '<option value="' + (Obj.code) + '" selected="' + (Obj.code == '01' ? 'selected' : '') + '" >' + (Obj.name) + '</option>';
                });

                $('[name="day"]', self.$page)
                        .html(html)
                        .select2('val', $('[name=day] option:eq(0)', self.$page).val());
            }
            else
            {
                html += '<option value="0" selected="selected" > NO EXIT DAY </option>';
                $('[name="day"]', self.$page)
                        .html(html)
                        .select2('val', $('[name=day] option:eq(0)', self.$page).val());
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