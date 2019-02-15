<?php

/**
 *
 * API client class
 *
 * @copyright Apereo
 * @category OpenLRW
 * @package  OpenLRW
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

use OpenLRW\Exception\GenericException;
use OpenLRW\Http\Client;

class ApiClient
{
    const VERSION = "1.0";

    private static $url;
    private static $key;
    private static $password;
    private static $token;
    public static $http;


    /**
     * ApiClient constructor
     *
     * @param string $url
     * @param string $key
     * @param string $password
     */
    public function __construct(string $url, string $key, string $password)
    {
        self::$url = $url;
        self::$key = $key;
        self::$password = $password;
        self::$http = new Client($url);
        self::$token = null;
    }

    /**
     * Set the credentials
     *
     * @param string $key
     * @param string $password
     */
    public function setCredentials(string $key, string $password)
    {
        self::$key = $key;
        self::$password = $password;
    }

    /**
     * Creates a JSON Web Token
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws GenericException
     */
    public static function generateJwt()
    {
        $route = 'api/auth/login';
        $header = ['X-Requested-With' => 'XMLHttpRequest'];
        $credentials = ['username' => self::$key, 'password' => self::$password];
        try {
            self::$token = self::$http->post($route, $header, $credentials);
        } catch(Exception $e) {
            throw new GenericException($e);
        }
    }

    public static function getJwt()
    {
        return self::$token;
    }


    /**
     * Make a JWT and create it if it is not set
     *
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     */
    public static function makeJwt()
    {
        if (!isset(self::$token))
           self::$token = self::generateJwt();

        return self::getJwt();
    }

    /**
     * @return string
     */
    public static function getKey()
    {
        return self::$key;
    }

}