var lastActivity_Controller = {
    init: function ()
    {
        var self = this;
        self.$activity = $('.last-activity');
        self.eventLoadActivity();
    },
    eventLoadActivity: function ()
    {
        var self = this;

        Core.Loading.wait(true, $('.block', self.$activity));

        Activity_Model.lastActivity(
                function (res)
                {
                    Core.Loading.wait(false, $('.block', self.$activity));
                    self.htmlLastActivity(res);
                },
                function ()
                {
                    Core.Loading.wait(true, $('.block', self.$activity));
                }
        );
    },
    htmlLastActivity: function (res)
    {
        if (!res.isSuccess)
        {
            Core.Notification.error(res.message);
            return;
        }

        //$('.sortable-module').html('');
        var self = this;
        var data = res.data;

        $('.media-list', self.$activity).html('');

        $.each(data.activity, function (i, value) {

            var $element = $('[element="last-activity"] li').clone();


            $('img', $element).attr('src', value.picture);
            $('.media-heading', $element).html(value.user);
            //$('.media-notice',$element).html(Activity_View.actionTable(value.action));
            $('.media-notice', $element).html(value.time);
            $('.media-body p', $element).html(Activity_View.actionTable(value.action, value.ip, value.browser));

            $('.media-list', self.$activity).append($element);
        });
    }
};

var digiClock_Controller = {
    init: function ()
    {
        var self = this;

    }
    ,
    digiClock: function ()
    {
        var self = this;
        var crTime = new Date();
        var crHrs = crTime.getHours();
        var crMns = crTime.getMinutes();
        var crScs = crTime.getSeconds();
        crMns = (crMns < 10 ? "0" : "") + crMns;
        crScs = (crScs < 10 ? "0" : "") + crScs;
        $("#hours").html(crHrs);
        $("#minutes").html(crMns);
        $("#seconds").html(crScs);
    }

};

Core.addInit(function ()
{
    digiClock_Controller.init();
    lastActivity_Controller.init();
});