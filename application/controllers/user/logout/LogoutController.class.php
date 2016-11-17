<?php

class LogoutController
{
    public function  httpGetMethod(Http $http, array $queryFields)
    {
        $userSession = new UserSession();
        $userSession->logout();

        $http->redirectTo('/');
    }

}