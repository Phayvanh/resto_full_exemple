function setUpOrderForm()
{
    //a chaque fois qu'une option sera selectionné le thème changera
    $('#js-meal').on('change', onChangeMeal).trigger('change');

    if($('#js-basket-empty').length > 0)
    {
        $('#js-order').attr('disabled',true);
    }

    $('form').fadeIn(200);
}

function onMealChanged(meal)
{
    $('#js-meal-details p').text(meal.Description);
    $('#js-meal-details img').attr('src',getWwwUrl()+'/images/meals/'+meal.Photo);
    $('#js-meal-details strong').text(meal.SalePrice);
    $('#js-unit-price').val(meal.SalePrice);
}

function onChangeMeal()
{
    var mealId;

    mealId = $(this).val();

    $.ajax(getRequestUrl()+'/meal?mealId='+mealId,//on indique l'url + la valeur de mealId
    {
        dataType: 'json',//on a besoin d'une propriété json
        success: onMealChanged
    });
}
