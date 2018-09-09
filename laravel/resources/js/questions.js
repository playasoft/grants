$ = require('wetfish-basic');
Vue = require('Vue');

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

    // Create vue form component for any vue-form class on the page
    var vueBudget = Array.from(document.querySelectorAll('.vue-budget'));

    if(vueBudget.length > 0)
    {
        // Make a new vue component for each found vue budget class
        vueBudget.forEach(function(vueBudgetEl)
        {
            let vm = new Vue(
            {
                el:vueBudgetEl,

                data :function()
                {
                    return {
                        outputString: "",
                        fields:[],
                        total: 0
                    }
                },

                mounted :function()
                {
                    let preFilledAnswer = this.$el.getAttribute('answer');

                    if(preFilledAnswer)
                    {
                        // Takes the answer string from the "answer" data attribute and parses/maps it into cost:, description:,
                        this.$set(this, 'fields', JSON.parse(preFilledAnswer));
                    }
                },

                methods:
                {
                    inputChanged:function()
                    {
                        let newOutput = JSON.stringify(this.fields);
                        this.$set(this, 'outputString' , newOutput);

                        // Trigger AJAX autosave behavior
                        $(this.$el).find('[name="answer"]').trigger('change');
                        this.fieldTotal();
                    },

                    addField:function()
                    {
                        this.fields.push({cost:0,description:""});
                    },

                    removeField:function(index)
                    {
                        this.fields.splice(index, 1);
                        this.inputChanged();
                    },

                    fieldTotal:function()
                    {
                        let total = 0;

                        // Iterate through all current fields on change and add up the cost
                        this.fields.forEach(function(field)
                        {
                            total += parseInt(field.cost);
                        });

                        this.$set(this, 'total' , total);
                    }
                }
            });

            // To make sure there's a total on page load
            vm.fieldTotal();
        })
    }
});
