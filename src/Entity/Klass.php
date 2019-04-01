<?php

/**
 *
 * Class entity
 *
 * @copyright Apereo
 * @category OpenLRW
 * @package  Entity
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

namespace OpenLRW\Entity;


class Klass extends OneRoster
{

    public static function find(String $id)
    {
        return parent::get("classes/$id");
    }

    public static function enrollments(String $id)
    {
        return parent::get("classes/$id/enrollments");
    }

    public static function events(String $id)
    {
        return parent::get("classes/$id/events/stats");
    }

    public static function eventsForUser(String $id, String $userId)
    {
        return parent::get("classes/$id/events/user/$userId");
    }

    public static function resultsForUser(String $id, String $userId)
    {
        return parent::get("classes/$id/results/user/$userId");
    }

    public static function lineItems(String $id) {
        return parent::get("classes/$id/lineitems");
    }

}