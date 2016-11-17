<?php

class OrderModel
{
    public function createOrder($userId)
    {
        $database = new Database();

        $sql = "INSERT INTO `Order`(User_Id,CreationTimestamp,TaxRate)
                VALUES (?, now(), 20)";

        $orderId = $database->executeSql($sql,array($userId));

        return $orderId;
    }

    public function completeOrder($orderId,array $basketItems)
    {
        $database = new Database();

        foreach($basketItems as $basketItem)
        {
            $sql = 'INSERT INTO OrderLine(Order_Id,Meal_Id,Quantity,UnitPrice)
                    VALUES (?,?,?,?)';

            $values =
                [
                    $orderId,
                    $basketItem['mealId'],
                    $basketItem['quantity'],
                    $basketItem['unitPrice']
                ];

            $database->executeSql($sql,$values);
        }
    }
}