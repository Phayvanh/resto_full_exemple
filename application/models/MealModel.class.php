<?php

class MealModel
{
    public function listAll()
    {
        $database = new Database();

        return $database->findAll('Meal');
        //la methode findAll permet de récupérer toute les données dans un tableau 2D directement

    }

    public function findMeal($mealId)
    {
        $database = new Database();

        $sql = "SELECT Id, Name, Description, Photo, BuyPrice, SalePrice
                FROM Meal
                WHERE Id = ?";

        return $database->queryOne($sql,array($mealId));

    }

    public function findMealName($mealId)
    {
        $database = new Database();

        $sql = "SELECT Name
                FROM Meal
                WHERE Id = ?";

        $meal = $database->queryOne($sql,array($mealId));

        return $meal['Name'];
    }
}