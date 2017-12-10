var $ = require('wetfish-basic');
var timeout = false;

// Function to save form data
function save(scope)
{
    var form = $(scope).parents('form.ajax');
    var status = $(scope).parents('.form-group').find('.status');
    var value = $(scope).value();
    var input = $(scope);

    // Check if this is a radio button and is selected
    if(input.attr('type') == 'radio' && input.prop('checked'))
    {
        value = "checked";
    }

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

}

$(document).ready(function()
{
    // On load, populate current data values
    $('form.ajax').find('input, select, textarea').each(function()
    {
        var value = $(this).value();
        $(this).data('saved', value);
    });

    // Automatically save answers on user input
    $('form.ajax').find('input, select, option, textarea').on('keydown keyup click change', function(event)
    {
        var status = $(this).parents('.form-group').find('.status');
        var scope = this;

        // Clear timeout to debounce user input
        if(timeout)
        {
            clearTimeout(timeout);
        }

        status.text('Waiting for changes...');
        status.attr('class', 'status waiting');

        // After 500 milliseconds without user input, save
        timeout = setTimeout(function()
        {
            save(scope);
        }, 500);
    });

    // Automatically save answer when user clicks away from a field
    $('form.ajax').find('input, select, option, textarea').on('blur', function(event)
    {
        save(this);
    });
});
