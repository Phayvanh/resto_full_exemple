<?php

class UserModel
{
    public function createUser($FirstName,$LastName,$BirthDate,$Address,$City, $ZipCode, $Phone, $Email, $Password)
    {
        $database = new Database();

        $sql='SELECT Id
              From User
              WHERE Email =?';

        $user = $database->queryOne($sql,[$Email]);

        if (empty ($user)==false)
        {
            throw new DomainException ('il existe deja un compte avec cette email');
        }

        $sql = 'INSERT INTO User(FirstName,LastName,Email,Password,Address,ZipCode,City,Phone,Birthday,CreationTimestamp)
                VALUES (?,?,?,?,?,?,?,?,?,now())';

        $values=
            [
                $FirstName,
                $LastName,
                $Email,
                $this->hashPassword($Password),
                $Address,
                $ZipCode,
                $City,
                $Phone,
                $BirthDate
            ];

        $database->executeSql($sql,$values);
    }

    private function hashPassword($password)
    {
        $salt = '$2y$11$'.substr(md5(uniqid(null,true)),0,22);
        //le but est de générer des chaînes différentes à chaque fois

        return crypt($password,$salt);
    }

    public function findUserWithEmailPassword($email,$password)
    {
        $user = $this->findUserWithEmail($email);

        if($this->verifyPassword($password,$user['Password']) == false)
        {
            throw new DomainException ('erreur mot de passe');
        }
        return $user;

    }

    private function verifyPassword($password,$hashedPassword)
    {
        return crypt($password,$hashedPassword) == $hashedPassword;
        //si le mot de passe en clair est le même que le mot de passe hashé alors on renvois true
    }

    public function findUserWithEmail($email)
    {
        $sql = 'SELECT Password, Id, FirstName, LastName, Email
                FROM User
                WHERE Email = ?';

        $database = new Database();

        $user = $database->queryOne($sql,array($email));

        if(empty($user) == true)
        {
            //code de gestion d'erreur si l'utilisateur n'existe pas avec ce mail
            throw new DomainException ('erreur email');
        }

        return $user;
    }

    public function sendResetPasswordMail($email)
    {
        $user = $this->findUserWithEmail($email);

    }

    public function resetPassword($password,$userId)
    {
        $hashedPassword = $this->hashPassword($password);

        $database = new Database();

        $sql = "UPDATE User
                SET Password = ?
                WHERE Id = ?";

        $values = [$hashedPassword,$userId];

        $database->executeSql($sql, $values);
    }
}