var Core = {
    _arrInit: [],
    site_url: function (uri) {
        return "<?php echo $site_url . ( empty($index_page) ? '' : '/' ) ; ?>" + uri;
    },
    base_url: function (uri) {
        return "<?php echo $base_url; ?>/" + uri;
    },
    //----------------
    //----------------
    init: function ()
    {
        this._init();
        this._runInits();
    },
    //----------------
    //----------------
    addInit: function (fun)
    {
        this._arrInit.push(fun);
    },
    //----------------
    //----------------
    _init: function ()
    {
        $('.modal').attr({'data-backdrop': "static", 'data-keyboard': "false"});

        $(".numerico").numeric({decimal: false}, {negative: false},
        function () {
            alert("Valor no Valido");
            this.value = "";
            this.focus();
        }
        );
    },
    _runInits: function ()
    {
        var self = this;

        $.each(self._arrInit, function (index, value) {
            value();
        });
    }
};

Core.Entity = {
    toData: function (data, entity)
    {
        var _entity = entity();
        for (var index in data)
        {
            _entity.runInit(index,data[index].value);
        }
    }
};

Core.Notification = {
    success: function (msg)
    {
        $.jGrowl(msg, {theme: 'growl-success', header: 'Mensaje!', life: 5000, closeTemplate: '', position: 'top-right'});
    },
    error: function (msg)
    {
        $.jGrowl(msg, {theme: 'growl-error', header: 'Mensaje!', life: 5000, closeTemplate: '', position: 'top-right'});
    },
    warning: function (msg)
    {
        $.jGrowl(msg, {theme: 'growl-warning', header: 'Mensaje!', life: 5000, closeTemplate: '', position: 'top-right'});
    },
    info: function (msg)
    {
        $.jGrowl(msg, {theme: 'growl-info', header: 'Mensaje!', life: 5000, closeTemplate: '', position: 'top-right'});
    }
};

Core.Alert = {
    question: function (question, fun_yes/*=null*/, fun_no/*=null*/)
    {
        var $popup = $('#alert-confirm');

        $popup.modal('show');

        $('.modal-body p', $popup).html(question);

        $('.btn-success', $popup).off('click').on('click', function () {
            if (typeof fun_yes != 'undefined') {
                fun_yes();
            }

            $popup.modal('hide');
        });

        $('.btn-danger', $popup).off('click').on('click', function () {
            if (typeof fun_no != 'undefined') {
                fun_no();
            }

            $popup.modal('hide');
        });
    }
};

Core.Loading = {
    load: function ($el/*=null*/, isShow/*=true*/)
    {

        isShow = typeof isShow == 'undefined' ? true : isShow;

        if ($el)
        {
            if (isShow)
            {
                //alert('1');
                $el.append('<div class="text-center"> Espere...<br /> <img src="resources/img/loading3.gif" /></div>');
                $el.fadeIn(150);
            }
            else
            {
                //alert('2');
                $el.append('');
            }
        }
        else
        {
            if (isShow)
            {
                //alert('3');
                $el.append('<div class="text-center"> Espere...<br /> <img src="resources/img/loading3.gif" /></div>');
                $el.fadeIn(150);
            }
            else
            {
                //alert('4');
                $el.append('');
            }
        }
    },
    show: function ($el/*=null*/, isShow/*=true*/)
    {

        if (isShow)
        {
            //$el.append('<div class="overlay"><div class="opacity2"></div><i class="icon-spinner7 spin"></i>Hola</div>');
            $el.append('<div class="overlay"><div class="opacity2"></div><i class="icon-clock spin"></i></div>');
            $('.overlay', $el).fadeIn(150);
        }
        else
        {
            $('.overlay', $el).fadeOut(150, function () {
                $(this).remove();
            });
        }
    },
    wait: function (isShow/*=true*/, $el/*=null*/)
    {
        /*
         defaults = {
         'position': "right",        // right | inside | overlay
         'text': "",                 // Text to display next to the loader
         'class': "icon-refresh",    // loader CSS class
         'tpl': '<span class="isloading-wrapper %wrapper%">%text%<i class="%class% icon-spin"></i></span>',
         'disableSource': true,      // true | false
         'disableOthers': []
         };
         */

        isShow = typeof isShow == 'undefined' ? true : isShow;

        if ($el)
        {
            if (isShow)
            {
                //alert('1');
                $el.isLoading({
                    text: "Espere...", position: "overlay",
                    tpl: '<span class="isloading-wrapper %wrapper%">%text%<i class="%class% icon-clock"></i></span>'
                });
            }
            else
            {
                //alert('2');
                $el.isLoading("hide");
            }
        }
        else
        {
            if (isShow)
            {
                //alert('3');
                $.isLoading({
                    text: "Espere...",
                    tpl: '<span class="isloading-wrapper %wrapper%">%text%<i class="%class% icon-clock"></i></span>'
                });
            }
            else
            {
                //alert('4');
                $.isLoading("hide");
            }
        }
    }
};

