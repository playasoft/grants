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

    $('.delete-question').on('click', function(event)
    {
        event.preventDefault();

        if(confirm('Are you sure you want to delete this question and all answers to it?'))
        {
            window.location = $(this).attr('href');
        }
    });
});
