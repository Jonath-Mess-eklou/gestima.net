<?php

namespace bin\database\config;

use PDO;
use PDOException;

class config
{

    /**
     * @var array
     */
    private $get_connexion;


    /**
     * @var array
     */
    private const OPTION =
    [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES  => false,
        PDO::ATTR_PERSISTENT => true
    ];

    /**
     * @var string
     * @return string
     */
    private static function ini_config()
    {

        $ini = _DIR_CONFIG_ . "/config.ini";
        $content = parse_ini_file($ini, true);

        return $content;
    }

    /**
     * Error message
     * @param string|null $type
     * 
     * @return mixed
     */
    private static function getError(?string $type = null)
    {

        $errors = new \bin\controllers\render\errors;

        $errors->error_500($type);
    }

    /**
     * @var string
     * @return string
     */
    private static function DB_DSN($db)
    {

        return SELF::ini_config()[$db . "DB_DSN"];
    }

    /**
     * @var string
     * @return string
     */
    private static function DB_OTHDSN($db)
    {

        return SELF::ini_config()[$db . "DB_OTHDSN"];
    }

    /**
     * @var string
     * @return string
     */
    private static function DB_PASS($db)
    {

        return SELF::ini_config()[$db . "DB_PASSWORD"];
    }

    /**
     * @var string
     * @return string
     */
    private static function DB_USER($db)
    {

        return SELF::ini_config()[$db . "DB_USER"];
    }

    /** 
     * Connect to databse 
     * @var int|1 $db
     * @return mixed
     */
    public static function epaphrodite_get_connexion(?int $db = 1)
    {
        // Try to connect to database to etablish connexion
        try {

            return new PDO(SELF::DB_DSN($db), SELF::DB_USER($db), SELF::DB_PASS($db), SELF::OPTION);

            // If impossible send error message    
        } catch (PDOException $e) {

            SELF::getError($e->getMessage());
        }
    }
}