Core.Ajax = {
    post: function (url, data, fSuccess, fFail/*=null*/)
    {
        $.ajax({
            url: url, data: data, method: 'post', dataType: 'json',
            success: function (res, textStatus, jqXHR)
            {
                //console.log(textStatus);
                //console.log(jqXHR);
                fSuccess(res);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            Core.Notification.error(jqXHR.responseText);
            console.log(textStatus);
            console.log(errorThrown);
            if (fFail)
            {
                fFail();
            }
        });
    }
};

Core.Form = {
    read: function ($content)
    {
        var data = {};

        $('[name]', $content).each(function (idx, el) {
            var $el = $(el);

            var el_tag = $el.prop('tagName');
            var el_type = $el.prop('tagName');
            var el_name = $el.attr('name');

            if (el_tag == 'TABLE')
            {
                data[ el_name ] = [];

                $('tbody tr', $el).each(function (idx2, tr) {
                    var $tr = $(tr);

                    data[ el_name ].push($tr.data());
                });
            }
            else if (el_tag == 'INPUT' && (el_type == 'RADIO' || el_type == 'CHECKBOX'))
            {
                if ($el.prop('checked'))
                {
                    data[ el_name ] = $el.val();
                }
            }
            else
            {
                data[ el_name ] = $el.val();
            }
        });

        //console.log( data );
        return data;
    },
    readOnly: function($frm, isFormReadOnly)
    {
        var self = this;

        $frm.find(':input[type="text"], :input[type="password"]').each(function() {
            $(this, self.$frm).prop('readonly', isFormReadOnly);
        });
        
        $frm.find(':input[type="radio"]').each(function() {
            $(this, self.$frm).prop('disabled', isFormReadOnly);
        });

        $frm.find(':input[type="checkbox"][name]').each(function() {
            $(this, self.$frm).prop('disabled', isFormReadOnly);
        });

        $frm.find('select').each(function() {
            $(this, self.$frm).select2('enable', !isFormReadOnly);
            if (isFormReadOnly)
            {
                $(this, self.$frm).prop('disabled', true);
            }
            else
            {
                $(this, self.$frm).select2('enable', true);
            }
            
        });

        $frm.find('textarea').each(function() {
            $(this, self.$frm).prop('disabled', isFormReadOnly);
        });
    }
};

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
/*
 $.fn.removeNumeric = function()
 {
 return this
 .data("numeric.decimal", null)
 .data("numeric.negative", null)
 .data("numeric.callback", null)
 .unbind("keypress", $.fn.numeric.keypress)
 .unbind("keyup", $.fn.numeric.keyup).unbind("blur", $.fn.numeric.blur);
 };*/

$.extend(true, $.fn.dataTable.defaults, {
    oLanguage: {
        sSearch: "<span>Filtro:</span> _INPUT_",
        sLengthMenu: "<span>Mostrar Entradas:</span> _MENU_",
        sZeroRecords: "No se encontraron resultados",
        sProcessing: "Procesando...",
        sEmptyTable: "Ningún dato disponible para visualizar",
        sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sLoadingRecords: "Cargando...",
        oPaginate: {
            sFirst: "<i title='Inicio' class='icon-first'></i>",
            sLast: "<i title='Último' class='icon-last'></i>",
            sNext: "<i title='Siguiente' class='icon-next'></i>",
            sPrevious: "<i title='Anterior' class='icon-previous'></i>"
        }
    }
});
