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

namespace OpenLRW\Model;

use OpenLRW\OpenLRW;
use OpenLRW\Exception\InternalServerErrorException;

abstract class OneRoster extends Model
{

    const PREFIX = 'api/';

    protected static $collection;

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

    public static function find($id)
    {
        $header = self::generateHeader();
        $json = OpenLRW::httpGet(self::PREFIX . static::$collection . "/$id", $header);
        return new static((array)$json);
    }

    public static function all()
    {
        $header = self::generateHeader();
        $json_array = OpenLRW::httpGet(self::PREFIX . static::$collection, $header);
        $results = [];
        foreach ($json_array as $json) {
            $results[] = new static((array)$json);
        }

        return $results;
    }

    public static function save($data = null)
    {
        if ($data === null) {
            $data = static::toJson();
        }
        $header = self::generateHeader();
        return OpenLRW::httpPost(self::PREFIX . static::$collection, $header, $data);
    }

    public static function update($id, $data)
    {
        $header = self::generateHeader();
        return OpenLRW::httpPatch(self::PREFIX . static::$collection ."/$id", $header, $data);
    }


    /**
     * Destroy the model for the given ID.
     *
     * @return int
     */
    public static function destroy($id)
    {
        $header = self::generateHeader();
        return OpenLRW::httpDelete(self::PREFIX . static::$collection . "/$id", $header);
    }

    /**
     * Delete the model from the database.
     *
     */
    public function delete()
    {
        return self::destroy($this->getPrimaryKeyValue());
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
}
