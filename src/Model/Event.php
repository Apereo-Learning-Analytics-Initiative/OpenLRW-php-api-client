<?php

/**
 *
 * Event class
 *
 * @copyright Apereo
 * @category OpenLRW
 * @package  Entity
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */


namespace OpenLRW\Model;

 use DateTime;
 use OpenLRW\OpenLRW;
 use OpenLRW\Exception\GenericException;

 class Event extends Model
{

    private static function postCaliper($data)
    {
        $header =  [
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'application/json',
            'Authorization' =>  OpenLRW::getKey()
        ];

        return OpenLRW::guzzlePost('key/caliper', ['headers' => $header, 'body' => $data])->getStatusCode();
    }


     /**
      * Create and send Caliper Event
      *
      * @param $userId
      * @param $action
      * @param string $applicationName
      * @param string $description
      * @param string $groupId
      * @return string
      */
     public static function caliperFactory($userId, $action, $description = '', $groupId =  'null', $applicationName = 'php-api-client')
     {
         $date = date_format(new DateTime('NOW'), 'Y-m-d\TH:i:s.755\Z');
         $eventId = sha1($userId . $date);
         $json = '
        {
        	"data": [
        	 {
                "@context": "http://purl.imsglobal.org/ctx/caliper/v1p1",
                "@type": "Event",
                "action": "' . $action . '",
                "actor": {
                    "@id": "' . $userId . '",
                    "@type": "Person"
                },
                "eventTime": "' . $date . '",
                "object": {
                    "@id": "' . $eventId . '",
                    "@type": "SoftwareApplication",
                    "name": "' . $applicationName . '",
                    "description": "' . $description . '"
                 },
                "group": { 
                    "@id": "' . $groupId . '",
                    "@type": "Group"
                }
            }
        	],
        	 "sendTime": "' . $date . '",
             "sensor": "http://localhost/web/php-api-client"
        }';

         try {
             return self::postCaliper($json);
         } catch (\Exception $e) {
             throw new GenericException($e->getMessage());
         }
     }


 }