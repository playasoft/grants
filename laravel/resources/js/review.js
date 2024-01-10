var $ = require('wetfish-basic');

$(document).ready(function()
{
    $('.application-status input').on('change', function()
    {
        const status = $(this).value();

        if(status == 'approve') {
            $('.denied').addClass('hidden');
            $('.approved').removeClass('hidden');
        } else if(status == 'deny') {
            $('.denied').removeClass('hidden');
            $('.approved').addClass('hidden');
        }
    });
});
