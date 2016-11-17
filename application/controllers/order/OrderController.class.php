<?php

class OrderController
{
    private function addToOrder(array $formfiels)
    {
        $basketSession = new BasketSession();

        if($formfiels['orderId'] == -1)
        {//est-ce-qu'il s'agit d'une nouvelle commande ?

            $userSession = new UserSession();
            $orderModel = new OrderModel();

            $orderId = $orderModel->createOrder($userSession->GetData('Id'));

            $basketSession->createBasket();
            //oui on créé un nouveau panier
        }
        else
        {//non on récupère l'identifiant stocké dans le formulaire
            $orderId = $formfiels['orderId'];
        }

        $basketSession->addToBasket($formfiels['meal'],$formfiels['quantity'],$formfiels['unitPrice']);


        return "/order?orderId=$orderId";//on retourne la chaine de caractère "/order" pour la redirection
                                        //vers le formulaire de commande
    }

    private function Order(array $formfiels)
    {
        $orderModel = new OrderModel();
        $basketSession = new BasketSession();

        $orderModel->completeOrder($formfiels['orderId'],$basketSession->getBasket());

        return "/order/payment/success";
    }

    public function httpGetMethod(Http $http, array $queryFields)
    {
        $mealModel = new MealModel();
        $basketSession = new BasketSession();

        if(array_key_exists('orderId',$queryFields) == true &&
           ctype_digit($queryFields['orderId']) == true)
        {
                $orderId = $queryFields['orderId'];
                //si une id existe déjà dans la queryfield on la récupère dans une variable
        }
        else
        {
            $orderId = -1;
            //sinon s'il n'y a pas d'id on initialise la variable à -1
            $basketSession->destroyBasket();
        }

        return
        [
            '_form' => new OrderForm(),
            'orderId' => $orderId,
            'basketSession' => $basketSession,
            'mealModel' => $mealModel
        ];
    }


    public function httpPostMethod(Http $http, array $formFields)
    {
        $userSession = new UserSession();

        if($userSession->IsAuthenticated('User',$_SESSION) == false)
        {
            $http->redirectTo('/user/login');
        }

        if($formFields['action'] == 'Ajouter')
        {//la gestion du bouton Ajouter
            $url = $this->addToOrder($formFields);
            //on récupère dans une variable le résultat retourné par la méthode addToOrder
        }
        else
        {//sinon la gestion du bouton commander
            $url = $this->Order($formFields);
        }

        $http->redirectTo($url);

    }
}