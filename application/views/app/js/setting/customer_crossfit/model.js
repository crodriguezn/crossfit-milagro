var CustomerCrossfit_Model = {
    loadCustomer: function (id_customer, fResponse)
    {
        $.ajax({
            url: Core.site_url(Customer_Crossfit_Base.linkx + '/process/load-customer-crossfit'),
            method: 'post',
            dataType: 'json',
            data: {id_customer: id_customer},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    loadComponents: function (fResponse)
    {
        $.ajax({
            url: Core.site_url(Customer_Crossfit_Base.linkx + '/process/load-components'),
            method: 'post',
            dataType: 'json',
            data: {},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    loadPais: function (fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(Customer_Crossfit_Base.linkx + '/process/load-pais'),
                {},
                fSuccess,
                fFail
                );
    },
    loadProvincia: function (id_pais, fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(Customer_Crossfit_Base.linkx + '/process/load-provincia'),
                {id_pais: id_pais},
        fSuccess,
                fFail
                );
    },
    loadCiudad: function (id_provincia, fSuccess, fFail)//OK
    {
        Core.Ajax.post(
                Core.site_url(Customer_Crossfit_Base.linkx + '/process/load-ciudad'),
                {id_provincia: id_provincia},
        fSuccess,
                fFail
                );
    },
    saveCustomer: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(Customer_Crossfit_Base.linkx + '/process/save-customer-crossfit'),
            method: 'post',
            dataType: 'json',
            data: data,
            success: function (data, textStatus, jqXHR)
            {
                fResponse(data);
            }
        });
    },
    loadPersonByDocument: function (document, fResponse)
    {
        var self = this;

        if (self.ajax1) {
            self.ajax1.abort();
        }

        self.ajax1 = $.ajax({
            url: Core.site_url(Customer_Crossfit_Base.linkx + '/process/load-person-by-document'),
            method: 'post',
            dataType: 'json',
            data: {document: document},
            success: function (data, textStatus, jqXHR) // Function( PlainObject data, String textStatus, jqXHR jqXHR )
            {
                fResponse(data);
            }
        });
    },
    saveControlIMC: function (data, fResponse)
    {
        $.ajax({
            url: Core.site_url(Customer_Crossfit_Base.linkx + '/process/save-control-imc'),
            method: 'post',
            dataType: 'json',
            data: data,
            success: function (data, textStatus, jqXHR)
            {
                fResponse(data);
            }
        });
    }
};