<?php

class DeleteController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {

        if(array_key_exists('id',$queryFields) == true)
        {
            if(ctype_alnum($queryFields['id']) == true)
            {
                if(array_key_exists('orderId',$queryFields) == true)
                {
                    if(ctype_digit($queryFields['orderId']) == true)
                    {
                        $basketSession = new BasketSession();
                        $basketSession->removeFromBasket($queryFields['id']);

                        $http->redirectTo('/order?orderId='.$queryFields['orderId']);
                    }
                }
            }
        }

        $http->redirectTo('/');
    }
}