var $ = require('wetfish-basic');
var timeout = false;

$(document).ready(function()
{
    $('form.ajax').find('input, select, option, textarea').on('keydown click change', function(event)
    {
        var form = $(this).parents('form.ajax');
        var status = $(this).parents('.form-group').find('.status');
        
        if(timeout)
        {
            clearTimeout(timeout);
        }

        status.text('Waiting for changes...');
        status.attr('class', 'status waiting');
        
        timeout = setTimeout(function()
        {
            status.text('Saving...');

            // Get form data
            var formData = new FormData(form.el[0]);

            // Submit data
            fetch(form.attr('action'), {method: 'POST', credentials: 'include', body: formData}).then(function(response)
            {
                status.text('Saved!');
                status.attr('class', 'status success');

                // Fade the saved text out after 1 second
                setTimeout(function()
                {
                    status.addClass('complete');
                }, 1000);
            });
        }, 500);
    });
});
