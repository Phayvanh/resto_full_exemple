

function isNumber(value)
{
   return isNaN(value)==false;
}

function isInteger(value)
{
    if(isNumber(value)==true)
{
        //le reste d une division part 1 doit etre nul pour un entier
    if(value % 1 == 0)
    {

        return true
    }

}
    return false;
}

function getRequestUrl()
{
    var requestUrl;
    requestUrl = window.location.href;
    //représente l'ensemble de la barre d'adresse où il y a des propriétés

    requestUrl = requestUrl.substr(0,requestUrl.indexOf('/index.php')+10);
    //la variable récupère la chaine de caractère

    return requestUrl;
}

function getWwwUrl()
{
    var wwwUrl;
    wwwUrl = window.location.href;

    wwwUrl = wwwUrl.substr(0,wwwUrl.indexOf('/index.php'))+'/application/www';
    //la variable récupère la chaine de caractère

    return wwwUrl;
}