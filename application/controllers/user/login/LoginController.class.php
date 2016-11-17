<?php

class LoginController
{
    public function  httpGetMethod(Http $http, array $queryFields)
    {
        return ['_form'=>new LoginForm()];
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
        try
        {
        $userModel = new UserModel();
        $user = $userModel->findUserWithEmailPassword($formFields['Email'],$formFields['Password']);

        $userSession = new UserSession();
        $userSession->Login($user['Id'],$user['FirstName'],$user['LastName'],$user['Email']);


        $http->redirectTo('/');
        }
        catch(DomainException $exception)
        {
            $form=new LoginForm();
            $form->setErrorMessage($exception->getMessage());
            $form->bind($formFields);

            return ['_form'=>$form];
        }
    }
}