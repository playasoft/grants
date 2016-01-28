$ = require('wetfish-basic');

$(document).ready(function()
{
    $('.answer-type').on('change', function()
    {
        if($(this).value() == 'dropdown')
        {
            $('.question-options').removeClass('hidden');
        }
        else
        {
            $('.question-options').addClass('hidden');
        }
    });
});
