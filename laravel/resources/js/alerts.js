var $ = require('wetfish-basic');

$(document).ready(function()
{
    $('.delete-question, .delete-criteria').on('click', function(event)
    {
        event.preventDefault();

        if(confirm('Are you sure you want to delete this question and all answers to it?'))
        {
            window.location = $(this).attr('href');
        }
    });
});
