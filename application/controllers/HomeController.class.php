<?php

class HomeController
{
    //fonction complète = httpGetMethod(Http $http, array $queryFields)
    public function httpGetMethod(Http $http, array $queryFields)
    {
        $mealmodel = new MealModel();
        $meals = $mealmodel->listAll();
        //on récupère tout les aliments dans un nouveau tableau


        $success = false;
        $what = null;

        if(array_key_exists('success',$queryFields) == true)
        {//si 'success' existe dans la querystring
         //et si 'success' = 'ok'
            if($queryFields['success'] == 'ok')
            {
                $success = true;
            }
        }


        if(array_key_exists('what',$queryFields) == true)
        {//'si 'what' existe dans la querystring
            switch($queryFields['what'])
            {//dans le cas ou 'what' = 'booking'
                case 'booking':
                $what = "Votre réservation à bien été pris en compte";
                break;

                case 'forgot':
                $what = "Votre mot de passe à été modifié";
                break;
            }
        }

        return
        [
            'meals' =>$meals,
            'success' =>$success,
            'what' =>$what,
        //l'indice représentera le nom de la variable dans la vue
        ];
    }

}