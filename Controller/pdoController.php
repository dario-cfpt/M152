<?php
/**
 * Created by PhpStorm.
 * User: GENGAD_INFO
 * Date: 21.02.2018
 * Time: 15:36
 */

abstract class pdoController {

    private static $pdoInstance;

    const DB_USER = 'blogUserM152';
    const DB_PASSWORD = 'Super';
    const DB_HOST = 'localhost';
    const DB_NAME = 'm121blog';

    /**
     * Get an unique PDO instance
     * @return PDO
     * @throws Exception
     */
    public static function GetInstance() {
        try {
            if (self::$pdoInstance == null) {
                self::$pdoInstance = new PDO(
                    'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME,
                    self::DB_USER,
                    self::DB_PASSWORD,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true)
                );
            }
            return self::$pdoInstance;
        } catch (Exception $e) {
            throw new Exception("Can't connect to the database");
        }

    }
}