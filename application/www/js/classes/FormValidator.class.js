var FormValidator = function()
{
    this.totalErrors = null;
    //on créé la propriété qui est initialisé par un tableau vide
};


FormValidator.prototype.checkRequiredFields = function()
{
    var errors = new Array();
    //on créé un nouveau tableau pour récupérer les erreurs

    $('form [data-required]').each(function()
    {//on parcour toutes les erreurs des enfants du formulaire dont l'attribut est data-required
        var value;

        value = $(this).val().trim();//value récupère les données sans espace grâce à la méthode trim

        if(value.length == 0)
        {//si value est vide
            errors.push(//on ajoute au tableau un message d'erreur
            {
               formField: $(this).data('name'),//formField vaudra la chaîne de data-name
               message: 'est requis'
            });
        }
    });

    $.merge(this.totalErrors,errors);
    //on fusionne les 2 tableau pour que totalErrors récupère les données du tableau errors
};

FormValidator.prototype.checkDataTypes = function()
{
    var errors = new Array();
    //on créé un nouveau tableau pour récupérer les erreurs

    $('form [data-type]').each(function()
    {//on parcour toutes les erreurs des enfants du formulaire dont l'attribut est data-type
        var value;

        value = $(this).val().trim();//value récupère les données sans espace grâce à la méthode trim

        switch ($(this).data('type'))
        {//on pointe le selecteur sur tout les data-type
            case 'number'://dans le cas où le data est number
            if(isNumber(value) == false)
            {
                errors.push(//on ajoute au tableau un message d'erreur
                    {
                        formField: $(this).data('name'),//formField vaudra la chaîne de data-name
                        message: 'doit être un nombre'
                    });
            }
            break;

            case 'positive-integer':
            if(isInteger(value) == false || value <=0)
            {
                errors.push(//on ajoute au tableau un message d'erreur
                    {
                            formField: $(this).data('name'),//formField vaudra la chaîne de data-name
                            message: 'doit être un entier positif'
                    });
            }
            break;
        }
    });

    $.merge(this.totalErrors,errors);
    //on fusionne les 2 tableau pour que totalErrors récupère les données du tableau errors
};

FormValidator.prototype.checkMinimumLength = function()
{
    var errors = new Array();
    //on créé un nouveau tableau pour récupérer les erreurs

    $('form [data-length]').each(function()
    {//on parcour toutes les erreurs des enfants du formulaire dont l'attribut est data-length
        var value;
        var minData = $(this).data('length');
        //on récupère la valeur de l'attibut data-length

        value = $(this).val().trim();//value récupère les données sans espace grâce à la méthode trim


        if(value.length < minData)
        {
            errors.push(//on ajoute au tableau un message d'erreur
            {
                formField: $(this).data('name'),//formField vaudra la chaîne de data-name
                message: 'doit faire au moins '+minData+' caractère'
            });
        }
    });

    $.merge(this.totalErrors,errors);
    //on fusionne les 2 tableau pour que totalErrors récupère les données du tableau errors
};

FormValidator.prototype.onSubmitForm = function()
{
    $('.error-message p').empty();
    this.totalErrors = new Array();

    this.checkRequiredFields();
    this.checkDataTypes();
    this.checkMinimumLength();


    if(this.totalErrors.length > 0)
    {//y'a t-il eu des erreur dans le formulaire ?
        this.totalErrors.forEach(function(error)
        {
            var message;

            message='le champ "'+error.formField+'" '+error.message+'.<br>';

            $('.error-message p').append(message);
        });

        $('#js-total-error-count').text(this.totalErrors.length);

        $('.error-message').fadeIn('slow');//on affiche la boite de message d'erreur(s)

        return false;
    }
    return true;
};

FormValidator.prototype.Run = function()
{
    $('form[data-validate="true"]').on('submit',this.onSubmitForm.bind(this));
    //on pointe le selecteur vers tous les formulaires qui ont l'attribut data-validate="true"
    if($('.error-message p').text().length > 0)
    {//s'il y a du text dans la balise p
        $('.error-message').fadeIn('slow');//on affiche la boite de message d'erreur(s)
    }
};

