<?php

namespace bin\database\requests\select;


class auth
{

  private $path;
  private $msg;
  private $secure;
  private $session;
  private $Started;
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
    $this->path = new \bin\epaphrodite\path\paths;
    $this->process = new \bin\database\config\process;
    $this->session = new \bin\epaphrodite\auth\HardSession;
    $this->msg = new \bin\epaphrodite\define\SetTextMessages;
    $this->secure = new \bin\epaphrodite\crf_token\csrf_secure;
    $this->Started = new \bin\epaphrodite\auth\SetUsersCookies;
    $this->if_exist = new \bin\database\requests\insert\if_not_exist;
    $this->verify_if_is_correct = new \bin\epaphrodite\env\verify_chaine;
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
  public function UsersAuthManagers(string $login, string $motpasse)
  {

    if (($this->verify_if_is_correct->only_number_and_character($login, $nbre = 12)) === false) {

      $result = $this->verify_if_user_exist($login);

      if (!empty($result)) {

        if (!empty($motpasse)) {

          $cryptermdp = hash('gost', $motpasse);
        }

        $hashpassword = $result[0]["mdpuser_bd"];

        $loginPassword = 0;

        if ($cryptermdp === $hashpassword) {

          $loginPassword = 1;
        }

        if ($loginPassword === 1) {

          session_start();

          $this->session->get( $result[0]["iduser_bd"] , $result[0]["loginuser_bd"] , $result[0]["nomprenoms_user"] , $result[0]["contact_user"] , $result[0]["email_user"] , $result[0]["type_user_bd"]);

          $this->gethost = $this->path->dashboard();

          if ($this->secure->get_csrf($this->key()) !== 0) {

            $this->Started->set_user_cookies($this->key());
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

  /**
   * Current cookies value
   */
  private function key():string
  {
    return $_COOKIE[$this->msg->answers('token_name')];
  }

}
