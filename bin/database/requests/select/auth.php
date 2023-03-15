<?php

namespace bin\database\requests\select;

use \bin\epaphrodite\path\paths;
use bin\database\config\process;
use bin\epaphrodite\env\gestcookies;
use bin\epaphrodite\env\verify_chaine;
use bin\epaphrodite\auth\session_auth;
use bin\epaphrodite\define\text_messages;
use bin\epaphrodite\crf_token\csrf_secure;
use bin\database\requests\insert\if_not_exist;


class auth
{

  private $path;
  private $star;
  private $msg;
  private $secure;
  private $userbd;
  private $gethost;
  private $process;
  private $if_exist;
  private $verify_if_is_correct;

  /**
   * Get class 
   * @return void
   */
  function __construct()
  {

    $this->path = new paths;
    $this->process = new process;
    $this->star = new gestcookies;
    $this->msg = new text_messages;
    $this->secure = new csrf_secure;
    $this->userbd = new session_auth;
    $this->if_exist = new if_not_exist;
    $this->verify_if_is_correct = new verify_chaine;
  }

  /**
   * **********************************************************************************************
   * Querybilder constructor
   *
   * @return \bin\database\querybilder\querybuilder
   */
  private function QueryBuilder(): \bin\database\querybilder\querybuilder
  {
    return new \bin\database\querybilder\querybuilder();
  }

  /**
   * **********************************************************************************************
   * Verify if user_bd table exist in database
   * @return bool
   */
  public function if_table_exist(): bool
  {

    try {

      $sql = $this->QueryBuilder()
        ->table('user_bd')
        ->SQuery(NULL);

      $this->process->select($sql, NULL, NULL, false);

      return true;
    } catch (\Exception $e) {

      return false;
    }
  }

  /**
   * **********************************************************************************************
   * Verify if exist in database
   *
   * @param string $loginuser
   * @return void
   */
  public function verify_if_user_exist(string $loginuser)
  {

    if ($this->if_table_exist() === true) {

      $sql = $this->QueryBuilder()
        ->table('user_bd')
        ->where('loginuser_bd')
        ->SQuery(NULL);

      $result = $this->process->select($sql, 's', [$loginuser], true);

      return $result;
    } else {

      $this->if_exist->create_table();

      return NULL;
    }
  }

  /**
   * **********************************************************************************************
   * Verify authentification of user
   *
   * @param string $login
   * @param string $motpasse
   * @return bool
   */
  public function acces_manager(string $login, string $motpasse)
  {

    if (($this->verify_if_is_correct->only_number_and_character($login, $nbre = 12)) === false) {

      $users_datas = $this->verify_if_user_exist($login);

      if (!empty($users_datas)) {

        if (!empty($motpasse)) {

          $cryptermdp = hash('gost', $motpasse);
        }

        $hashpassword = $users_datas[0]["mdpuser_bd"];

        $loginPassword = 0;

        if ($cryptermdp === $hashpassword) {

          $loginPassword = 1;
        }

        if ($loginPassword === 1) {

          session_start();

          $_SESSION["id"] = $users_datas[0]["iduser_bd"];

          $_SESSION["login"] = $users_datas[0]["loginuser_bd"];

          $_SESSION["type"] = $users_datas[0]["type_user_bd"];

          $_SESSION["nom_prenoms"] = $users_datas[0]["nomprenoms_user"];

          $_SESSION["contact"] = $users_datas[0]["contact_user"];

          $_SESSION["email"] = $users_datas[0]["email_user"];

          $this->gethost = $this->path->dashboard();

          if ($this->secure->get_csrf($_COOKIE[$this->msg->answers('token_name')]) !== 0) {

            $this->star->set_user_cookies($this->secure->secure());
          }

          header("Location: $this->gethost ");
        } else if ($loginPassword == 0) {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}
