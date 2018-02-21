<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 21.02.2018
 * Time: 15:36
 */

abstract class pdoController {

    private static $pdoInstance;

    /**
     * Get an unique instance for pdo
     * @param $dbHost
     * @param $dbName
     * @param $dbUser
     * @param $dbPassword
     * @return mixed
     */
    public static function GetInstance($dbHost, $dbName, $dbUser, $dbPassword) {
        if (self::$pdoInstance == null) {
            self::$pdoInstance = new PDO(
                'mysql:host=' . $dbHost . ';dbname=' . $dbName,
                $dbUser,
                $dbPassword,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true)
            );
        }
        return self::$pdoInstance;
    }
}