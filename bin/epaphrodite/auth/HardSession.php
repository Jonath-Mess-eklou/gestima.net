<?php

namespace bin\epaphrodite\auth;

class HardSession {


    public function get( $id , $login , $nomprenoms , $contact , $email , $type ){

        $_SESSION["id"] = $id;

        $_SESSION["login"] = $login;

        $_SESSION["nom_prenoms"] = $nomprenoms;

        $_SESSION["contact"] = $contact;

        $_SESSION["email"] = $email;

        $_SESSION["type"] = $type;

    }

}