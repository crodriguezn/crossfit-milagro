var Model_Module = {
    loadModules: function( fSuccess, fFail )
    {
        Core.Ajax.post(
            Core.site_url( Base_Module.linkx + '/process/listmodules'),
            {},
            fSuccess,
            fFail
        );
    },
    loadModulesSubmodules: function( fSuccess, fFail )//OK
    {
        Core.Ajax.post(
            Core.site_url( Base_Module.linkx + '/process/list-modules-submodules'),
            {},
            fSuccess,
            fFail
        );
    },
    loadModule: function(id_module, fSuccess, fFail)
    {
        Core.Ajax.post(
            Core.site_url( Base_Module.linkx + '/process/load-module'),
            { id_module:id_module },
            fSuccess,
            fFail
        );
    },
    saveModule: function(data, fSuccess, fFail)
    {
        Core.Ajax.post(
            Core.site_url( Base_Module.linkx + '/process/save-module'),
            data,
            fSuccess,
            fFail
        );
    },
    loadComponentsModalModule: function( fSuccess, fFail )//OK
    {
        Core.Ajax.post(
            Core.site_url( Base_Module.linkx + '/process/load-components-modal-module'),
            {},
            fSuccess,
            fFail
        );
    },
    saveOrderModules: function( data, fSuccess, fFail )
    {
        Core.Ajax.post(
            Core.site_url( Base_Module.linkx + '/process/save-order-modules'),
            data,
            fSuccess,
            fFail
        );
    }
};