<?php

class ForgotController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {

    }

    public function httpPostMethod(Http $http, array $formFields)
    {
        $userModel = new UserModel();
        $userModel->sendResetPasswordMail($formFields['Email']);

        $http->redirectTo('/?success=ok&what=forgot');
    }
}