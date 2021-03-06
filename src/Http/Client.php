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
use OpenLRW\Exception\InternalServerErrorException;
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
            switch ($e->getCode()) {
                case 401:
                    throw new ExpiredJwtException($e->getMessage());
                    break;
                case 404:
                    throw new NotFoundException($e->getMessage());
                    break;
                case 500:
                    throw new InternalServerErrorException($e->getMessage());
                    break;
                default:
                    throw new GenericException($e->getMessage());
                    break;
            }
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
            switch ($e->getCode()) {
                case 401:
                    throw new ExpiredJwtException($e->getMessage());
                    break;
                case 404:
                    throw new NotFoundException($e->getMessage());
                    break;
                case 500:
                    throw new InternalServerErrorException($e->getMessage());
                    break;
                default:
                    throw new GenericException($e->getMessage());
                    break;
            }
        }
    }

    /**
     * Generic function to send HTTP POST requests
     *
     * @param string $route
     * @param array $header
     * @param $json
     * @return mixed|null
     * @throws \Exception
     */
    public function post(string $route, array $json, array $header = ['X-Requested-With' => 'XMLHttpRequest', 'Content-Type' => 'application/json'])
    {
        try {
            return json_decode(self::$http->request('POST', $route, ['headers' => $header, 'json' => $json])->getBody()->getContents());
        } catch (GuzzleException $e) {
            switch ($e->getCode()) {
                case 401:
                    throw new ExpiredJwtException($e->getMessage());
                    break;
                case 404:
                    throw new NotFoundException($e->getMessage());
                    break;
                case 500:
                    throw new InternalServerErrorException($e->getMessage());
                    break;
                default:
                    throw new GenericException($e->getMessage());
                    break;
            }
        }
    }

    /**
     * Generic function to send HTTP DELETE requests
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
            switch ($e->getCode()) {
                case 401:
                    throw new ExpiredJwtException($e->getMessage());
                    break;
                case 404:
                    throw new NotFoundException($e->getMessage());
                    break;
                case 500:
                    throw new InternalServerErrorException($e->getMessage());
                    break;
                default:
                    throw new GenericException($e->getMessage());
                    break;
            }
        }
    }

    /**
     * Guzzle Legacy POST
     *
     * @param $route
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function legacyPost($route, $args)
    {
        return self::$http->post($route, $args);
    }
}