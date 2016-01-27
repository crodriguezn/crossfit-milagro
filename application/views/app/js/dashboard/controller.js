

var myController = {
    init: function ()
    {
        var self = this;
        //setInterval(self.digiClock(), 1000);
        /*self.$page = $('#frm');
        $('.action-desacargar', self.$page).click(function ()
        {
            self.descargar();
        });*/
    }
    ,
    digiClock: function ()
    {
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
    myController.init();
});