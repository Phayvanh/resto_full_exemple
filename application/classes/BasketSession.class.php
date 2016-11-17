<?php

class BasketSession
{
    public function __construct()
    {//si le statut de la session est vide ou n'a pas démarrer
        if(session_status() == PHP_SESSION_NONE)
        {//on démarre la session
            session_start();
        }
    }

    public function createBasket()
    {
        $_SESSION['Basket'] = array();

    }

    public function destroyBasket()
    {
        $_SESSION['Basket'] = array();
    }

    public function getBasket()
    {
        if(array_key_exists('Basket',$_SESSION) == false)
        {
            return array();
        }

        return $_SESSION['Basket'];
    }

    public function addToBasket($mealId,$quantity,$unitPrice)
    {
        for($index = 0;$index<count($_SESSION['Basket']);$index++)
        {
            if($_SESSION['Basket'][$index]['mealId'] == $mealId)
            {
                $_SESSION['Basket'][$index]['quantity'] += $quantity;

                return;//on retourne pour quitter la boucle directement après modification
            }
        }

        array_push($_SESSION['Basket'],
            [//on créé un tableau imbriqué ex: $_SESSION['Basket'][0]['quantity']
                'mealId'    =>$mealId,
                'quantity'  =>$quantity,
                'unitPrice' =>$unitPrice,
                'id'        =>uniqid()//on utilise uniqid() pour pouvoir cibler les données
            ]);
    }


    public function isBasketEmpty()
    {
        if(array_key_exists('Basket',$_SESSION) == false)
        {
            return false;
        }

        return empty($_SESSION['Basket']);
    }

    public function removeFromBasket($id)
    {
        for($index = 0;$index<count($_SESSION['Basket']);$index++)
        {
            if($_SESSION['Basket'][$index]['id'] == $id)
            {
                array_splice($_SESSION['Basket'],$index,1);
                //on se place là où on veut retirer l'élément qu'on veut

                return;//on retourne pour quitter la boucle directement après modification
            }
        }

    }
}