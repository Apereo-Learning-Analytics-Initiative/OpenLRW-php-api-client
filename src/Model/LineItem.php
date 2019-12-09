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

use OpenLRW\Exception\NotFoundException;

class LineItem extends OneRoster
{

    protected static $collection = 'lineitems';

    protected $fillable = [
        'sourcedId',
        'status',
        'metadata',
        'dateLastModified',
        'title',
        'description',
        'assignDate',
        'DueDate',
        'resultValueMin"',
        'resultValueMax',
        'class',
        'category',
    ];

    /**
     * Override due to lineItem json structure (contains a lineItem array)
     * @param $id
     * @return OneRoster
     */
    public static function find($id){
        $lineItem = parent::httpGet(static::$collection . "/$id");
        return $lineItem->lineItem;
    }
}