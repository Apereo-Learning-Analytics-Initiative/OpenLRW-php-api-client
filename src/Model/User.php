<?php

/**
 *
 * User entity
 *
 * @copyright Apereo
 * @category OpenLRW
 * @package  Entity
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

namespace OpenLRW\Model;

class User extends OneRoster
{

    protected static $collection = 'users';

    protected $fillable = [
        'sourcedId',
        'status',
        'metadata',
        'username',
        'userId',
        'givenName',
        'familyName',
        'role',
        'identifier"',
        'email',
        'sms',
        'phone',
        'password',
        'dateLastModified',
        'userEnabled',
        'grades',
        'middleName',
        'userIds'
    ];


    public static function enrollments(String $id)
    {
        return parent::httpGet(static::$collection . "/$id/enrollments");
    }

    public static function events(String $id)
    {
        return parent::httpGet(static::$collection . "/$id/events");
    }

    public static function eventsFrom(String $id, String $from)
    {
        return parent::httpGet(static::$collection . "/$id/events?from=$from");
    }

    public static function eventsFromTo(String $id, String $from, String $to)
    {
        return parent::httpGet(static::$collection . "/$id/events?from=$from&to=$to");
    }

}