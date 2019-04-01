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

namespace OpenLRW\Entity;

use OpenLRW\ApiClient;

abstract class OneRoster
{

    const PREFIX = 'api/';

    protected static function generateHeader()
    {
        $jwt = ApiClient::smartJwt();

        return [
        'X-Requested-With' => 'XMLHttpRequest',
        'Authorization' => "Bearer $jwt"
        ];
    }

    public static function get($route)
    {
        $header = self::generateHeader();
        return ApiClient::httpGet(self::PREFIX . $route, $header);
    }

    public static function post($route, $data)
    {
        $header = self::generateHeader();
        return ApiClient::httpPost(self::PREFIX . $route, $header, $data);
    }

    public static function patch($route, $data)
    {
        $header = self::generateHeader();
        return ApiClient::httpPatch(self::PREFIX . $route, $header, $data);
    }

    public static function delete($route)
    {
        $header = self::generateHeader();
        return ApiClient::httpDelete(self::PREFIX . $route, $header);
    }
}
