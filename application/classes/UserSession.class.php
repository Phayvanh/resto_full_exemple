<?php

class UserSession
{
    public function __construct()
    {//si le statut de la session est vide ou n'a pas démarrer
        if(session_status() == PHP_SESSION_NONE)
        {//on démarre la session
            session_start();
        }
    }

    public function Login($id,$firstname,$lastname,$email)
    {
        $_SESSION['User'] =
        [//on instanci un tableau de session user avec un autre tableau qui contient les informations du user
            'Id' => $id,
            'FirstName' => $firstname,
            'LastName' => $lastname,
            'Email' => $email
        ];

        $sql = 'UPDATE User
                SET LastLoginTimestamp = now()
                WHERE Id = ?';
        //on met à jour la connexion de l'user

        $databalse = new Database();

        $databalse->executeSql($sql,array($id));

        return true;
    }

    public function GetData($key = null)
    {
        if($key == null)
        {//si la clé est null
            return $_SESSION['User'];
        }//on retourne le tableau de session de user
        else
        {
            if(array_key_exists($key,$_SESSION['User']) == true)
            {//si la clé existe dans le tableau de session user
                return $_SESSION['User'][$key];
            }//on retourne le tableau de session user avec la clé
            else if($key == 'FullName')
                {//sinon si la clé est égale au prénom+nom
                    return $_SESSION['User']['FirstName'].' '.$_SESSION['User']['LastName'];
                }//on retourne le nom complet
                else
                {
                    return null;
                }
        }
    }

    public function IsAuthenticated()
    {
        if(array_key_exists('User',$_SESSION) == true)
        {//si la clé existe dans le tableau de session user
            if (empty ($_SESSION['User'])==false)
            {
            return true;
            }
        }
        return false;
    }

    public function Logout()
    {
        $_SESSION['User']=array();
        session_destroy();

        return true;
    }
}