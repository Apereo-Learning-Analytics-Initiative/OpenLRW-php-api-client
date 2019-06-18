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

namespace OpenLRW;
use OpenLRW\Exception\GenericException;
use OpenLRW\Http\Client;

class OpenLRW
{

    private static $url;
    private static $key;
    private static $password;
    private static $token;
    private static $http;


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
    public static function setCredentials(string $key, string $password)
    {
        self::$key = $key;
        self::$password = $password;
    }

    /**
     * Is the server up?
     * @return bool
     */
    public static function isUp()
    {
        try {
            $response = self::$http->get('/actuator/health');
            return $response->status === 'UP';
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the indicator status of the server
     * @return bool
     */
    public static function serverStatus()
    {
        try {
            $response = self::$http->get('/actuator/health');
            return $response->status === 'UP';
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function changeServerStatus(



        /**
         * Creates a JSON Web Token
         *
         * @return mixed|\Psr\Http\Message\ResponseInterface
         * @throws GenericException
         * @throws \Exception
         */
    public static function generateJwt()
    {
        $route = 'api/auth/login';
        $credentials = ['username' => self::$key, 'password' => self::$password];
        try {
            self::$token = self::$http->post($route, $credentials)->token;
            return self::$token;
        } catch(Exception $e) {
            throw new GenericException("Server is down or credentials are invalid.");
        }
    }

    public static function getJwt() : string
    {
        return self::$token;
    }


    /**
     * Check if a JWT is already stored, create another if not
     * It is supposed to make less queries for web applications
     *
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public static function smartJwt() : string
    {
        if (!isset(self::$token)) {
            self::$token = self::generateJwt();
        }

        return self::getJwt();
    }

    /**
     * @return string
     */
    public static function getKey() : string
    {
        return self::$key;
    }

    public static function httpGet($route, $header)
    {
        return self::$http->get($route, $header);
    }

    public static function httpDelete($route, $header)
    {
        return self::$http->delete($route, $header);
    }

    public static function httpPost($route, $data, $header)
    {
        return self::$http->post($route, $data, $header);
    }

    public static function httpPatch($route, $data, $header)
    {
        return self::$http->patch($route, $data, $header);
    }

    public static function guzzlePost($route, $args)
    {
        return self::$http->legacyPost($route, $args);
    }

}