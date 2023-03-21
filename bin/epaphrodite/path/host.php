<?php

namespace bin\epaphrodite\path;

class host
{

  protected $host;
  protected $domaine;

  /**
   * Get domaine of website
   * @return string
   */
  private function domain()
  {

    $this->domaine = "epaphrodite-framework";

    return $this->domaine;
  }

  /**
   * Host link path
   * @return string
   */
  public function host()
  {

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    $this->host = $protocol . $_SERVER['HTTP_HOST'] . '/' . $this->domain() . '/';

    return $this->host;
  }
}
