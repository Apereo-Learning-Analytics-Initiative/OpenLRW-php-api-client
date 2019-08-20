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

namespace OpenLRW\Model;

class Risk extends OneRoster
{
    protected static $collection = 'risk';

    protected $fillable = [
        'sourcedId',
        'userSourcedId',
        'classSourcedId',
        'modelType',
        'score',
        'name',
        'velocity',
        'dateTime',
        'active',
        'metadata'
    ];

    public static function findByClassAndUser(String $classId, String $userId)
    {
        return parent::get("risks/classes/$classId/users/$userId");
    }

    public static function latestByClassAndUser(String $classId, String $userId)
    {
        return parent::get("risks/classes/$classId/users/$userId?date=latest");
    }

    public static function findByClassAndUserAndDate(String $classId, String $userId, String $date)
    {
        return parent::get("risks/classes/$classId/users/$userId?date=$date");
    }

}