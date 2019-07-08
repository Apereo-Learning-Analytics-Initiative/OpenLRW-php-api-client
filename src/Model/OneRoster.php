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
use Symfony\Component\Debug\Exception\UndefinedFunctionException;

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

    protected static function find($id)
    {
        $header = self::generateHeader();
        $json = OpenLRW::httpGet(self::PREFIX . static::$collection . "/$id", $header);
        return new static((array)$json);
    }

    public static function getClassName(){
        return (new \ReflectionClass(get_called_class()))->getShortName();
    }

    /**
     * Return the real content of a OneRoster object
     *
     * @param $object
     * @return mixed
     */
    protected static function extract($object)
    {
        try {
            $name = mb_strtolower(self::getClassName());
            return $object->$name;
        } catch (\ErrorException $e) {
            return $object;
        }

    }

    /**
     * Return a list of objects
     *
     * @return array
     */
    protected static function all()
    {
        $header = self::generateHeader();
        $json_array = OpenLRW::httpGet(self::PREFIX . static::$collection, $header);
        $results = [];
        foreach ($json_array as $json) {
            $object = self::extract($json);
            $results[] = new static((array)$object);;
        }

        return $results;
    }

    protected static function save($data = null)
    {
        if ($data === null) {
            $data = static::toJson();
        }
        $header = self::generateHeader();
        return OpenLRW::httpPost(self::PREFIX . static::$collection, $header, $data);
    }

    protected static function update($id, $data)
    {
        $header = self::generateHeader();
        return OpenLRW::httpPatch(self::PREFIX . static::$collection ."/$id", $header, $data);
    }


    /**
     * Destroy the model for the given ID.
     *
     * @return int
     */
    protected static function destroy($id)
    {
        $header = self::generateHeader();
        return OpenLRW::httpDelete(self::PREFIX . static::$collection . "/$id", $header);
    }

    /**
     * Delete the model from the database.
     *
     */
    protected function delete()
    {
        return self::destroy($this->getPrimaryKeyValue());
    }

    /**
     * HTTP Get that returns a generic array
     *
     * @param $route
     * @return mixed|null
     */
    protected static function httpGet($route)
    {
        $header = self::generateHeader();
        return OpenLRW::httpGet(self::PREFIX . $route, $header);
    }

    /**
     * HTTP Get that returns an object or a collection of objects
     *
     * @param $route
     * @param $class the type of the object wanted
     * @return mixed
     */
    protected static function get($route, $class) {
        $header = self::generateHeader();
        $json = OpenLRW::httpGet(self::PREFIX . $route, $header);
        if (count($json) < 2 ) {
            return new static ((array)$json[0]);
        } else {
            $results = [];
            foreach ($json as $item) {
                $object = self::extract($item);
                $results[] = new $class((array)$object);
            }

            return $results;
        }

    }


    protected static function post($route, $data)
    {
        $header = self::generateHeader();
        return OpenLRW::httpPost(self::PREFIX . $route, $header, $data);
    }
}
