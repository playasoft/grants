var $ = require('wetfish-basic');

// Function to determine if something is on the screen or not
function onScreen(element)
{
    var position = $(element).position();
    var scroll = $(window).scroll();

    // The bottom of the screen is the scroll top plus the window height
    scroll.bottom = scroll.top + $(window).height();

    // The bottom of the element is the top position plus the element height
    position.bottom = position.top + $(element).height();

    // If the element is above the bottom of the screen but below the top
    if(scroll.bottom > position.top && scroll.top < position.bottom)
    {
        return true;
    }

    return false;
}

// Whenever we scroll
$(window).on('scroll', function()
{
    // Loop through all score elements on the page
    $('.score').each(function()
    {
        // Is this element currently being displayed?
        if(onScreen(this))
        {
            // Make sure the value has been saved
            $(this).find('input, select, option, textarea').trigger('blur');
        }
    });
});
