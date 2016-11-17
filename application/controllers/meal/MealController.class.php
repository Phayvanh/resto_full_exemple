<?php

class MealController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
        if(array_key_exists('mealId',$queryFields) == true)
        {
            if(ctype_digit($queryFields['mealId']) == true)
            {
                $mealModel = new MealModel();
                $meal = $mealModel->findMeal($queryFields['mealId']);

                $http->sendJsonResponse($meal);
                //renvois des données sous forme de données simple(json) autre que du html
            }
        }
        $http->redirectTo('/');
        //en cas d'erreur on redirige vers la page d'accueil
    }
}