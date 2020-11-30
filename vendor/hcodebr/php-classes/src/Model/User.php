<?php

namespace Nutri\Model;

use \Nutri\DB\Sql;
use \Nutri\Model;

class User extends Model{

    const SESSION = "User";

    public static function login($login, $password)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM usuario WHERE login = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        if (count($results) === 0)
        {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }

        $data = $results[0];

        if (password_verify($password, $data["senha"]) === true )
        {
         
            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getValues();

            return $user;
        
        } else {

            throw new \Exception("Usuário inexistente ou senha inválida.");

        }
    }

    public static function verifyLogin($idtipousuario = 1)
    {

        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["idusuario"] > 0
            ||
            (int)$_SESSION[User::SESSION]["idtipousuario"] !== $idtipousuario
        ) {
            header("Location: /admin/login");
            exit;
        }

    }

    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;
    }

}


?>