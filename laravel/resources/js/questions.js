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

    // Useless button to make users feel better about ajax autosave
    $('.submit-answer button').on('click', function()
    {
        var status = $(this).parents('.submit-answer').find('.status');

        // Make it look like this button actually does something
        setTimeout(function()
        {
            status.removeClass('hidden');
        }, 300);
    });
});
