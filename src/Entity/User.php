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

namespace OpenLRW\Entity;

use OpenLRW\Entity\OneRoster;

class User extends OneRoster
{

    public static function find(String $id)
    {
        return parent::get("users/$id");
    }

    public static function update(String $id,  $json)
    {
        return parent::patch("users/$id", $json);
    }

    public static function enrollments(String $id)
    {
        return parent::get("users/$id/enrollments");
    }

    public static function events(String $id)
    {
        return parent::get("users/$id/events");
    }

    public static function eventsFrom(String $id, String $from)
    {
        return parent::get("users/$id/events?from=$from");
    }

    public static function eventsFromTo(String $id, String $from, String $to)
    {
        return parent::get("users/$id/events?from=$from&to=$to");
    }

}