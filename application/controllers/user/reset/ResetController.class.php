<?php

class ResetController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        if(array_key_exists('id',$queryFields) == true)
        {
            if(ctype_digit($queryFields['id']) == true)
            {
                return
                    [
                        'UserId' => $queryFields['id']
                    ];
            }
        }
        $http->redirectTo('/');
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
        $userModel = new UserModel();
        $userModel->resetPassword
        (
            $formFields['Password'],
            $formFields['UserId']
        );
        $http->redirectTo('/?success=ok&what=reset');
    }
}