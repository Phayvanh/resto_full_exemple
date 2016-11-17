$(function()
{
    window.setTimeout(function()
    {
        $('#js-notice').fadeOut(2000)
    },3000);

    if($('#js-order-form').length>0)
    {
        setUpOrderForm();
    }

    if($('form').length > 0)
    {
        var formValidator = new FormValidator();

        formValidator.Run();
    }
});

