<?php

/**
 *
 * Http Client
 *
 * @copyright Apereo
 * @category OpenLRW
 * @package  OpenLRW
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

namespace OpenLRW\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use OpenLRW\Exception\ExpiredJwtException;
use OpenLRW\Exception\GenericException;
use OpenLRW\Exception\NotFoundException;


class Client
{
    static private $http;

    public function __construct(string $uri)
    {
        self::$http = new GuzzleClient(['base_uri' => $uri]);
    }

    /**
     * Generic function to send HTTP GET requests
     *
     * @param string $route
     * @param array header
     * @return mixed|null
     * @throws \Exception
     */
    public function get(string $route, array $header = null)
    {
        try {
            return json_decode(self::$http->request('GET', $route, ['headers' => $header])->getBody()->getContents());
        } catch (GuzzleException $e) {
            if ($e->getCode() == 401) {
                throw new ExpiredJwtException();
            } else if ($e->getCode() == 404) {
                throw new NotFoundException();
            }
            throw new GenericException($e);
        }

    }

    /**
     * Generic function to send HTTP PATCH requests
     *
     * @param string $route
     * @param array $header
     * @param $json
     * @return mixed|null
     * @throws \Exception
     */
    public function patch(string $route, array $header, $json)
    {
        try {
            return self::$http->patch($route, ['headers' => $header, 'body' => $json])->getStatusCode();
        } catch (GuzzleException $e) {
            if ($e->getCode() == 401)
                throw new ExpiredJwtException();
            else if ($e->getCode() == 404)
                return null;
            throw new GenericException($e);
        }
    }

    /**
     * Generic function to send HTTP PATCH requests
     *
     * @param string $route
     * @param array $header
     * @param $json
     * @return mixed|null
     * @throws \Exception
     */
    public function post(string $route, array $header, $json)
    {
        try {
            return self::$http->patch($route, ['headers' => $header, 'body' => $json])->getStatusCode();
        } catch (GuzzleException $e) {
            if ($e->getCode() == 401)
                throw new ExpiredJwtException();
            else if ($e->getCode() == 404)
                return null;
            throw new GenericException($e);
        }
    }

    /**
     * Generic function to send HTTP PATCH requests
     *
     * @param String $route
     * @param array $header
     * @return mixed|null
     * @throws \Exception
     */
    public function delete(String $route, array $header)
    {
        try {
            return self::$http->delete($route, ['headers' => $header])->getStatusCode();
        } catch (GuzzleException $e) {
            if ($e->getCode() == 401)
                throw new ExpiredJwtException();
            else if ($e->getCode() == 404)
                return null;
            throw new GenericException($e);
        }
    }
}