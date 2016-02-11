var $ = require('wetfish-basic');
var timeout = false;

$(document).ready(function()
{
    // On load, populate current data values
    $('form.ajax').find('input, select, textarea').each(function()
    {
        var value = $(this).value();
        $(this).data('saved', value);
    });

    $('form.ajax').find('input, select, option, textarea').on('keydown click change', function(event)
    {
        var form = $(this).parents('form.ajax');
        var status = $(this).parents('.form-group').find('.status');
        var value = $(this).value();
        var input = $(this);

        // Check if this is a radio button and is selected
        if(input.attr('type') == 'radio' && input.prop('checked'))
        {
            value = "checked";
        }

        if(timeout)
        {
            clearTimeout(timeout);
        }

        status.text('Waiting for changes...');
        status.attr('class', 'status waiting');
        
        timeout = setTimeout(function()
        {
            console.log(value, input.data('saved-value'));

            // If no changes have been made, abort
            if(input.data('saved') == value)
            {
                // Fade the saved text out after 1 second
                setTimeout(function()
                {
                    status.addClass('complete');
                }, 1000);

                return;
            }

            status.text('Saving...');

            // Get form data
            var formData = new FormData(form.el[0]);

            // Submit data
            fetch(form.attr('action'), {method: 'POST', credentials: 'include', body: formData}).then(function(response)
            {
                status.text('Saved!');
                status.attr('class', 'status success');

                // Don't save value for radio inputs
                if(input.attr('type') != 'radio')
                {
                    input.data('saved', value);
                }

                // Fade the saved text out after 1 second
                setTimeout(function()
                {
                    status.addClass('complete');
                }, 1000);
            });
        }, 500);
    });
});
