//for applications list page;

var $ = require('wetfish-basic');

$(document).ready(function()
{   
    $('.appTitle').each(function()
    {
        $(this).on('click', function()
        {
             $(this.nextElementSibling).toggle('hidden');
        });
    });
});