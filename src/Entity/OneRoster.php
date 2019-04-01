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

use OpenLRW\OpenLRW;
use OpenLRW\Exception\InternalServerErrorException;

abstract class OneRoster
{

    const PREFIX = 'api/';

    /**
     * @return array
     */
    protected static function generateHeader(): array
    {
        try {
            $jwt = OpenLRW::smartJwt();
        } catch (\Exception $e) {
            throw new InternalServerErrorException('Impossible to create a JWT. Server might be down or you provided invalid credentials.');
        }

        return [
        'X-Requested-With' => 'XMLHttpRequest',
        'Authorization' => "Bearer $jwt"
        ];
    }

    public static function get($route)
    {
        $header = self::generateHeader();
        return OpenLRW::httpGet(self::PREFIX . $route, $header);
    }

    public static function post($route, $data)
    {
        $header = self::generateHeader();
        return OpenLRW::httpPost(self::PREFIX . $route, $header, $data);
    }

    public static function patch($route, $data)
    {
        $header = self::generateHeader();
        return OpenLRW::httpPatch(self::PREFIX . $route, $header, $data);
    }

    public static function delete($route)
    {
        $header = self::generateHeader();
        return OpenLRW::httpDelete(self::PREFIX . $route, $header);
    }
}
