/**
 * Created by Mathieu on 17-11-2014.
 */

$(function ()
{

    $('#rulesimg').on('click', function ()
    {
        if(this.width <= 250) {
            $(this).width(300);
        }
        else
        {
            $(this).width(50);
        }
    });
});