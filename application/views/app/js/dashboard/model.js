var Activity_Model = {
    lastActivity: function (fSuccess, fFail)
    {
        Core.Ajax.post(
                Core.site_url(Dashboard_Base.linkx + '/process/last-activity'),
                {},
                fSuccess,
                fFail
                );
    }
};