<?php

/**
 *
 * OneRoster class
 *
 * @copyright Apereo
 * @category OpenLRW
 * @package  Entity
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

abstract class OneRoster
{

    const PREFIX = 'api/';

    /**
     * Create a header for HTTP Request to OneRoster routes.
     *
     * @return array
     */
    protected function generateHeader()
    {
        return [
        'X-Requested-With' => 'XMLHttpRequest',
        'Authorization' => 'Bearer ' . ApiClient::makeJWT()
        ];
    }

    protected function get($route)
    {
        $header = $this->generateHeader();
        return ApiClient::$http->get(self::PREFIX . $route, $header);
    }

    protected function post($route, $data)
    {
        $header = $this->generateHeader();
        return ApiClient::$http->post(self::PREFIX . $route, $header, $data);
    }

    protected function patch($route, $data)
    {
        $header = $this->generateHeader();
        return ApiClient::$http->patch(self::PREFIX . $route, $header, $data);
    }

    protected function delete($route)
    {
        $header = $this->generateHeader();
        return ApiClient::$http->delete(self::PREFIX . $route, $header);
    }
}
