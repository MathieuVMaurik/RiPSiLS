/**
 * Created by Mathieu on 17-11-2014.
 */


var script = document.createElement('script');
script.src = 'http://code.jquery.com/jquery-1.11.0.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

$(function () {
    $(".rulesresize").click(function() {
        var img = $(".rulesimg");

        if (img.width() < 200)
        {
            img.animate({width: "250px", height: "250px"}, 750);
        }
        else
        {
            img.animate({width: "50px", height: "50px"}, 750);
        }
    });

});