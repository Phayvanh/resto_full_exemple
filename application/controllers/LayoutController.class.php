<?php

class LayoutController
{
    //fonction complète = httpGetMethod(Http $http, array $queryFields)
    public function httpGetMethod(Http $http, array $queryFields)
    {

        $userSession = new UserSession();

        return
            [
                'userSession' =>$userSession
                //l'indice représentera le nom de la variable dans la vue
            ];
    }
    public function httpPostMethod(Http $http, array $formFields)
    {
        $userSession = new UserSession();

        return
            [
                'userSession' =>$userSession
                //l'indice représentera le nom de la variable dans la vue
            ];

    }

}