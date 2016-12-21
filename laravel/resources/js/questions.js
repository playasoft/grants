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

function timeSince(seconds)
{
    var difference = seconds * 1000;
    var minutes = Math.floor(difference / 1000 / 60);
    var hours = Math.floor(minutes / 60);
    var days = Math.floor(hours / 24);
    var text;

    if(days > 0) {
            text = days + "days";
    }
    else if(hours > 0) {
            text = hours + "hours";
    }
    else if(minutes > 0) {
            text = minutes + "minutes";
    }
    else {
            text = "now";
    }

    return text;
}
