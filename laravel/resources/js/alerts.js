var $ = require('wetfish-basic');
var interval;
var seconds = 0;

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

    // Populate seconds remaining on page load

    if($('.round-ending').el.length)
    {
        seconds = parseInt($('.round-ending').data('seconds'));

        // Update the notification every 60 seconds
        interval = setInterval(updateTime, 60 * 1000);
    }
});

function updateTime()
{
    seconds -= 60;

    if(seconds < 0)
    {
        seconds = 0;
    }

    var difference = seconds * 1000;
    var minutes = Math.floor(difference / 1000 / 60);
    var hours = Math.floor(minutes / 60);
    var days = Math.floor(hours / 24);
    var value;
    var type;

    if(days > 0)
    {
        value = days;
        type = "day";
    }
    else if(hours > 0)
    {
        value = hours;
        type = "hour";
    }
    else if(minutes > 0)
    {
        value = minutes;
        type = "minute";        
    }

    // Add an "s" when the value is plural
    if(value != 1)
    {
        type += "s";
    }

    if(value)
    {
        $('.round-ending .time-remaining').text(value + " " + type);
    }
    else
    {
        alert("Application submission is now closed!");
        clearInterval(interval);
    }

    $('.round-ending').data('seconds', seconds);
}
