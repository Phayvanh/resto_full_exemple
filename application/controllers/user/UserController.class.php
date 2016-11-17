<?php

class UserController
{
    //fonction complète = httpGetMethod(Http $http, array $queryFields)
    public function httpGetMethod(Http $http, array $queryFields)
    {
        return ['_form'=>new UserForm()];
    }

    //fonction complète = httpPostMethod(Http $http, array $formFields)
    public function httpPostMethod(Http $http, array $formFields)
    {
        try
        {
            $usermodel = new UserModel();

            $birthday = $formFields['Birth-Year'].'-'.$formFields['Birth-Month'].'-'.$formFields['Birth-Day'];

            $usermodel->createUser
                (
                    $formFields['FirstName'],
                    $formFields['LastName'],
                    $birthday,
                    $formFields['Address'],
                    $formFields['City'],
                    $formFields['ZipCode'],
                    $formFields['Phone'],
                    $formFields['Email'],
                    $formFields['Password']
                );
            $http->redirectTo('/');
        }
        catch(DomainException $exception)
        {
            $form=new UserForm();
            $form->setErrorMessage($exception->getMessage());
            $form->bind($formFields);

            return ['_form'=>$form];
        }
    }
}