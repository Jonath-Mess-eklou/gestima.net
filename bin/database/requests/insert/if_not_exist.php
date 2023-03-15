<?php

namespace bin\database\requests\insert;

use \bin\database\config\process;

class if_not_exist
{

  protected $request;

  /**
   * **********************************************************************************************
   * Get class
   * @return void
   */
  function __construct()
  {
    $this->request = new process;
  }

  /**
   * **********************************************************************************************
   * Create recently users actions if not exist
   */
  private function create_recently_actions_if_not_exist()
  {

    $sql = "CREATE TABLE IF NOT EXISTS recente_actions (idrecenteactions int(11) NOT NULL auto_increment , usersactions varchar(20)NOT NULL , dateactions datetime , libactions varchar(300)NOT NULL , PRIMARY KEY(idrecenteactions) , INDEX (usersactions) )";

    $this->request->insert($sql, NULL, NULL, false);
  }

  /**
   * **********************************************************************************************
   * Create auth_secure if not exist
   */
  private function create_auth_secure_if_not_exist()
  {

    $sql = "CREATE TABLE IF NOT EXISTS auth_secure (idtoken_secure int(11) NOT NULL auto_increment , auth varchar(300)NOT NULL , auth_key varchar(200) NOT NULL , PRIMARY KEY(idtoken_secure) , INDEX (auth) )";

    $this->request->insert($sql, NULL, NULL, false);
  }

  /**
   * ********************************************************************************************** 
   * Create user if not exist
   */
  private function create_user_if_not_exist()
  {

    $sql = "CREATE TABLE IF NOT EXISTS user_bd (iduser_bd int(11) NOT NULL auto_increment , loginuser_bd varchar(20)NOT NULL , mdpuser_bd varchar(100) NOT NULL , nomprenoms_user varchar(150) DEFAULT NULL , contact_user varchar(10) DEFAULT NULL , email_user varchar(50) DEFAULT NULL , type_user_bd int(1) NOT NULL DEFAULT '1' , etat_userbd int(1) NOT NULL DEFAULT '1' , PRIMARY KEY(iduser_bd) , INDEX (loginuser_bd) )";

    $this->request->insert($sql, NULL, NULL, false);
  }

  /**
   * ********************************************************************************************** 
   * Create user if not exist
   */
  private function create_first_user_if_not_exist()
  {

    $sql = "INSERT INTO user_bd ( loginuser_bd , mdpuser_bd) VALUE ( ? , ?)";

    $this->request->insert($sql, 'ss', ['admin', '0e8cd409a23c2e7ad1c5b22b101dfa16720550dc547921c7a099b75c7f405fd4'], false);
  }

  /**
   * ********************************************************************************************** 
   * Create user right if not exist
   */
  private function create_user_right_if_not_exist()
  {

    $sql = "CREATE TABLE IF NOT EXISTS user_rights (iduser_rights int(11) NOT NULL auto_increment , modules varchar(200)NOT NULL  , idpages varchar(200)NOT NULL , idtype_user_rights int(11)NOT NULL  , menus varchar(200)NOT NULL , autorisations int(1)NOT NULL , PRIMARY KEY(iduser_rights) , INDEX (idtype_user_rights) , INDEX(menus) )";

    $this->request->insert($sql, NULL, NULL, false);
  }


  /** 
   * **********************************************************************************************
   * Create user and auth_secure if not exist
   */
  public function create_table()
  {

    $this->create_user_right_if_not_exist();

    $this->create_user_if_not_exist();

    $this->create_first_user_if_not_exist();

    $this->create_auth_secure_if_not_exist();

    $this->create_recently_actions_if_not_exist();
  }
}
